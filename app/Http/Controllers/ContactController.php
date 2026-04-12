<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Tampilkan halaman landing dengan stats, testimonial, dan media
     */
    public function index()
    {
        // --- Statistik umum ---
        $totalInstitutions = Contact::whereNotNull('institution')
                                   ->where('institution', '!=', '')
                                   ->distinct('institution')
                                   ->count('institution');

        $approvedContacts = Contact::approved()->count();

        $stats = [
            'satisfaction' => 85,
            'schools' => max($totalInstitutions, 50),
            'students' => max($approvedContacts, 80),
            'understanding' => 87,
        ];

        // --- Testimonial (dengan replies) ---
        $testimonials = Contact::testimonial()
                              ->approved()
                              ->with('replies')
                              ->whereNotNull('message')
                              ->where('message', '!=', '')
                              ->latest('approved_at')
                              ->limit(6)
                              ->get();

        // --- Forum Posts ---
        $forumPosts = Contact::forum()
                            ->approved()
                            ->latest('approved_at')
                            ->limit(6)
                            ->get();

        // --- Media Section: Hero ---
        $heroMedia = Media::active()
                         ->forSection('hero')
                         ->ordered()
                         ->first();

        // --- Media Section: Background ---
        $backgroundMedia = Media::active()
                               ->forSection('background')
                               ->ordered()
                               ->first();

        // --- Media Section: Features (maks 4 item) ---
        $featuresMedia = Media::active()
                             ->forSection('features')
                             ->ordered()
                             ->take(4)
                             ->get();

        // --- Media Section: Aktivitas (maks 6 item) ---
        $aktivitasMedia = Media::active()
                              ->forSection('aktivitas')
                              ->ordered()
                              ->take(6)
                              ->get();

        return view('landing', compact(
            'stats',
            'testimonials',
            'forumPosts',
            'heroMedia',
            'backgroundMedia',
            'featuresMedia',
            'aktivitasMedia'
        ));
    }

    /**
     * Simpan pesan contact dari form (support AJAX dan regular)
     */
    public function store(Request $request)
    {
        try {
            // Validasi input - TAMBAHKAN VALIDASI RATING
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'institution' => 'nullable|string|max:255',
                'message' => 'required|string|max:2000',
                'type' => 'required|in:forum,testimonial',
                'rating' => 'nullable|integer|min:1|max:5', // <-- TAMBAHKAN INI
            ]);

            // Create contact record - TAMBAHKAN RATING
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'institution' => $validated['institution'] ?? null,
                'message' => $validated['message'],
                'rating' => $validated['rating'] ?? null, // <-- TAMBAHKAN INI
                'type' => $validated['type'],
                'status' => 'pending',
            ]);

            Log::info('Contact message saved successfully', [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'type' => $contact->type,
                'rating' => $contact->rating,
            ]);

            // Check if request is AJAX
            $isAjax = $request->ajax() || $request->wantsJson() ||
                     ($request->header('X-Requested-With') === 'XMLHttpRequest');

            $message = $contact->type == 'testimonial'
                ? 'Terima kasih! Testimoni Anda telah terkirim dan akan ditinjau oleh admin.'
                : 'Terima kasih! Pesan Anda telah terkirim dan akan ditinjau oleh admin.';

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'type' => $contact->type,
                        'rating' => $contact->rating,
                        'created_at' => $contact->created_at->format('d M Y H:i'),
                    ]
                ], 200);
            }

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();

            Log::warning('Contact form validation failed', [
                'errors' => $e->validator->errors()->all(),
                'input' => $request->except(['_token']),
            ]);

            $isAjax = $request->ajax() || $request->wantsJson() ||
                     ($request->header('X-Requested-With') === 'XMLHttpRequest');

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'errors' => $e->validator->errors()
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('error', $errorMessage);

        } catch (\Exception $e) {
            Log::error('Failed to save contact message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token']),
            ]);

            $isAjax = $request->ajax() || $request->wantsJson() ||
                     ($request->header('X-Requested-With') === 'XMLHttpRequest');

            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, terjadi kesalahan sistem. Silakan coba lagi.',
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Maaf, terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan daftar contact yang approved
     */
    public function approved()
    {
        $contacts = Contact::approved()
                          ->with('approver')
                          ->latest('approved_at')
                          ->paginate(15);

        return view('contact.approved', compact('contacts'));
    }

    /**
     * Get validation rules for contact form
     */
    protected function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'type' => 'required|in:forum,testimonial',
            'rating' => 'nullable|integer|min:1|max:5', // <-- TAMBAHKAN INI
        ];
    }

    /**
     * Get validation messages
     */
    protected function validationMessages()
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'institution.max' => 'Nama instansi maksimal 255 karakter.',
            'message.required' => 'Pesan/pertanyaan wajib diisi.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
            'type.required' => 'Tipe pesan wajib dipilih.',
            'type.in' => 'Tipe pesan tidak valid.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
        ];
    }
}
