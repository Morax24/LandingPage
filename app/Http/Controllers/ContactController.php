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
        $testimonials = Contact::approved()
                              ->with('replies')
                              ->whereNotNull('message')
                              ->where('message', '!=', '')
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
            'heroMedia',
            'backgroundMedia',
            'featuresMedia',
            'aktivitasMedia'
        ));
    }

    /**
     * Simpan pesan contact dari form (support AJAX dan regular)
     *
     * Validation Rules:
     * - name: required, max 255
     * - email: required, email format, max 255
     * - institution: optional, max 255
     * - message: required, max 2000
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'institution' => 'nullable|string|max:255',
                'message' => 'required|string|max:2000',
            ]);

            // Create contact record
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'institution' => $validated['institution'] ?? null,
                'message' => $validated['message'],
                'status' => 'pending',
            ]);

            Log::info('Contact message saved successfully', [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
            ]);

            // Check if request is AJAX
            $isAjax = $request->ajax() || $request->wantsJson() ||
                     ($request->header('X-Requested-With') === 'XMLHttpRequest');

            if ($isAjax) {
                // Return JSON response for AJAX
                return response()->json([
                    'success' => true,
                    'message' => 'Terima kasih! Pesan Anda telah terkirim dan akan ditinjau oleh admin.',
                    'data' => [
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'email' => $contact->email,
                        'created_at' => $contact->created_at->format('d M Y H:i'),
                    ]
                ], 200);
            }

            // Return redirect for regular form submission
            return redirect()
                ->back()
                ->with('success', 'Terima kasih! Pesan Anda telah terkirim dan akan ditinjau oleh admin.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation error
            $errorMessage = $e->validator->errors()->first();

            Log::warning('Contact form validation failed', [
                'errors' => $e->validator->errors()->all(),
                'input' => $request->except(['_token']),
            ]);

            // Check if request is AJAX
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
            // General error
            Log::error('Failed to save contact message', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token']),
            ]);

            // Check if request is AJAX
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
     * (Bisa dipindah ke Form Request jika diperlukan)
     */
    protected function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
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
        ];
    }
}
