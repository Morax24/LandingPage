<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Media;
use App\Models\VisitorCounter;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // ==================== MEDIA FROM DATABASE ====================
        $heroMedia = Media::getHeroMedia();
        $storyMedia = Media::getStoryMedia();
        $whyLearnMedia = Media::getWhyLearnMedia();
        $featuresMedia = Media::getFeaturesMedia();
        $aktivitasMedia = Media::getActivitiesMedia();
        $productsMedia = Media::getProductsMedia();

        // ==================== TESTIMONIALS DENGAN FILTER RATING ====================
        $rating = $request->get('rating');

        // Query untuk testimonial - HANYA yang approved
        $testimonialsQuery = Contact::where('type', 'testimonial')
            ->where('status', 'approved');

        // Jika filter rating aktif, hanya tampilkan yang punya rating dan sesuai
        if ($rating && $rating !== 'all' && $rating !== '') {
            $testimonialsQuery->where('rating', (int)$rating);
        } else {
            // Jika filter 'all' atau tidak ada filter, tampilkan semua yang sudah memiliki rating
            $testimonialsQuery->whereNotNull('rating');
        }

        $testimonials = $testimonialsQuery->orderBy('created_at', 'desc')->get();

        // ==================== HITUNG JUMLAH PER RATING ====================
        $ratingCounts = [
            'all' => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->whereNotNull('rating')
                ->count(),
            5 => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->where('rating', 5)
                ->count(),
            4 => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->where('rating', 4)
                ->count(),
            3 => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->where('rating', 3)
                ->count(),
            2 => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->where('rating', 2)
                ->count(),
            1 => Contact::where('type', 'testimonial')
                ->where('status', 'approved')
                ->where('rating', 1)
                ->count(),
        ];

        // ==================== FORUM POSTS ====================
        $forumPosts = Contact::where('type', 'forum')
            ->where('status', 'approved')
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ==================== STATISTIK REAL TIME ====================

        // 1. Rata-rata rating testimoni (konversi ke persen, rating 1-5 = 20-100%)
        $avgRating = Contact::where('type', 'testimonial')
            ->where('status', 'approved')
            ->whereNotNull('rating')
            ->avg('rating');

        // Konversi rating ke persen (rating 5 = 100%, rating 4 = 80%, dst)
        $satisfactionRate = $avgRating ? round($avgRating * 20) : 85;

        // 2. Total pengunjung dari visitor_counter
        $totalVisitors = VisitorCounter::sum('count');
        $visitorDisplay = $totalVisitors ? number_format($totalVisitors) . '+' : '50+';

        // 3. Persentase testimoni yang disetujui (membantu pengalaman baru)
        $totalTestimonials = Contact::where('type', 'testimonial')->count();
        $approvedTestimonials = Contact::where('type', 'testimonial')->where('status', 'approved')->count();
        $helpPercentage = $totalTestimonials > 0 ? round(($approvedTestimonials / $totalTestimonials) * 100) : 80;

        // 4. Persentase pesan forum yang disetujui (meningkatkan pemahaman)
        $totalForumMessages = Contact::where('type', 'forum')->count();
        $approvedForumMessages = Contact::where('type', 'forum')->where('status', 'approved')->count();
        $understandingPercentage = $totalForumMessages > 0 ? round(($approvedForumMessages / $totalForumMessages) * 100) : 87;

        // 5. Data tambahan untuk ditampilkan di tooltip
        $stats = [
            // Stat 1 - Kepuasan user
            'satisfaction' => [
                'value' => $satisfactionRate,
                'label' => 'Kepuasan user dari rating testimoni',
                'detail' => '⭐ ' . ($avgRating ? number_format($avgRating, 1) : '0') . '/5.0 dari ' . $ratingCounts['all'] . ' testimoni'
            ],
            // Stat 2 - Sekolah & siswa (diganti total pengunjung)
            'visitors' => [
                'value' => $visitorDisplay,
                'label' => 'Total pengunjung website',
                'detail' => '📊 Data realtime dari ' . number_format($totalVisitors) . ' kunjungan'
            ],
            // Stat 3 - Membantu pengalaman baru
            'help' => [
                'value' => $helpPercentage,
                'label' => 'Testimoni yang membantu pengalaman baru',
                'detail' => '✅ ' . $approvedTestimonials . '/' . $totalTestimonials . ' testimoni disetujui'
            ],
            // Stat 4 - Meningkatkan pemahaman
            'understanding' => [
                'value' => $understandingPercentage,
                'label' => 'Pesan forum meningkatkan pemahaman',
                'detail' => '💬 ' . $approvedForumMessages . '/' . $totalForumMessages . ' pesan terjawab'
            ],
        ];

        // ==================== JIKA REQUEST AJAX ====================
        if ($request->ajax() || $request->wantsJson()) {
            // Gunakan method renderTestimonialsCarousel yang SUDAH TERFILTER
            $html = $this->renderTestimonialsCarousel($testimonials);
            return response()->json([
                'success' => true,
                'html' => $html,
                'ratingCounts' => $ratingCounts
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
            'stats',
            'ratingCounts'
        ));
    }

    /**
     * Render carousel testimonials - Method yang SAMA dengan Code 1 (BEKERJA dengan filter)
     */
    private function renderTestimonialsCarousel($testimonials)
    {
        if ($testimonials->count() == 0) {
            return '<div class="testimonial-carousel" id="testimonialCarousel">
                        <div class="carousel-slide active">
                            <div class="no-testimonials">
                                <h3>Belum ada testimoni</h3>
                                <p>Jadilah yang pertama memberikan testimoni tentang pengalaman Anda!</p>
                            </div>
                        </div>
                    </div>';
        }

        $itemsPerSlide = 5;
        $totalItems = $testimonials->count();
        $totalSlides = ceil($totalItems / $itemsPerSlide);

        $html = '<div class="testimonial-carousel" id="testimonialCarousel">';

        for ($slide = 0; $slide < $totalSlides; $slide++) {
            $activeClass = ($slide === 0) ? 'active' : '';
            $displayStyle = ($slide === 0) ? 'block' : 'none';

            $html .= '<div class="carousel-slide ' . $activeClass . '" data-slide="' . $slide . '" style="display: ' . $displayStyle . ';">';
            $html .= '<div class="testimonial-grid">';

            $slideItems = $testimonials->slice($slide * $itemsPerSlide, $itemsPerSlide);
            foreach ($slideItems as $testimonial) {
                // Ambil inisial nama
                $names = explode(' ', $testimonial->name);
                $initials = '';
                foreach ($names as $n) {
                    if (!empty(trim($n))) {
                        $initials .= strtoupper(substr(trim($n), 0, 1));
                    }
                }
                $initials = substr($initials, 0, 2) ?: 'GU';

                $html .= '<div class="testimonial-card">';
                $html .= '<div class="testimonial-header">';
                $html .= '<div class="testimonial-avatar">' . $initials . '</div>';
                $html .= '<div class="testimonial-info">';
                $html .= '<h4>' . e($testimonial->name) . '</h4>';
                $html .= '<div class="testimonial-institution">' . e($testimonial->institution ?? 'Pengguna') . '</div>';
                $html .= '<div class="testimonial-date">' . $testimonial->created_at->translatedFormat('d F Y') . '</div>';
                $html .= '</div></div>';

                // Rating stars
                $html .= '<div class="testimonial-rating"><div class="stars">';
                $ratingValue = $testimonial->rating ?? 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $ratingValue) {
                        $html .= '<span class="star-filled">★</span>';
                    } else {
                        $html .= '<span class="star-empty">★</span>';
                    }
                }
                $html .= '</div><span class="rating-number">' . ($ratingValue ? $ratingValue . '/5' : 'Belum dinilai') . '</span></div>';

                $html .= '<p class="testimonial-message">"' . e($testimonial->message) . '"</p>';
                $html .= '</div>';
            }

            $html .= '</div></div>';
        }

        $html .= '</div>';

        // Tambahkan tombol navigasi jika perlu
        if ($totalSlides > 1) {
            $html .= '<button class="carousel-btn prev-btn" onclick="prevTestimonialSlide()"><span>‹</span></button>';
            $html .= '<button class="carousel-btn next-btn" onclick="nextTestimonialSlide()"><span>›</span></button>';
            $html .= '<div class="carousel-dots" id="testimonialDots">';
            for ($i = 0; $i < $totalSlides; $i++) {
                $activeDot = ($i === 0) ? 'active' : '';
                $html .= '<span class="dot ' . $activeDot . '" onclick="goToTestimonialSlide(' . $i . ')"></span>';
            }
            $html .= '</div>';
        }

        return $html;
    }
}
