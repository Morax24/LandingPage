<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Media;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Kontak
        $totalContacts = Contact::count();
        $pendingContacts = Contact::where('status', 'pending')->count();
        $approvedContacts = Contact::where('status', 'approved')->count();
        $rejectedContacts = Contact::where('status', 'rejected')->count();

        // Statistik Media
        $totalMedia = Media::count();
        $totalMediaSize = Media::sum('file_size');
        $activeMedia = Media::where('is_active', 1)->count();
        $inactiveMedia = Media::where('is_active', 0)->count();

        // Statistik Balasan Forum
        $pendingReplies = ForumReply::where('status', 'pending')->count();

        // Aktivitas Terbaru
        $recentActivities = $this->getRecentActivities();

        // Kontak Terbaru
        $recentContacts = Contact::latest()->take(5)->get();

        // Media Terbaru
        $recentMedia = Media::with('uploader')->latest()->take(6)->get();

        $stats = [
            'total_contacts' => $totalContacts,
            'pending_contacts' => $pendingContacts,
            'approved_contacts' => $approvedContacts,
            'rejected_contacts' => $rejectedContacts,
            'total_media' => $totalMedia,
            'total_media_size' => $totalMediaSize,
            'active_media' => $activeMedia,
            'inactive_media' => $inactiveMedia,
            'pending_replies' => $pendingReplies,
        ];

        return view('admin.dashboard', compact('stats', 'recentActivities', 'recentContacts', 'recentMedia'));
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Ambil kontak terbaru
        $recentContacts = Contact::latest()->take(3)->get();
        foreach ($recentContacts as $contact) {
            $activities[] = [
                'type' => 'contact',
                'title' => 'Pesan baru dari ' . $contact->name,
                'time' => $contact->created_at->diffForHumans(),
                'contact' => $contact,
                'link' => route('admin.contacts.show', $contact->id)
            ];
        }

        // Ambil media terbaru
        $recentMedia = Media::latest()->take(2)->get();
        foreach ($recentMedia as $media) {
            $activities[] = [
                'type' => 'media',
                'title' => ($media->isImage() ? 'Gambar diupload: ' : 'Video diupload: ') . Str::limit($media->title, 25),
                'time' => $media->created_at->diffForHumans(),
                'media' => $media,
                'link' => route('admin.media.index')
            ];
        }

        // Ambil balasan forum terbaru
        $recentReplies = ForumReply::latest()->take(2)->get();
        foreach ($recentReplies as $reply) {
            $activities[] = [
                'type' => 'reply',
                'title' => 'Balasan forum baru',
                'time' => $reply->created_at->diffForHumans(),
                'reply' => $reply,
                'link' => route('admin.forum-replies.index')
            ];
        }

        // Urutkan berdasarkan waktu (yang terbaru pertama)
        usort($activities, function($a, $b) {
            $timeA = $this->getActivityTime($a);
            $timeB = $this->getActivityTime($b);
            return $timeB <=> $timeA;
        });

        return array_slice($activities, 0, 5);
    }

    /**
     * Helper untuk mendapatkan waktu dari aktivitas
     */
    private function getActivityTime($activity)
    {
        switch ($activity['type']) {
            case 'contact':
                return $activity['contact']->created_at;
            case 'media':
                return $activity['media']->created_at;
            case 'reply':
                return $activity['reply']->created_at;
            default:
                return now();
        }
    }

    /**
     * Get corrected file path for display
     */
    private function getCorrectedFilePath($filePath)
    {
        if (!$filePath) return null;

        // Remove base URL if present
        $cleanedPath = str_replace('http://127.0.0.1:8000/', '', $filePath);
        $cleanedPath = str_replace('http://localhost:8000/', '', $filePath);
        $cleanedPath = str_replace('https://', '', $cleanedPath);

        return $cleanedPath;
    }

    /**
     * Check if file actually exists
     */
    private function checkFileExists($filePath)
    {
        if (!$filePath) return false;

        $cleanedPath = $this->getCorrectedFilePath($filePath);

        // Check in storage
        $storagePath = storage_path('app/public/' . $cleanedPath);
        if (file_exists($storagePath)) {
            return true;
        }

        // Check in public storage
        $publicPath = public_path('storage/' . $cleanedPath);
        if (file_exists($publicPath)) {
            return true;
        }

        return false;
    }

    // Debug method untuk mengecek data
    public function debug()
    {
        $recentActivities = $this->getRecentActivities();

        $debugData = [
            'recent_activities' => [],
            'media_debug' => []
        ];

        foreach($recentActivities as $activity) {
            if ($activity['type'] == 'media' && isset($activity['media'])) {
                $media = $activity['media'];
                $debugData['recent_activities'][] = [
                    'type' => 'media',
                    'title' => $activity['title'],
                    'media_id' => $media->id,
                    'media_title' => $media->title,
                    'media_type' => $media->type,
                    'file_path' => $media->file_path,
                    'url' => $media->url,
                    'is_image' => $media->isImage(),
                    'is_video' => $media->isVideo(),
                    'link' => $activity['link']
                ];
            } else {
                $debugData['recent_activities'][] = $activity;
            }
        }

        // Debug semua media
        $allMedia = Media::select('id', 'title', 'file_path', 'type', 'is_active')->get();
        foreach($allMedia as $media) {
            $debugData['media_debug'][] = [
                'id' => $media->id,
                'title' => $media->title,
                'type' => $media->type,
                'file_path' => $media->file_path,
                'url' => $media->url,
                'is_image' => $media->isImage(),
                'is_video' => $media->isVideo()
            ];
        }

        return response()->json($debugData);
    }
}
