<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Media;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // ==================== MEDIA FROM DATABASE ====================
        // Gunakan method static dari model Media
        $heroMedia = Media::getHeroMedia();
        $storyMedia = Media::getStoryMedia();
        $whyLearnMedia = Media::getWhyLearnMedia();
        $featuresMedia = Media::getFeaturesMedia();
        $aktivitasMedia = Media::getActivitiesMedia();
        $productsMedia = Media::getProductsMedia();

        // ==================== TESTIMONIALS ====================
        // HANYA yang type = 'testimonial'
        $testimonials = Contact::testimonial()
            ->approved()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // ==================== FORUM POSTS ====================
        // HANYA yang type = 'forum'
        $forumPosts = Contact::forum()
            ->approved()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ==================== STATS ====================
        $stats = [
            'satisfaction' => 85,
            'schools' => 50,
            'students' => 80,
            'understanding' => 87,
        ];

        // ==================== DEBUG LOG ====================
        if (app()->environment('local')) {
            \Log::info('Landing Page Data:', [
                'hero_media' => $heroMedia ? $heroMedia->title : 'None',
                'story_media' => $storyMedia ? $storyMedia->title : 'None',
                'why_learn_media' => $whyLearnMedia ? $whyLearnMedia->title : 'None',
                'features_count' => $featuresMedia->count(),
                'aktivitas_count' => $aktivitasMedia->count(),
                'products_count' => $productsMedia->count(),
                'testimonials_count' => $testimonials->count(),
                'forum_posts_count' => $forumPosts->count(),
            ]);
        }

        return view('landing', compact(
            'heroMedia',
            'storyMedia',
            'whyLearnMedia',
            'featuresMedia',
            'aktivitasMedia',
            'productsMedia',
            'testimonials',
            'forumPosts',
            'stats'
        ));
    }
}
