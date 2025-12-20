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
            // Validasi bahwa contact_id ada dan post forum ada
            $contact = Contact::findOrFail($request->contact_id);

            // Pastikan postingan forum tersebut approved
            if ($contact->type !== 'forum' || $contact->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Postingan forum tidak ditemukan atau belum disetujui.'
                ], 404);
            }

            // Simpan reply
            $reply = ForumReply::create([
                'contact_id' => $request->contact_id,
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'status' => 'pending', // Default pending, perlu approval admin
            ]);

            // Log success
            \Log::info('Forum reply created', [
                'reply_id' => $reply->id,
                'contact_id' => $request->contact_id,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Balasan Anda berhasil dikirim dan menunggu persetujuan admin.'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Postingan forum tidak ditemukan.'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Forum Reply Store Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get replies for a contact (AJAX)
     */
    public function getReplies($contactId)
    {
        try {
            // Pastikan contact ada dan approved
            $contact = Contact::where('id', $contactId)
                ->where('type', 'forum')
                ->where('status', 'approved')
                ->firstOrFail();

            $replies = ForumReply::where('contact_id', $contactId)
                                 ->where('status', 'approved')
                                 ->orderBy('created_at', 'asc') // Tampilkan yang lama dulu
                                 ->get();

            // Format data untuk response
            $formattedReplies = $replies->map(function($reply) {
                return [
                    'id' => $reply->id,
                    'name' => $reply->name,
                    'email' => $reply->email,
                    'message' => $reply->message,
                    'created_at' => $reply->created_at->diffForHumans(),
                    'avatar_initials' => $this->getInitials($reply->name),
                ];
            });

            return response()->json([
                'success' => true,
                'replies' => $formattedReplies,
                'count' => $replies->count(),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::warning('Contact not found for replies', ['contact_id' => $contactId]);

            return response()->json([
                'success' => false,
                'message' => 'Postingan forum tidak ditemukan.',
                'replies' => [],
                'count' => 0
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Get Replies Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil balasan.',
                'replies' => [],
                'count' => 0
            ], 500);
        }
    }

    /**
     * Helper function to get initials from name
     */
    private function getInitials($name)
    {
        $names = explode(' ', $name);
        $initials = '';
        foreach($names as $n) {
            if(!empty(trim($n))) {
                $initials .= strtoupper(substr(trim($n), 0, 1));
            }
        }
        return substr($initials, 0, 2) ?: 'GU';
    }
}
