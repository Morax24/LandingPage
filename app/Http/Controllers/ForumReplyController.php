<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\Contact;
use App\Http\Requests\StoreForumReplyRequest;
use Illuminate\Http\Request;

class ForumReplyController extends Controller
{
    /**
     * Simpan reply baru
     */
    public function store(StoreForumReplyRequest $request)
    {
        try {
            ForumReply::create([
                'contact_id' => $request->contact_id,
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            return redirect()
                ->back()
                ->with('success', 'Komentar Anda berhasil dikirim dan menunggu persetujuan admin.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Get replies for a contact (AJAX)
     */
    public function getReplies($contactId)
    {
        $replies = ForumReply::where('contact_id', $contactId)
                             ->where('status', 'approved')
                             ->latest()
                             ->get();

        return response()->json([
            'success' => true,
            'replies' => $replies,
            'count' => $replies->count(),
        ]);
    }
}
