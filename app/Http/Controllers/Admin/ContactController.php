<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Tampilkan semua contact messages (HANYA FORUM)
     */
    public function index(Request $request)
    {
        // HANYA tampilkan type='forum'
        $query = Contact::where('type', 'forum')->with('approver')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);

        // Hitung statistik HANYA untuk forum
        $stats = [
            'total' => Contact::where('type', 'forum')->count(),
            'pending' => Contact::where('type', 'forum')->where('status', 'pending')->count(),
            'approved' => Contact::where('type', 'forum')->where('status', 'approved')->count(),
            'rejected' => Contact::where('type', 'forum')->where('status', 'rejected')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Tampilkan detail contact (HANYA FORUM)
     */
    public function show($id)
    {
        // Pastikan hanya menampilkan type='forum'
        $contact = Contact::where('type', 'forum')->with('approver')->findOrFail($id);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Approve contact message (HANYA FORUM)
     */
    public function approve($id)
    {
        // Pastikan hanya untuk type='forum'
        $contact = Contact::where('type', 'forum')->findOrFail($id);

        if ($contact->isApproved()) {
            return redirect()
                ->back()
                ->with('info', 'Pesan ini sudah disetujui sebelumnya.');
        }

        $contact->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Pesan forum berhasil disetujui!');
    }

    /**
     * Reject contact message (HANYA FORUM)
     */
    public function reject(Request $request, $id)
    {
        // Pastikan hanya untuk type='forum'
        $contact = Contact::where('type', 'forum')->findOrFail($id);

        $contact->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'admin_notes' => $request->admin_notes ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Pesan forum berhasil ditolak.');
    }

    /**
     * Update admin notes (HANYA FORUM)
     */
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        // Pastikan hanya untuk type='forum'
        $contact = Contact::where('type', 'forum')->findOrFail($id);

        $contact->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Catatan admin berhasil diperbarui.');
    }

    /**
     * Hapus contact message (HANYA FORUM)
     */
    public function destroy($id)
    {
        // Pastikan hanya untuk type='forum'
        $contact = Contact::where('type', 'forum')->findOrFail($id);
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan forum berhasil dihapus.');
    }

    /**
     * Bulk approve (HANYA FORUM)
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        // Pastikan hanya approve contact dengan type='forum'
        Contact::whereIn('id', $request->ids)
            ->where('type', 'forum')
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan forum berhasil disetujui.');
    }

    /**
     * Bulk reject (HANYA FORUM)
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        // Pastikan hanya reject contact dengan type='forum'
        Contact::whereIn('id', $request->ids)
            ->where('type', 'forum')
            ->update([
                'status' => 'rejected',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan forum berhasil ditolak.');
    }

    /**
     * Bulk delete (HANYA FORUM)
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        // Pastikan hanya delete contact dengan type='forum'
        Contact::whereIn('id', $request->ids)
            ->where('type', 'forum')
            ->delete();

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan forum berhasil dihapus.');
    }
}
