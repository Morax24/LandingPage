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
     * STORE ALL SECTIONS IN ONE REQUEST (BULK UPLOAD)
     * Method ini untuk halaman manajemen media semua section dalam 1 halaman
     */
    public function storeAll(Request $request)
    {
        try {
            Log::info('=== START STORE ALL SECTIONS ===');
            Log::info('Request files keys: ' . json_encode(array_keys($request->allFiles())));
            Log::info('Request all data keys: ' . json_encode(array_keys($request->all())));

            $uploadedCount = 0;
            $errors = [];

            // ==================== HERO ====================
            if ($request->hasFile('hero')) {
                $file = $request->file('hero');
                Log::info('Hero file found: ' . $file->getClientOriginalName());
                $result = $this->saveMediaFile($file, 'hero', null, null, []);
                if ($result['success']) {
                    $uploadedCount++;
                    Log::info('Hero uploaded successfully');
                } else {
                    $errors[] = 'Hero: ' . $result['error'];
                }
            } else {
                Log::info('Hero file NOT found');
            }

            // ==================== STORY ====================
            if ($request->hasFile('story')) {
                $file = $request->file('story');
                Log::info('Story file found: ' . $file->getClientOriginalName());
                $result = $this->saveMediaFile($file, 'story', null, null, []);
                if ($result['success']) {
                    $uploadedCount++;
                    Log::info('Story uploaded successfully');
                } else {
                    $errors[] = 'Story: ' . $result['error'];
                }
            } else {
                Log::info('Story file NOT found');
            }

            // ==================== WHY LEARN ====================
            if ($request->hasFile('whylearn')) {
                $file = $request->file('whylearn');
                Log::info('WhyLearn file found: ' . $file->getClientOriginalName());
                $result = $this->saveMediaFile($file, 'whylearn', null, null, []);
                if ($result['success']) {
                    $uploadedCount++;
                    Log::info('WhyLearn uploaded successfully');
                } else {
                    $errors[] = 'WhyLearn: ' . $result['error'];
                }
            } else {
                Log::info('WhyLearn file NOT found');
            }

            // ==================== FEATURES (multiple) ====================
            // Backend menerima 'features[]' (array of files)
            if ($request->hasFile('features')) {
                $files = $request->file('features');
                // Pastikan $files adalah array
                if (!is_array($files)) {
                    $files = [$files];
                }

                Log::info('Features files count: ' . count($files));

                foreach ($files as $index => $file) {
                    if ($file && $file->isValid()) {
                        Log::info('Processing feature ' . ($index + 1) . ': ' . $file->getClientOriginalName());
                        $result = $this->saveMediaFile($file, 'features', null, $index, []);
                        if ($result['success']) {
                            $uploadedCount++;
                            Log::info('Feature ' . ($index + 1) . ' uploaded successfully');
                        } else {
                            $errors[] = 'Fitur ' . ($index + 1) . ': ' . $result['error'];
                        }
                    }
                }
            } else {
                Log::info('Features files NOT found');
            }

            // ==================== AKTIVITAS (multiple) ====================
            // Backend menerima 'aktivitas[]' (array of files)
            if ($request->hasFile('aktivitas')) {
                $files = $request->file('aktivitas');
                // Pastikan $files adalah array
                if (!is_array($files)) {
                    $files = [$files];
                }

                Log::info('Aktivitas files count: ' . count($files));

                foreach ($files as $index => $file) {
                    if ($file && $file->isValid()) {
                        Log::info('Processing aktivitas ' . ($index + 1) . ': ' . $file->getClientOriginalName());
                        $result = $this->saveMediaFile($file, 'aktivitas', null, $index, []);
                        if ($result['success']) {
                            $uploadedCount++;
                            Log::info('Aktivitas ' . ($index + 1) . ' uploaded successfully');
                        } else {
                            $errors[] = 'Aktivitas ' . ($index + 1) . ': ' . $result['error'];
                        }
                    }
                }
            } else {
                Log::info('Aktivitas files NOT found');
            }

            // ==================== PRODUCTS ====================
            // Backend menerima 'product_images[]' (array of files)
            // dan 'products_data' (JSON string)
            if ($request->hasFile('product_images')) {
                $productImages = $request->file('product_images');
                if (!is_array($productImages)) {
                    $productImages = [$productImages];
                }

                // Parse products data
                $productsData = [];
                if ($request->has('products_data')) {
                    $productsData = json_decode($request->input('products_data'), true);
                    if (!is_array($productsData)) {
                        $productsData = [];
                    }
                }

                Log::info('Product images count: ' . count($productImages));
                Log::info('Products data: ' . json_encode($productsData));

                foreach ($productImages as $index => $file) {
                    if (!$file || !$file->isValid()) continue;

                    $productInfo = $productsData[$index] ?? [];
                    $title = $productInfo['title'] ?? '';
                    $price = $productInfo['price'] ?? 0;
                    $description = $productInfo['description'] ?? '';

                    if (empty($title)) {
                        $errors[] = 'Produk ' . ($index + 1) . ': Judul wajib diisi';
                        continue;
                    }

                    if (empty($price) || $price <= 0) {
                        $errors[] = 'Produk ' . ($index + 1) . ': Harga wajib diisi';
                        continue;
                    }

                    Log::info('Processing product ' . ($index + 1) . ': ' . $file->getClientOriginalName());

                    $result = $this->saveMediaFile($file, 'products', null, $index, [
                        'title' => $title,
                        'price' => $price,
                        'description' => $description
                    ]);

                    if ($result['success']) {
                        $uploadedCount++;
                        Log::info("Product {$index} uploaded successfully");
                    } else {
                        $errors[] = 'Produk ' . ($index + 1) . ': ' . $result['error'];
                    }
                }
            } else {
                Log::info('Product images NOT found');
            }

            Log::info("Store All completed: {$uploadedCount} successful, " . count($errors) . " errors");

            if ($uploadedCount > 0) {
                $message = $uploadedCount . ' media berhasil disimpan!';
                if (!empty($errors)) {
                    $message = $uploadedCount . ' media berhasil disimpan, namun ada ' . count($errors) . ' error: ' . implode('; ', $errors);
                }
                return response()->json(['success' => true, 'message' => $message]);
            } else {
                $errorMsg = !empty($errors) ? implode('; ', $errors) : 'Tidak ada file yang diupload. Pastikan Anda sudah memilih file sebelum menyimpan.';
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan: ' . $errorMsg], 422);
            }

        } catch (\Exception $e) {
            Log::error('StoreAll error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper function to save media file (SUPPORTS IMAGE & VIDEO)
     */
    private function saveMediaFile($file, $section, $type = null, $order = null, $extra = [])
    {
        try {
            if (!$file || !$file->isValid()) {
                return ['success' => false, 'error' => 'File tidak valid'];
            }

            Log::info("Saving file to section: {$section}, original name: " . $file->getClientOriginalName());

            // Validasi ukuran (10MB)
            $fileSize = $file->getSize();
            if ($fileSize > 10 * 1024 * 1024) {
                return ['success' => false, 'error' => 'Ukuran file maksimal 10MB (file Anda: ' . round($fileSize / 1024 / 1024, 2) . 'MB)'];
            }

            // Validasi tipe file - DUKUNG GAMBAR DAN VIDEO
            $mimeType = $file->getClientMimeType();

            // Tentukan tipe media berdasarkan mime type
            $mediaType = 'image';
            $allowedMimes = [];

            if (strpos($mimeType, 'image/') === 0) {
                $mediaType = 'image';
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
            } elseif (strpos($mimeType, 'video/') === 0) {
                $mediaType = 'video';
                $allowedMimes = ['video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'];
            } else {
                return ['success' => false, 'error' => 'Tipe file tidak didukung. Gunakan gambar (JPG, PNG, WEBP) atau video (MP4, WebM). (Tipe Anda: ' . $mimeType . ')'];
            }

            if (!in_array($mimeType, $allowedMimes)) {
                return ['success' => false, 'error' => 'Tipe file tidak didukung. ' .
                    ($mediaType === 'image' ? 'Gunakan JPG, PNG, atau WEBP' : 'Gunakan MP4, WebM, atau OGG') .
                    '. (Tipe Anda: ' . $mimeType . ')'];
            }

            // Gunakan type dari parameter atau deteksi otomatis
            $finalType = $type ?? $mediaType;

            // Generate title
            $title = $extra['title'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // Generate filename
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
            $filename = time() . '_' . uniqid() . '_' . $safeName . '.' . $extension;
            $filePath = 'media/' . $filename;

            // Ensure directory exists
            $uploadPath = public_path('media');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move file
            $moved = $file->move($uploadPath, $filename);

            if (!$moved) {
                return ['success' => false, 'error' => 'Gagal memindahkan file'];
            }

            // Verify file was saved
            $fullPath = $uploadPath . '/' . $filename;
            if (!file_exists($fullPath)) {
                return ['success' => false, 'error' => 'File tidak ditemukan setelah upload'];
            }

            // Get file size from saved file
            $savedFileSize = filesize($fullPath);

            // Cek apakah sudah ada media dengan section dan order yang sama? Hapus yang lama jika perlu
            if ($section !== 'products') {
                $existing = Media::where('section', $section)
                    ->where('order', $order ?? 0)
                    ->first();

                if ($existing) {
                    $existing->deleteFile();
                    $existing->delete();
                    Log::info("Deleted existing media for section: {$section}, order: " . ($order ?? 0));
                }
            } elseif ($section === 'products' && $order !== null) {
                // Untuk products, hapus yang lama berdasarkan order
                $existing = Media::where('section', 'products')
                    ->where('order', $order)
                    ->first();

                if ($existing) {
                    $existing->deleteFile();
                    $existing->delete();
                    Log::info("Deleted existing product for order: {$order}");
                }
            }

            // Create media record
            $media = Media::create([
                'title' => $title,
                'description' => $extra['description'] ?? null,
                'type' => $finalType,
                'file_path' => $filePath,
                'file_name' => $filename,
                'mime_type' => $mimeType,
                'file_size' => $savedFileSize,
                'section' => $section,
                'price' => $extra['price'] ?? 0,
                'order' => $order ?? 0,
                'is_active' => true,
                'uploaded_by' => Auth::id(),
            ]);

            Log::info("Saved media ID: {$media->id}, filename: {$filename}, section: {$section}, type: {$finalType}, size: {$savedFileSize}");

            return ['success' => true, 'media_id' => $media->id];

        } catch (\Exception $e) {
            Log::error('SaveMediaFile error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Handle single file upload
     */
    private function handleSingleUpload(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:image,video',
            'section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,webp,mp4,webm,ogg',
            'price' => 'nullable|numeric|min:0|max:9999999999.99',
            'order' => 'nullable|integer|min:0',
        ]);

        $file = $request->file('file');

        if (empty($validated['title'])) {
            $validated['title'] = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
        $filename = time() . '_' . $safeName . '.' . $extension;
        $filePath = 'media/' . $filename;

        $uploadPath = public_path('media');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $filename);

        Media::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'file_path' => $filePath,
            'file_name' => $filename,
            'mime_type' => $file->getClientMimeType(),
            'file_size' => filesize($uploadPath . '/' . $filename),
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

        $request->validate([
            'items' => 'required|array',
            'items.*.type' => 'required|in:image,video',
            'items.*.section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'items.*.file' => 'required|file|max:10240|mimes:jpg,jpeg,png,webp,mp4,webm,ogg',
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

        foreach ($files as $index => $fileArray) {
            try {
                if (!is_array($fileArray)) {
                    $errors[] = "File " . ($index + 1) . ": Format data tidak valid";
                    continue;
                }

                $file = $fileArray['file'] ?? null;

                if (!$file || !$file->isValid()) {
                    $errors[] = "File " . ($index + 1) . ": File tidak valid";
                    continue;
                }

                $section = $request->input("items.{$index}.section", 'other');
                $title = $request->input("items.{$index}.title");

                if (empty($title)) {
                    $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                }

                $description = $request->input("items.{$index}.description");
                $type = $request->input("items.{$index}.type", 'image');
                $price = $request->input("items.{$index}.price", 0);
                $order = $request->input("items.{$index}.order", $index);

                if ($section === 'products' && empty(trim($title))) {
                    $errors[] = "File " . ($index + 1) . ": Judul wajib diisi untuk section Products";
                    continue;
                }

                if ($section === 'products' && (empty($price) || $price <= 0)) {
                    $errors[] = "File " . ($index + 1) . ": Harga wajib diisi untuk section Products";
                    continue;
                }

                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
                $filename = time() . '_' . $index . '_' . $safeName . '.' . $extension;
                $filePath = 'media/' . $filename;

                $uploadPath = public_path('media');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $file->move($uploadPath, $filename);

                $savedFileSize = filesize($uploadPath . '/' . $filename);

                Media::create([
                    'title' => $title,
                    'description' => $description,
                    'type' => $type,
                    'file_path' => $filePath,
                    'file_name' => $filename,
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $savedFileSize,
                    'section' => $section,
                    'price' => $price,
                    'order' => $order,
                    'is_active' => true,
                    'uploaded_by' => Auth::id(),
                ]);

                $uploadedCount++;

            } catch (\Exception $e) {
                $errors[] = "File " . ($index + 1) . ": " . $e->getMessage();
                Log::error("Error processing file {$index}: " . $e->getMessage());
            }
        }

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' media berhasil diupload!';
            if (!empty($errors)) {
                $message .= '<br><small>Error: ' . implode('<br>', $errors) . '</small>';
            }
            return redirect()->route('admin.media.index')->with('success', $message);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal upload semua media: ' . implode('<br>', $errors));
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

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'file|max:10240|mimes:jpg,jpeg,png,webp,mp4,webm,ogg']);

            $media->deleteFile();

            $file = $request->file('file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
            $filename = time() . '_' . $safeName . '.' . $extension;
            $filePath = 'media/' . $filename;

            $file->move(public_path('media'), $filename);

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $filename;
            $validated['mime_type'] = $file->getClientMimeType();
            $validated['file_size'] = filesize(public_path('media') . '/' . $filename);

            if (strpos($file->getClientMimeType(), 'video/') === 0) {
                $validated['type'] = 'video';
            } else {
                $validated['type'] = 'image';
            }
        }

        $media->update($validated);

        return redirect()->route('admin.media.index')->with('success', 'Media berhasil diperbarui!');
    }

    /**
     * Remove the specified media from storage.
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media berhasil dihapus!');
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
