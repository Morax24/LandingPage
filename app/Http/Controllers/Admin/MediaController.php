<?php
// app/Http\Controllers\Admin\MediaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('uploader')->ordered();

        // Filter
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('section') && $request->section != 'all') {
            $query->where('section', $request->section);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate(12);

        // Stats
        $stats = [
            'total' => Media::count(),
            'images' => Media::images()->count(),
            'videos' => Media::videos()->count(),
            'total_size' => Media::sum('file_size'),
            'active' => Media::where('is_active', true)->count(),
            'inactive' => Media::where('is_active', false)->count(),
        ];

        return view('admin.media.index', compact('media', 'stats'));
    }

    public function create()
    {
        $sections = Media::getSections();
        return view('admin.media.create', compact('sections'));
    }

    public function store(Request $request)
    {
        try {
            \Log::info('=== START UPLOAD PROCESS ===');
            \Log::info('Request method: ' . $request->method());
            \Log::info('Has items: ' . ($request->has('items') ? 'YES' : 'NO'));

            // CEK TIPE UPLOAD
            if ($request->has('items') && is_array($request->items)) {
                \Log::info('Multiple upload detected');
                \Log::info('Items count: ' . count($request->items));
                return $this->handleMultipleUpload($request);
            } else {
                \Log::info('Single upload detected');
                return $this->handleSingleUpload($request);
            }

        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    /**
     * Handle single file upload (form lama)
     */
    private function handleSingleUpload($request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:image,video',
            'section' => 'required|in:features,aktivitas,hero,story,other,whylearn,products',
            'file' => 'required|file|max:10240',
            'price' => 'nullable|numeric|min:0|max:9999999999.99', // TAMBAHKAN VALIDASI MAX
        ]);

        $file = $request->file('file');

        // Generate safe filename
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
        $filePath = 'media/' . $filename;

        // Pastikan folder media ada
        $uploadPath = public_path('media');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Save file
        $file->move($uploadPath, $filename);

        // Validasi harga sebelum save
        $price = $request->price ?? 0;
        if ($price > 9999999999.99) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Harga terlalu besar! Maksimal Rp 9.999.999.999,99');
        }

        // Create media record
        Media::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file_path' => $filePath,
            'file_name' => $filename,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'section' => $request->section,
            'price' => $price,
            'order' => $request->order ?? 0,
            'is_active' => true,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil diupload!');
    }

    /**
     * Handle multiple file upload (form baru)
     */
    private function handleMultipleUpload($request)
    {
        \Log::info('=== HANDLE MULTIPLE UPLOAD ===');

        $uploadedCount = 0;
        $errors = [];

        // Validasi keseluruhan request dengan batas maksimum harga
        $request->validate([
            'items' => 'required|array',
            'items.*.title' => 'required|string|max:255',
            'items.*.type' => 'required|in:image,video',
            'items.*.section' => 'required|in:features,aktivitas,hero,story,other,whylearn,products',
            'items.*.file' => 'required|file|max:10240',
            'items.*.price' => 'nullable|numeric|min:0|max:9999999999.99', // TAMBAHKAN VALIDASI MAX DI SINI
        ]);

        \Log::info('Validation passed');

        // Ambil files dari request secara langsung
        $files = $request->file('items');
        \Log::info('Files from request: ' . ($files ? 'EXISTS' : 'NULL'));

        if (!$files || !is_array($files)) {
            \Log::error('No files found in request');
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tidak ada file yang dikirim.');
        }

        \Log::info('Files count: ' . count($files));

        // Process each file
        foreach ($files as $index => $fileArray) {
            try {
                \Log::info("Processing file index: {$index}");

                // Pastikan $fileArray adalah array
                if (!is_array($fileArray)) {
                    \Log::error("File {$index} is not an array");
                    continue;
                }

                // Get the uploaded file object
                $file = $fileArray['file'] ?? null;

                if (!$file || !$file->isValid()) {
                    \Log::error("File {$index} is not valid");
                    $errors[] = "File " . ($index + 1) . ": File tidak valid";
                    continue;
                }

                // Check file size BEFORE moving
                if (!$file->getSize()) {
                    \Log::error("File {$index} has zero size");
                    $errors[] = "File " . ($index + 1) . ": Ukuran file 0";
                    continue;
                }

                \Log::info("File {$index} details:");
                \Log::info("- Original name: " . $file->getClientOriginalName());
                \Log::info("- MIME type: " . $file->getClientMimeType());
                \Log::info("- Size: " . $file->getSize());
                \Log::info("- Extension: " . $file->getClientOriginalExtension());

                // Get other data from form
                $title = $request->input("items.{$index}.title", 'Untitled');
                $description = $request->input("items.{$index}.description");
                $type = $request->input("items.{$index}.type", 'image');
                $section = $request->input("items.{$index}.section", 'other');
                $price = $request->input("items.{$index}.price", 0);
                $order = $request->input("items.{$index}.order", $index);

                // Validasi harga sebelum proses
                if ($price > 9999999999.99) {
                    $errors[] = "File " . ($index + 1) . ": Harga terlalu besar! Maksimal Rp 9.999.999.999,99";
                    continue;
                }

                \Log::info("File {$index} form data:");
                \Log::info("- Title: {$title}");
                \Log::info("- Type: {$type}");
                \Log::info("- Section: {$section}");
                \Log::info("- Price: {$price}");

                // Generate safe filename
                $safeName = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
                $filename = time() . '_' . $index . '_' . $safeName;
                $filePath = 'media/' . $filename;

                \Log::info("File {$index} will be saved as: {$filename}");

                // Ensure media directory exists
                $uploadPath = public_path('media');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                    \Log::info("Created media directory: {$uploadPath}");
                }

                // Move file IMMEDIATELY
                $file->move($uploadPath, $filename);
                \Log::info("File {$index} moved successfully");

                // Verify file was saved
                $savedPath = $uploadPath . '/' . $filename;
                if (!file_exists($savedPath)) {
                    \Log::error("File {$index} was not saved to: {$savedPath}");
                    $errors[] = "File " . ($index + 1) . ": Gagal menyimpan file";
                    continue;
                }

                $fileSize = filesize($savedPath);
                \Log::info("File {$index} saved size: {$fileSize} bytes");

                // Create media record
                Media::create([
                    'title' => $title,
                    'description' => $description,
                    'type' => $type,
                    'file_path' => $filePath,
                    'file_name' => $filename,
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $fileSize,
                    'section' => $section,
                    'price' => $price,
                    'order' => $order,
                    'is_active' => true,
                    'uploaded_by' => Auth::id(),
                ]);

                $uploadedCount++;
                \Log::info("File {$index} uploaded successfully. Total uploaded: {$uploadedCount}");

            } catch (\Exception $e) {
                \Log::error("Error processing file {$index}: " . $e->getMessage());
                \Log::error("Trace: " . $e->getTraceAsString());
                $errors[] = "File " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        \Log::info("=== UPLOAD COMPLETE ===");
        \Log::info("Uploaded: {$uploadedCount}");
        \Log::info("Errors: " . count($errors));

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' media berhasil diupload!';
            if (!empty($errors)) {
                $message .= '<br> Beberapa error: ' . implode('<br>', $errors);
            }

            return redirect()
                ->route('admin.media.index')
                ->with('success', $message);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload media: ' . implode('<br>', $errors));
        }
    }

    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $sections = Media::getSections();

        return view('admin.media.edit', compact('media', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'section' => 'required|in:features,aktivitas,hero,story,other,whylearn,products',
            'price' => 'nullable|numeric|min:0|max:9999999999.99', // TAMBAHKAN VALIDASI MAX
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $media = Media::findOrFail($id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'section' => $request->section,
            'price' => $request->price ?? 0,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        $media->update($data);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil diupdate!');
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // Delete physical file
        $filePath = public_path($media->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id'
        ]);

        $mediaItems = Media::whereIn('id', $request->ids)->get();
        $deletedCount = 0;

        foreach ($mediaItems as $media) {
            // Delete file
            $filePath = public_path($media->file_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            $media->delete();
            $deletedCount++;
        }

        // Redirect dengan filter yang sama
        return redirect()->route('admin.media.index', [
            'status' => $request->filter_status ?? 'all',
            'type' => $request->filter_type ?? 'all',
            'section' => $request->filter_section ?? 'all',
            'search' => $request->filter_search ?? null,
        ])->with('success', $deletedCount . ' media berhasil dihapus');
    }

    public function bulkToggleActive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id',
            'is_active' => 'required|boolean'
        ]);

        $updatedCount = Media::whereIn('id', $request->ids)
            ->update(['is_active' => $request->is_active]);

        $status = $request->is_active ? 'diaktifkan' : 'dinonaktifkan';

        // Redirect dengan filter yang sama
        return redirect()->route('admin.media.index', [
            'status' => $request->filter_status ?? 'all',
            'type' => $request->filter_type ?? 'all',
            'section' => $request->filter_section ?? 'all',
            'search' => $request->filter_search ?? null,
        ])->with('success', $updatedCount . ' media berhasil ' . $status);
    }

    public function toggleActive($id, Request $request)
    {
        $media = Media::findOrFail($id);
        $media->update(['is_active' => !$media->is_active]);

        $status = $media->is_active ? 'diaktifkan' : 'dinonaktifkan';

        // Redirect dengan filter yang sama
        return redirect()->route('admin.media.index', [
            'status' => $request->input('status', 'all'),
            'type' => $request->input('type', 'all'),
            'section' => $request->input('section', 'all'),
            'search' => $request->input('search'),
        ])->with('success', 'Media berhasil ' . $status);
    }
}
