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
            'status' => 'required|in:approved,rejected',
        ]);

        // PASTIKAN type = 'testimonial' untuk admin
        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'institution' => $validated['institution'] ?? null,
            'message' => $validated['message'],
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
        // Pastikan hanya testimonial menggunakan scope dari model
        $testimonial = Contact::testimonial()->findOrFail($id);

        $testimonial->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Testimoni disetujui!');
    }

    /**
     * Reject a testimonial
     */
    public function reject($id)
    {
        // Pastikan hanya testimonial menggunakan scope dari model
        $testimonial = Contact::testimonial()->findOrFail($id);

        $testimonial->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Testimoni ditolak!');
    }

    /**
     * Delete a testimonial
     */
    public function destroy($id)
    {
        // Pastikan hanya testimonial menggunakan scope dari model
        $testimonial = Contact::testimonial()->findOrFail($id);
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus!');
    }

    // ============================================
    // BULK ACTIONS
    // ============================================

    /**
     * Bulk approve testimonials
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = $this->parseSelectedIds($request->selected_ids);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada ID yang valid untuk disetujui!');
        }

        // Filter hanya testimoni yang ada dan tipe testimonial
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
        $request->validate([
            'selected_ids' => 'required|string',
        ]);

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
     * Bulk delete testimonials - PERBAIKAN UTAMA
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'selected_ids' => 'required|string',
            ]);

            $ids = $this->parseSelectedIds($request->selected_ids);

            if (empty($ids)) {
                return back()->with('error', 'Tidak ada testimoni yang valid untuk dihapus!');
            }

            // Hitung sebelum menghapus untuk debug
            $countBefore = Contact::whereIn('id', $ids)->testimonial()->count();

            // Debug log
            Log::info('BULK DELETE - Deleting testimonials:', [
                'ids' => $ids,
                'count_before' => $countBefore,
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name
            ]);

            $deleted = Contact::whereIn('id', $ids)
                ->testimonial()
                ->delete();

            // Debug log setelah delete
            Log::info('BULK DELETE - Deleted testimonials:', [
                'deleted_count' => $deleted,
                'remaining_count' => Contact::testimonial()->count()
            ]);

            if ($deleted > 0) {
                return back()->with('success', $deleted . ' testimoni berhasil dihapus!');
            } else {
                return back()->with('error', 'Tidak ada testimoni yang terhapus. Pastikan testimoni yang dipilih berjenis testimonial.');
            }

        } catch (\Exception $e) {
            Log::error('BULK DELETE ERROR:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'selected_ids' => $request->selected_ids ?? 'empty'
            ]);

            return back()->with('error', 'Gagal menghapus testimoni: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to parse and validate selected IDs
     */
    private function parseSelectedIds($idsString)
    {
        $ids = explode(',', $idsString);

        // Bersihkan array dari nilai kosong dan non-numeric
        $ids = array_filter($ids, function($id) {
            $id = trim($id);
            return !empty($id) && is_numeric($id) && $id > 0;
        });

        // Konversi ke integer
        $ids = array_map('intval', $ids);

        // Hapus duplikat
        $ids = array_unique($ids);

        return $ids;
    }

    /**
     * Show testimonial details (optional - jika diperlukan)
     */
    public function show($id)
    {
        $testimonial = Contact::testimonial()->with('approver')->findOrFail($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Update admin notes (optional - jika diperlukan)
     */
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
