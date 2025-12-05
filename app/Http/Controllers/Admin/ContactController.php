<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Tampilkan semua contact messages
     */
    public function index(Request $request)
    {
        $query = Contact::with('approver')->latest();

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

        // Hitung statistik
        $stats = [
            'total' => Contact::count(),
            'pending' => Contact::pending()->count(),
            'approved' => Contact::approved()->count(),
            'rejected' => Contact::rejected()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Tampilkan detail contact
     */
    public function show($id)
    {
        $contact = Contact::with('approver')->findOrFail($id);

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Approve contact message
     */
    public function approve($id)
    {
        $contact = Contact::findOrFail($id);

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
            ->with('success', 'Pesan berhasil disetujui!');
    }

    /**
     * Reject contact message
     */
    public function reject(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'admin_notes' => $request->admin_notes ?? null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Pesan berhasil ditolak.');
    }

    /**
     * Update admin notes
     */
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contact = Contact::findOrFail($id);

        $contact->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Catatan admin berhasil diperbarui.');
    }

    /**
     * Hapus contact message
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * Bulk approve
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        Contact::whereIn('id', $request->ids)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan berhasil disetujui.');
    }

    /**
     * Bulk reject
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        Contact::whereIn('id', $request->ids)
            ->update([
                'status' => 'rejected',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan berhasil ditolak.');
    }

    public function store(StoreContactRequest $request)
{
    try {
        Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'institution' => $request->input('institution'),
            'message' => $request->input('message'),
            'status' => 'pending',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Terima kasih! Pesan Anda telah terkirim dan akan ditinjau oleh admin.');

    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
    }
}

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contacts,id'
        ]);

        Contact::whereIn('id', $request->ids)->delete();

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' pesan berhasil dihapus.');
    }
}
