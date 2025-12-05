<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
{
    /**
     * Tampilkan semua replies
     */
    public function index(Request $request)
    {
        $query = ForumReply::with(['contact', 'approver'])->latest();

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $replies = $query->paginate(15);

        // Stats
        $stats = [
            'total' => ForumReply::count(),
            'pending' => ForumReply::pending()->count(),
            'approved' => ForumReply::approved()->count(),
        ];

        return view('admin.forum-replies.index', compact('replies', 'stats'));
    }

    /**
     * Approve reply
     */
    public function approve($id)
    {
        $reply = ForumReply::findOrFail($id);

        if ($reply->isApproved()) {
            return redirect()
                ->back()
                ->with('info', 'Reply ini sudah disetujui sebelumnya.');
        }

        $reply->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Reply berhasil disetujui!');
    }

    /**
     * Reject reply
     */
    public function reject($id)
    {
        $reply = ForumReply::findOrFail($id);

        $reply->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Reply berhasil ditolak.');
    }

    /**
     * Delete reply
     */
    public function destroy($id)
    {
        $reply = ForumReply::findOrFail($id);
        $reply->delete();

        return redirect()
            ->back()
            ->with('success', 'Reply berhasil dihapus.');
    }

    /**
     * Bulk approve
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:forum_replies,id'
        ]);

        ForumReply::whereIn('id', $request->ids)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' reply berhasil disetujui.');
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:forum_replies,id'
        ]);

        ForumReply::whereIn('id', $request->ids)->delete();

        return redirect()
            ->back()
            ->with('success', count($request->ids) . ' reply berhasil dihapus.');
    }
}
