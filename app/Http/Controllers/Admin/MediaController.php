<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    /**
     * Display a listing of the media.
     */
    public function index(Request $request)
    {
        $query = Media::with('uploader')->ordered();

        // Filter status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        // Filter type
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        // Filter section
        if ($request->has('section') && $request->section != 'all') {
            $query->where('section', $request->section);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $media = $query->paginate(12);

        // Get stats menggunakan method dari model
        $stats = Media::getStats();

        return view('admin.media.index', compact('media', 'stats'));
    }

    /**
     * Show the form for creating new media.
     */
    public function create()
    {
        $sections = Media::getSections();
        return view('admin.media.create', compact('sections'));
    }

    /**
     * Store a newly created media in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('=== START MEDIA UPLOAD ===');
            Log::info('Request has items: ' . ($request->has('items') ? 'YES' : 'NO'));

            // Check upload type
            if ($request->has('items') && is_array($request->items)) {
                return $this->handleMultipleUpload($request);
            } else {
                return $this->handleSingleUpload($request);
            }

        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload media: ' . $e->getMessage());
        }
    }

    /**
     * Handle single file upload
     */
    private function handleSingleUpload(Request $request)
    {
        $validated = $request->validate(Media::getValidationRules('store'));

        $file = $request->file('file');

        // Generate safe filename
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
        $filePath = 'media/' . $filename;

        // Ensure media directory exists
        $uploadPath = public_path('media');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move file
        $file->move($uploadPath, $filename);

        // Create media record
        Media::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'file_path' => $filePath,
            'file_name' => $filename,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'section' => $validated['section'],
            'price' => $validated['price'] ?? 0,
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
            'uploaded_by' => Auth::id(),
        ]);

        Log::info('Single upload successful: ' . $filename);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil diupload!');
    }

    /**
     * Handle multiple file upload
     */
    private function handleMultipleUpload(Request $request)
    {
        Log::info('=== HANDLE MULTIPLE UPLOAD ===');

        // Validate the request
        $request->validate([
            'items' => 'required|array',
            'items.*.title' => 'required|string|max:255',
            'items.*.type' => 'required|in:image,video',
            'items.*.section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'items.*.file' => 'required|file|max:10240',
            'items.*.price' => 'nullable|numeric|min:0|max:9999999999.99',
        ]);

        $uploadedCount = 0;
        $errors = [];
        $files = $request->file('items');

        if (!$files || !is_array($files)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tidak ada file yang dikirim.');
        }

        Log::info('Total files to process: ' . count($files));

        // Process each file
        foreach ($files as $index => $fileArray) {
            try {
                Log::info("Processing file index: {$index}");

                if (!is_array($fileArray)) {
                    $errors[] = "File " . ($index + 1) . ": Format data tidak valid";
                    continue;
                }

                $file = $fileArray['file'] ?? null;

                if (!$file || !$file->isValid()) {
                    $errors[] = "File " . ($index + 1) . ": File tidak valid";
                    continue;
                }

                // Get form data
                $title = $request->input("items.{$index}.title", 'Untitled');
                $description = $request->input("items.{$index}.description");
                $type = $request->input("items.{$index}.type", 'image');
                $section = $request->input("items.{$index}.section", 'other');
                $price = $request->input("items.{$index}.price", 0);
                $order = $request->input("items.{$index}.order", $index);

                // Generate safe filename
                $safeName = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
                $filename = time() . '_' . $index . '_' . $safeName;
                $filePath = 'media/' . $filename;

                // Ensure media directory exists
                $uploadPath = public_path('media');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Move file
                $file->move($uploadPath, $filename);

                // Verify file was saved
                if (!file_exists($uploadPath . '/' . $filename)) {
                    $errors[] = "File " . ($index + 1) . ": Gagal menyimpan file";
                    continue;
                }

                // Create media record
                Media::create([
                    'title' => $title,
                    'description' => $description,
                    'type' => $type,
                    'file_path' => $filePath,
                    'file_name' => $filename,
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => filesize($uploadPath . '/' . $filename),
                    'section' => $section,
                    'price' => $price,
                    'order' => $order,
                    'is_active' => true,
                    'uploaded_by' => Auth::id(),
                ]);

                $uploadedCount++;
                Log::info("File {$index} uploaded: {$filename}");

            } catch (\Exception $e) {
                $errors[] = "File " . ($index + 1) . ": " . $e->getMessage();
                Log::error("Error processing file {$index}: " . $e->getMessage());
            }
        }

        Log::info("Upload completed: {$uploadedCount} successful, " . count($errors) . " errors");

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' media berhasil diupload!';
            if (!empty($errors)) {
                $message .= '<br><small>Error: ' . implode('<br>', $errors) . '</small>';
            }

            return redirect()
                ->route('admin.media.index')
                ->with('success', $message);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload semua media: ' . implode('<br>', $errors));
        }
    }

    /**
     * Show the form for editing the specified media.
     */
    public function edit($id)
    {
        $media = Media::findOrFail($id);
        $sections = Media::getSections();

        return view('admin.media.edit', compact('media', 'sections'));
    }

    /**
     * Update the specified media in storage.
     */
    public function update(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'price' => 'nullable|numeric|min:0|max:9999999999.99',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            $request->validate(['file' => 'file|max:10240']);

            // Delete old file
            $media->deleteFile();

            // Upload new file
            $file = $request->file('file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
            $filePath = 'media/' . $filename;

            $file->move(public_path('media'), $filename);

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $filename;
            $validated['mime_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $media->update($validated);

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil diperbarui!');
    }

    /**
     * Remove the specified media from storage.
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        // File akan otomatis dihapus oleh model boot method
        $media->delete();

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Media berhasil dihapus!');
    }

    /**
     * Toggle active status for a media.
     */
    public function toggleActive($id, Request $request)
    {
        $media = Media::findOrFail($id);
        $media->toggleActive();

        $status = $media->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.media.index', [
            'status' => $request->input('status', 'all'),
            'type' => $request->input('type', 'all'),
            'section' => $request->input('section', 'all'),
            'search' => $request->input('search'),
        ])->with('success', 'Media berhasil ' . $status);
    }

    /**
     * Bulk delete media.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id'
        ]);

        $deletedCount = Media::bulkDelete($request->ids);

        return redirect()->route('admin.media.index', [
            'status' => $request->filter_status ?? 'all',
            'type' => $request->filter_type ?? 'all',
            'section' => $request->filter_section ?? 'all',
            'search' => $request->filter_search ?? null,
        ])->with('success', $deletedCount . ' media berhasil dihapus');
    }

    /**
     * Bulk toggle active status for media.
     */
    public function bulkToggleActive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:media,id',
            'is_active' => 'required|boolean'
        ]);

        $updatedCount = Media::bulkToggleActive($request->ids, $request->is_active);

        $status = $request->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.media.index', [
            'status' => $request->filter_status ?? 'all',
            'type' => $request->filter_type ?? 'all',
            'section' => $request->filter_section ?? 'all',
            'search' => $request->filter_search ?? null,
        ])->with('success', $updatedCount . ' media berhasil ' . $status);
    }

    /**
     * Get media by section for API/JSON response.
     */
    public function getBySection($section)
    {
        $media = Media::getBySection($section);

        return response()->json([
            'success' => true,
            'data' => $media,
            'section' => $section
        ]);
    }

    /**
     * Get all active media for frontend.
     */
    public function getAllActive()
    {
        $media = Media::getAllActiveMedia();

        return response()->json([
            'success' => true,
            'data' => $media
        ]);
    }

    /**
     * Get media statistics.
     */
    public function getStatistics()
    {
        $stats = Media::getStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
