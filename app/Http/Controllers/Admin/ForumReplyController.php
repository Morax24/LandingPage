<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumReply;
use Illuminate\Http\Request;

class ForumReplyController extends Controller
{
    /**
     * Display a listing of the forum replies.
     */
    public function index()
    {
        $replies = ForumReply::with(['contact', 'approver'])
            ->latest()
            ->paginate(20);

        return view('admin.forum-replies.index', compact('replies'));
    }

    /**
     * Approve a forum reply.
     */
    public function approve($id)
    {
        try {
            $reply = ForumReply::findOrFail($id);

            $reply->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.forum-replies.index')
                ->with('success', 'Balasan forum berhasil disetujui.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.forum-replies.index')
                ->with('error', 'Gagal menyetujui balasan forum: ' . $e->getMessage());
        }
    }

    /**
     * Reject a forum reply.
     */
    public function reject($id)
    {
        try {
            $reply = ForumReply::findOrFail($id);

            $reply->update([
                'status' => 'rejected',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.forum-replies.index')
                ->with('success', 'Balasan forum berhasil ditolak.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.forum-replies.index')
                ->with('error', 'Gagal menolak balasan forum: ' . $e->getMessage());
        }
    }

    /**
     * Delete a forum reply.
     */
    public function destroy($id)
    {
        try {
            $reply = ForumReply::findOrFail($id);
            $reply->delete();

            return redirect()
                ->route('admin.forum-replies.index')
                ->with('success', 'Balasan forum berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.forum-replies.index')
                ->with('error', 'Gagal menghapus balasan forum: ' . $e->getMessage());
        }
    }

    /**
     * Bulk approve forum replies.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:forum_replies,id',
        ]);

        try {
            ForumReply::whereIn('id', $request->ids)
                ->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => auth()->id(),
                ]);

            return redirect()
                ->route('admin.forum-replies.index')
                ->with('success', count($request->ids) . ' balasan forum berhasil disetujui.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.forum-replies.index')
                ->with('error', 'Gagal menyetujui balasan forum: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete forum replies.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:forum_replies,id',
        ]);

        try {
            ForumReply::whereIn('id', $request->ids)->delete();

            return redirect()
                ->route('admin.forum-replies.index')
                ->with('success', count($request->ids) . ' balasan forum berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.forum-replies.index')
                ->with('error', 'Gagal menghapus balasan forum: ' . $e->getMessage());
        }
    }
}
