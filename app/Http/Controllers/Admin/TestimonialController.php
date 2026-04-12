<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials
     */
    public function index(Request $request)
    {
        // HANYA ambil yang type = 'testimonial' menggunakan scope dari model
        $query = Contact::testimonial()->with('approver');

        // Search filter
        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('message', 'like', "%$search%")
                  ->orWhere('institution', 'like', "%$search%");
            });
        }

        // Status filter
        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Rating filter
        if($request->has('rating') && $request->rating != 'all' && $request->rating != '') {
            if($request->rating == 'null') {
                $query->whereNull('rating');
            } else {
                $query->where('rating', $request->rating);
            }
        }

        $testimonials = $query->latest()->paginate(10);

        // Stats - HANYA untuk testimonial menggunakan scope dari model
        $stats = [
            'total' => Contact::testimonial()->count(),
            'approved' => Contact::testimonial()->approved()->count(),
            'rejected' => Contact::testimonial()->rejected()->count(),
            'pending' => Contact::testimonial()->pending()->count(),
        ];

        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }

    /**
     * Store a newly created testimonial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'institution' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:approved,rejected',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'institution' => $validated['institution'] ?? null,
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? null,
            'type' => 'testimonial',
            'status' => $validated['status'],
            'approved_at' => $validated['status'] == 'approved' ? now() : null,
            'approved_by' => $validated['status'] == 'approved' ? auth()->id() : null,
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan!');
    }

    /**
     * Approve a testimonial
     */
    public function approve($id)
    {
        $testimoni = Contact::testimonial()->findOrFail($id);

        $testimoni->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return back()->with('success', 'Testimoni disetujui');
    }

    public function reject($id)
    {
        $testimoni = Contact::testimonial()->findOrFail($id);

        $testimoni->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return back()->with('success', 'Testimoni ditolak');
    }

    /**
     * Delete a testimonial
     */
    public function destroy($id)
    {
        $testimonial = Contact::testimonial()->findOrFail($id);
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus!');
    }

    /**
     * Update rating testimonial via AJAX
     */
    public function updateRating(Request $request, $id)
    {
        try {
            $testimonial = Contact::testimonial()->findOrFail($id);

            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
            ]);

            $testimonial->rating = $request->rating;
            $testimonial->save();

            return response()->json([
                'success' => true,
                'message' => 'Rating berhasil diperbarui',
                'rating' => $testimonial->rating
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui rating: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete testimonials
     */
    public function bulkDelete(Request $request)
    {
        try {
            // Cek apakah menggunakan parameter 'ids' (JSON) atau 'selected_ids' (string comma)
            if ($request->has('ids')) {
                $ids = json_decode($request->ids, true);
            } else if ($request->has('selected_ids')) {
                $ids = $this->parseSelectedIds($request->selected_ids);
            } else {
                return redirect()->route('admin.testimonials.index')->with('error', 'Tidak ada testimoni yang dipilih!');
            }

            if (empty($ids)) {
                return redirect()->route('admin.testimonials.index')->with('error', 'Tidak ada testimoni yang valid untuk dihapus!');
            }

            $deleted = Contact::whereIn('id', $ids)
                ->testimonial()
                ->delete();

            if ($deleted > 0) {
                return redirect()->route('admin.testimonials.index')->with('success', $deleted . ' testimoni berhasil dihapus!');
            } else {
                return redirect()->route('admin.testimonials.index')->with('error', 'Tidak ada testimoni yang terhapus.');
            }

        } catch (\Exception $e) {
            Log::error('BULK DELETE ERROR:', ['message' => $e->getMessage()]);
            return redirect()->route('admin.testimonials.index')->with('error', 'Gagal menghapus testimoni: ' . $e->getMessage());
        }
    }

    /**
     * Bulk approve testimonials
     */
    public function bulkApprove(Request $request)
    {
        $ids = $this->parseSelectedIds($request->selected_ids);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada ID yang valid untuk disetujui!');
        }

        $updated = Contact::whereIn('id', $ids)
            ->testimonial()
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

        return back()->with('success', $updated . ' testimoni berhasil disetujui!');
    }

    /**
     * Bulk reject testimonials
     */
    public function bulkReject(Request $request)
    {
        $ids = $this->parseSelectedIds($request->selected_ids);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada ID yang valid untuk ditolak!');
        }

        $updated = Contact::whereIn('id', $ids)
            ->testimonial()
            ->update([
                'status' => 'rejected',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

        return back()->with('success', $updated . ' testimoni berhasil ditolak!');
    }

    /**
     * Helper method to parse and validate selected IDs
     */
    private function parseSelectedIds($idsString)
    {
        if (empty($idsString)) {
            return [];
        }

        $ids = explode(',', $idsString);
        $ids = array_filter($ids, function($id) {
            $id = trim($id);
            return !empty($id) && is_numeric($id) && $id > 0;
        });
        $ids = array_map('intval', $ids);
        $ids = array_unique($ids);

        return $ids;
    }

    /**
     * Download CSV (tanpa file baru)
     */
    public function downloadCSV(Request $request)
    {
        $query = Contact::testimonial();

        // Apply filters sama seperti di index
        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('message', 'like', "%$search%");
            });
        }
        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        if($request->has('rating') && $request->rating != 'all' && $request->rating != '') {
            if($request->rating == 'null') {
                $query->whereNull('rating');
            } else {
                $query->where('rating', $request->rating);
            }
        }

        $testimonials = $query->latest()->get();

        // Buat CSV content
        $csvContent = "Nama,Email,Rating,Pesan Testimoni,Tanggal,Status\n";

        foreach ($testimonials as $t) {
            $rating = $t->rating ?? 'Belum ada rating';
            $status = $t->status == 'approved' ? 'Disetujui' : ($t->status == 'rejected' ? 'Ditolak' : 'Menunggu');

            $csvContent .= "\"" . addslashes($t->name) . "\",";
            $csvContent .= "\"" . addslashes($t->email) . "\",";
            $csvContent .= "\"$rating\",";
            $csvContent .= "\"" . addslashes($t->message) . "\",";
            $csvContent .= "\"" . $t->created_at->format('d/m/Y H:i') . "\",";
            $csvContent .= "\"$status\"\n";
        }

        // Download langsung tanpa file
        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="testimonials_' . date('Y-m-d_His') . '.csv"');
    }

    /**
     * Download PDF (tanpa file baru, langsung dari browser)
     */
    public function downloadPDF(Request $request)
    {
        $query = Contact::testimonial();

        // Apply filters
        if($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('message', 'like', "%$search%");
            });
        }
        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        if($request->has('rating') && $request->rating != 'all' && $request->rating != '') {
            if($request->rating == 'null') {
                $query->whereNull('rating');
            } else {
                $query->where('rating', $request->rating);
            }
        }

        $testimonials = $query->latest()->get();

        // Generate HTML untuk PDF
        $html = $this->generatePDFHTML($testimonials, $request);

        // Gunakan HTML2PDF via JavaScript di browser
        // Atau kembalikan HTML yang bisa di-print ke PDF
        return view('admin.testimonials.pdf-export', compact('testimonials', 'request'))->render();
    }

    public function show($id)
    {
        $testimonial = Contact::testimonial()->with('approver')->findOrFail($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function updateNotes(Request $request, $id)
    {
        $testimonial = Contact::testimonial()->findOrFail($id);

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $testimonial->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Catatan admin berhasil diperbarui!');
    }
}
