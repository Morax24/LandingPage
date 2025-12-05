<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Http\Requests\StoreMediaRequest;
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
            $search = $request->search;
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

    public function store(StoreMediaRequest $request)
    {
        try {
            $file = $request->file('file');

            // Validasi file
            if (!$file) {
                throw new \Exception('Tidak ada file yang diupload');
            }

            if (!$file->isValid()) {
                throw new \Exception('File tidak valid: ' . $file->getErrorMessage());
            }

            // Generate safe filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '_', $file->getClientOriginalName());
            $filePath = 'media/' . $filename;

            // Pastikan folder media ada
            $uploadPath = public_path('media');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Copy file langsung
            $tempPath = $file->getRealPath();

            if (!file_exists($tempPath)) {
                // Fallback: gunakan getPathname()
                $tempPath = $file->getPathname();
            }

            if (!file_exists($tempPath)) {
                throw new \Exception('File temporary tidak ditemukan');
            }

            // Copy file dari temporary ke destination
            if (!copy($tempPath, $uploadPath . '/' . $filename)) {
                throw new \Exception('Gagal menyalin file ke folder media');
            }

            // Set permission
            chmod($uploadPath . '/' . $filename, 0644);

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
                'order' => $request->order ?? 0,
                'uploaded_by' => Auth::id(),
            ]);

            return redirect()
                ->route('admin.media.index')
                ->with('success', 'Media berhasil diupload!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload: ' . $e->getMessage());
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
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $media = Media::findOrFail($id);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'section' => $request->section,
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
