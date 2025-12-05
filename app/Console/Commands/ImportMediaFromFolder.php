<?php

namespace App\Console\Commands;

use App\Models\Media;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportMediaFromFolder extends Command
{
    protected $signature = 'media:import-folder';
    protected $description = 'Import existing media files from public/media to database';

    public function handle()
    {
        $admin = User::first();

        if (!$admin) {
            $this->error("Admin user tidak ditemukan! Buat admin dulu.");
            return;
        }

        $mediaFolder = public_path('media');

        if (!File::exists($mediaFolder)) {
            File::makeDirectory($mediaFolder, 0755, true);
            $this->info("Folder media dibuat: {$mediaFolder}");
        }

        $files = File::allFiles($mediaFolder);
        $this->info("Menemukan " . count($files) . " file di folder media");

        $imported = 0;
        $skipped = 0;
        $failed = 0;

        $sectionMapping = [
            'hero' => ['hero', 'intro', 'main', 'utama'],
            'story' => ['story', 'background', 'cerita'],
            'whylearn' => ['whylearn', 'why', 'learn', 'belajar'],
            'features' => ['features', 'feature', 'game', 'puzzle', 'business', 'analisis'],
            'aktivitas' => ['aktivitas', 'activity', 'tutorial', 'grid', 'screenshot'],
            'products' => ['products', 'product', 'premium', 'gameboard'],
        ];

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $filePath = 'media/' . $filename;
            $fileSize = $file->getSize();

            // Deteksi tipe file
            $extension = strtolower($file->getExtension());
            $type = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']) ? 'image' :
                   (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']) ? 'video' : null);

            if (!$type) {
                $this->warn("Skip: {$filename} (bukan image/video)");
                $skipped++;
                continue;
            }

            // Deteksi section dari nama file
            $section = $this->detectSection($filename, $sectionMapping);

            // Buat title dari filename
            $title = $this->generateTitle($filename);

            // Cek apakah sudah ada di database
            $exists = Media::where('file_name', $filename)->orWhere('file_path', $filePath)->exists();

            if ($exists) {
                $this->line("Skip: {$filename} (sudah ada di database)");
                $skipped++;
                continue;
            }

            // Import ke database
            try {
                Media::create([
                    'title' => $title,
                    'description' => ucfirst($section) . ' media - ' . $filename,
                    'type' => $type,
                    'file_path' => $filePath,
                    'file_name' => $filename,
                    'mime_type' => $this->getMimeType($extension),
                    'file_size' => $fileSize,
                    'section' => $section,
                    'order' => Media::where('section', $section)->count() + 1,
                    'is_active' => true,
                    'uploaded_by' => $admin->id,
                ]);

                $this->info("✓ Import: {$filename} → {$section}");
                $imported++;

            } catch (\Exception $e) {
                $this->error("✗ Gagal import {$filename}: " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->info("================================");
        $this->info("✅ IMPORT SELESAI!");
        $this->info("Total file ditemukan: " . count($files));
        $this->info("Berhasil diimport: {$imported}");
        $this->info("Skipped: {$skipped}");
        $this->info("Failed: {$failed}");
        $this->info("================================");

        // Tampilkan statistik per section
        if ($imported > 0) {
            $this->newLine();
            $this->info("📊 STATISTIK PER SECTION:");
            $sections = Media::groupBy('section')->selectRaw('section, count(*) as total')->orderBy('section')->get();
            foreach ($sections as $section) {
                $this->line("  {$section->section}: {$section->total} media");
            }
        }

        return 0;
    }

    private function detectSection($filename, $mapping)
    {
        $filename = strtolower($filename);

        foreach ($mapping as $section => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($filename, $keyword)) {
                    return $section;
                }
            }
        }

        // Deteksi berdasarkan prefix angka (untuk aktivitas)
        if (preg_match('/^\d+_/', $filename) || preg_match('/\d{10,}/', $filename)) {
            return 'aktivitas';
        }

        // Default untuk file video besar
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($extension, ['mp4', 'avi', 'mov'])) {
            return 'features';
        }

        return 'other';
    }

    private function generateTitle($filename)
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $name = str_replace(['_', '-'], ' ', $name);
        $name = preg_replace('/\d{10,}/', '', $name); // Hapus timestamp
        $name = trim($name);

        if (empty($name)) {
            $name = 'Media ' . uniqid();
        }

        return ucwords($name);
    }

    private function getMimeType($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp',
            'mp4' => 'video/mp4',
            'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            'wmv' => 'video/x-ms-wmv',
            'webm' => 'video/webm',
            'ogg' => 'video/ogg',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
