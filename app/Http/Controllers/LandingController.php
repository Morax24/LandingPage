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
        $heroMedia = Media::active()->forSection('hero')->ordered()->first();
        $storyMedia = Media::active()->forSection('story')->ordered()->first();
        $whyLearnMedia = Media::active()->forSection('whylearn')->ordered()->first();

        $featuresMedia = Media::active()->forSection('features')->ordered()->limit(4)->get();
        $aktivitasMedia = Media::active()->forSection('aktivitas')->ordered()->limit(6)->get();
        $productsMedia = Media::active()->forSection('products')->ordered()->limit(2)->get();

        // ==================== TESTIMONIALS ====================
        $testimonials = Contact::where('status', 'approved')
            ->latest()
            ->limit(8)
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
            'stats'
        ));
    }
}
