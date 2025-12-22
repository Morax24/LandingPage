<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ForumReplyController extends Controller
{
    /**
     * Simpan reply baru
     */
    public function store(Request $request)
    {
        try {
            // Validasi custom (tanpa email required)
            $validator = Validator::make($request->all(), [
                'contact_id' => 'required|exists:contacts,id',
                'name' => 'required|string|max:255|min:3',
                'message' => 'required|string|min:5|max:500',
            ], [
                'contact_id.required' => 'ID kontak diperlukan',
                'contact_id.exists' => 'Postingan forum tidak ditemukan',
                'name.required' => 'Nama wajib diisi',
                'name.min' => 'Nama minimal 3 karakter',
                'name.max' => 'Nama maksimal 255 karakter',
                'message.required' => 'Komentar wajib diisi',
                'message.min' => 'Komentar minimal 5 karakter',
                'message.max' => 'Komentar maksimal 500 karakter',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Validasi bahwa contact_id ada dan post forum ada
            $contact = Contact::findOrFail($request->contact_id);

            // Pastikan postingan forum tersebut approved
            if ($contact->type !== 'forum' || $contact->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Postingan forum tidak ditemukan atau belum disetujui.'
                ], 404);
            }

            // Simpan reply langsung approved tanpa email validasi
            $reply = ForumReply::create([
                'contact_id' => $request->contact_id,
                'name' => trim($request->name),
                'email' => 'guest@waluyaland.com', // Email default
                'message' => trim($request->message),
                'status' => 'approved', // Langsung approved
                'approved_at' => now(),
            ]);

            Log::info('Forum reply created successfully', [
                'reply_id' => $reply->id,
                'contact_id' => $request->contact_id,
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Balasan Anda berhasil dikirim!',
                'reply' => [
                    'id' => $reply->id,
                    'name' => $reply->name,
                    'message' => $reply->message,
                    'created_at' => $reply->created_at->diffForHumans(),
                    'avatar_initials' => $this->getInitials($reply->name),
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Contact not found for reply', ['contact_id' => $request->contact_id ?? 'null']);

            return response()->json([
                'success' => false,
                'message' => 'Postingan forum tidak ditemukan.'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Forum Reply Store Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

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
                                 ->orderBy('created_at', 'asc')
                                 ->get();

            // Format data untuk response
            $formattedReplies = $replies->map(function($reply) {
                return [
                    'id' => $reply->id,
                    'name' => $reply->name,
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
            Log::warning('Contact not found for replies', ['contact_id' => $contactId]);

            return response()->json([
                'success' => false,
                'message' => 'Postingan forum tidak ditemukan.',
                'replies' => [],
                'count' => 0
            ], 404);

        } catch (\Exception $e) {
            Log::error('Get Replies Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

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
