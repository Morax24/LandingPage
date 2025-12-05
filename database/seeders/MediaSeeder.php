<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@waluya.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        $mediaData = [
            // HERO SECTION
            [
                'title' => 'Drifting Demo',
                'description' => 'Video demonstrasi board game',
                'type' => 'video',
                'file_path' => 'media/1763390552_drifting-di-bunderan-hi-tantangan-besar-untuk-garasi-drift-dan-fitra-eri.mp4',
                'file_name' => 'drifting-video.mp4',
                'mime_type' => 'video/mp4',
                'file_size' => 5242880,
                'section' => 'hero',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],

            // STORY SECTION
            [
                'title' => 'Background Story',
                'description' => 'Cerita di balik Waluya Land',
                'type' => 'image',
                'file_path' => 'media/1763435257_screenshot-2024-12-21-213113.png',
                'file_name' => 'story-image.png',
                'mime_type' => 'image/png',
                'file_size' => 204800,
                'section' => 'story',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],

            // WHYLEARN SECTION
            [
                'title' => 'Belajar Kewirausahaan',
                'description' => 'Mengapa belajar melalui permainan papan',
                'type' => 'image',
                'file_path' => 'media/1763435325_screenshot-2025-08-26-195732.png',
                'file_name' => 'why-learn.png',
                'mime_type' => 'image/png',
                'file_size' => 256000,
                'section' => 'whylearn',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],

            // FEATURES SECTION (4 items)
            [
                'title' => 'Game Interaktif',
                'description' => 'Pengalaman belajar yang menyenangkan',
                'type' => 'image',
                'file_path' => 'media/1763420472_game.png',
                'file_name' => 'game-interactive.png',
                'mime_type' => 'image/png',
                'file_size' => 307200,
                'section' => 'features',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Puzzle Bisnis',
                'description' => 'Memecahkan tantangan bisnis',
                'type' => 'image',
                'file_path' => 'media/1763428970_puzzle.png',
                'file_name' => 'business-puzzle.png',
                'mime_type' => 'image/png',
                'file_size' => 281600,
                'section' => 'features',
                'order' => 2,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Simulasi Bisnis',
                'description' => 'Video simulasi situasi bisnis',
                'type' => 'video',
                'file_path' => 'media/1763551047_drifting-di-bunderan-hi-tantangan-besar-untuk-garasi-drift-dan-fitra-eri.mp4',
                'file_name' => 'business-simulation.mp4',
                'mime_type' => 'video/mp4',
                'file_size' => 10485760,
                'section' => 'features',
                'order' => 3,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Analisis Pasar',
                'description' => 'Belajar menganalisis pasar',
                'type' => 'image',
                'file_path' => 'media/1763647456_screenshot-2024-10-27-201427.png',
                'file_name' => 'market-analysis.png',
                'mime_type' => 'image/png',
                'file_size' => 332800,
                'section' => 'features',
                'order' => 4,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],

            // AKTIVITAS SECTION (6 items)
            [
                'title' => 'Aktivitas 1',
                'description' => 'Tutorial bermain game board',
                'type' => 'image',
                'file_path' => 'media/1763520501_screenshot-2025-11-18-152818.png',
                'file_name' => 'activity-1.png',
                'mime_type' => 'image/png',
                'file_size' => 358400,
                'section' => 'aktivitas',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Aktivitas 2',
                'description' => 'Diskusi kelompok',
                'type' => 'image',
                'file_path' => 'media/1763551717_screenshot-2025-06-24-185842.png',
                'file_name' => 'activity-2.png',
                'mime_type' => 'image/png',
                'file_size' => 409600,
                'section' => 'aktivitas',
                'order' => 2,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Aktivitas 3',
                'description' => 'Virtual background tutorial',
                'type' => 'video',
                'file_path' => 'media/1763642965_discover-15-virtual-background-zoom-and-zoom-background-design-ideas-education-resume-alumni-background-design-marketing-department-and-more.mp4',
                'file_name' => 'activity-3.mp4',
                'mime_type' => 'video/mp4',
                'file_size' => 15728640,
                'section' => 'aktivitas',
                'order' => 3,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Aktivitas 4',
                'description' => 'Presentasi bisnis',
                'type' => 'image',
                'file_path' => 'media/1763643016_screenshot-2024-09-22-093910.png',
                'file_name' => 'activity-4.png',
                'mime_type' => 'image/png',
                'file_size' => 281600,
                'section' => 'aktivitas',
                'order' => 4,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Aktivitas 5',
                'description' => 'Workshop kewirausahaan',
                'type' => 'image',
                'file_path' => 'media/1763643039_screenshot-2025-06-27-103131.png',
                'file_name' => 'activity-5.png',
                'mime_type' => 'image/png',
                'file_size' => 307200,
                'section' => 'aktivitas',
                'order' => 5,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Aktivitas 6',
                'description' => 'Grid layout tutorial',
                'type' => 'image',
                'file_path' => 'media/1763868738_grid-layout.png',
                'file_name' => 'activity-6.png',
                'mime_type' => 'image/png',
                'file_size' => 256000,
                'section' => 'aktivitas',
                'order' => 6,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],

            // PRODUCTS SECTION (2 items)
            [
                'title' => 'Waluya Land Board Game',
                'description' => 'Produk utama Waluya Land',
                'type' => 'image',
                'file_path' => 'media/1763420472_game.png',
                'file_name' => 'product-main.png',
                'mime_type' => 'image/png',
                'file_size' => 307200,
                'section' => 'products',
                'order' => 1,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Waluya Land Premium',
                'description' => 'Produk premium edition',
                'type' => 'image',
                'file_path' => 'media/1763428970_puzzle.png',
                'file_name' => 'product-premium.png',
                'mime_type' => 'image/png',
                'file_size' => 281600,
                'section' => 'products',
                'order' => 2,
                'is_active' => true,
                'uploaded_by' => $admin->id,
            ],
        ];

        foreach ($mediaData as $data) {
            Media::firstOrCreate(
                ['title' => $data['title'], 'section' => $data['section']],
                $data
            );
        }
    }
}
