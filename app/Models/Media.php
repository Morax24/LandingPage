<?php
// app/Models/Media.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'section',
        'price',
        'order',
        'is_active',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'order' => 'integer',
        'price' => 'decimal:2',
    ];

    protected $appends = [
        'full_url',
        'media_url', // TAMBAH INI untuk handle getMediaUrl()
        'file_size_formatted',
        'formatted_price',
        'is_image', // Untuk consistency
        'is_video', // Untuk consistency
    ];

    // ==================== ATTRIBUTES (ACCESSORS) ====================

    /**
     * Get full URL for media file
     */
    public function getFullUrlAttribute()
    {
        // Langsung gunakan path dari database
        $path = $this->file_path;

        // Jika path dimulai dengan 'media/', akses langsung
        if (str_starts_with($path, 'media/')) {
            return asset($path);
        }

        // Jika tidak ada prefix, tambahkan 'media/'
        if (!str_contains($path, '/')) {
            return asset('media/' . $path);
        }

        // Fallback: coba dari public folder
        $publicPath = public_path($path);
        if (file_exists($publicPath)) {
            return asset($path);
        }

        // Fallback: placeholder
        if ($this->type === 'image') {
            return 'https://via.placeholder.com/800x600/7cb342/ffffff?text=' . urlencode($this->title);
        } else {
            return 'https://via.placeholder.com/800x600/d4f1f4/333333?text=Video+Placeholder';
        }
    }

    /**
     * Accessor untuk media_url (alias dari full_url)
     */
    public function getMediaUrlAttribute()
    {
        return $this->full_url;
    }

    /**
     * Format file size to human readable
     */
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes == 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Format price to Indonesian Rupiah
     */
    public function getFormattedPriceAttribute()
    {
        if (!$this->price || $this->price == 0) {
            return 'Rp 0';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Check if media is image (accessor version)
     */
    public function getIsImageAttribute()
    {
        return $this->type === 'image';
    }

    /**
     * Check if media is video (accessor version)
     */
    public function getIsVideoAttribute()
    {
        return $this->type === 'video';
    }

    // ==================== REGULAR METHODS ====================

    /**
     * Method untuk get media URL
     */
    public function getMediaUrl()
    {
        return $this->full_url;
    }

    /**
     * Method untuk check image
     */
    public function isImage()
    {
        return $this->type === 'image';
    }

    /**
     * Method untuk check video
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Check if file exists on disk
     */
    public function fileExists()
    {
        $path = public_path($this->file_path);
        return file_exists($path);
    }

    /**
     * Delete physical file
     */
    public function deleteFile()
    {
        if ($this->fileExists()) {
            return unlink(public_path($this->file_path));
        }
        return false;
    }

    /**
     * Toggle active status
     */
    public function toggleActive()
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }

    /**
     * Get section name in readable format
     */
    public function getSectionName()
    {
        $sections = [
            'hero' => 'Intro',
            'story' => 'Background',
            'whylearn' => 'Fitur 3',
            'features' => 'Fitur Unggulan',
            'aktivitas' => 'Aktivitas & Tutorial',
            'products' => 'Products',
            'other' => 'Lainnya'
        ];

        return $sections[$this->section] ?? ucfirst($this->section);
    }

    // ==================== SCOPES (QUERY BUILDERS) ====================

    /**
     * Scope for active media
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive media
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for images only
     */
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    /**
     * Scope for videos only
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Scope for specific section
     */
    public function scopeForSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Scope for ordered results
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope for media with price (products)
     */
    public function scopeWithPrice($query)
    {
        return $query->whereNotNull('price')->where('price', '>', 0);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('file_name', 'like', "%{$search}%");
        });
    }

    // ==================== RELATIONS ====================

    /**
     * Relationship with uploader
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ==================== STATIC METHODS ====================

    /**
     * Get all available sections
     */
    public static function getSections()
    {
        return [
            'hero' => 'Hero Section (Intro)',
            'story' => 'Story Section (Background)',
            'features' => 'Features Section (4 items)',
            'whylearn' => 'Why Learn Section (1 item)',
            'aktivitas' => 'Aktivitas Section (6 items)',
            'products' => 'Products Section (2 items + price)',
            'other' => 'Other',
        ];
    }

    /**
     * Get validation rules for media
     */
    public static function getValidationRules($type = 'store')
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:image,video',
            'section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'price' => 'nullable|numeric|min:0|max:9999999999.99',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ];

        if ($type === 'store') {
            $rules['file'] = 'required|file|max:10240';
        } else {
            $rules['file'] = 'nullable|file|max:10240';
        }

        return $rules;
    }

    /**
     * Get section configuration for upload form
     */
    public static function getSectionConfig($section = null)
    {
        $configs = [
            'hero' => ['count' => 1, 'name' => 'Intro'],
            'story' => ['count' => 1, 'name' => 'Background'],
            'whylearn' => ['count' => 1, 'name' => 'Fitur 3'],
            'features' => ['count' => 4, 'name' => 'Fitur Unggulan'],
            'aktivitas' => ['count' => 6, 'name' => 'Aktivitas & Tutorial'],
            'products' => ['count' => 2, 'name' => 'Products']
        ];

        if ($section) {
            return $configs[$section] ?? null;
        }

        return $configs;
    }

    /**
     * Get statistics for dashboard
     */
    public static function getStats()
    {
        return [
            'total' => self::count(),
            'images' => self::images()->count(),
            'videos' => self::videos()->count(),
            'active' => self::active()->count(),
            'inactive' => self::where('is_active', false)->count(),
            'total_size' => self::sum('file_size'),
        ];
    }

    /**
     * Get media by section
     */
    public static function getBySection($section, $activeOnly = true)
    {
        $query = self::forSection($section)->ordered();

        if ($activeOnly) {
            $query->active();
        }

        return $query->get();
    }

    /**
     * Get hero media (single)
     */
    public static function getHeroMedia()
    {
        return self::forSection('hero')->active()->ordered()->first();
    }

    /**
     * Get story media (single)
     */
    public static function getStoryMedia()
    {
        return self::forSection('story')->active()->ordered()->first();
    }

    /**
     * Get why learn media (single)
     */
    public static function getWhyLearnMedia()
    {
        return self::forSection('whylearn')->active()->ordered()->first();
    }

    /**
     * Get features media (4 items)
     */
    public static function getFeaturesMedia()
    {
        return self::forSection('features')->active()->ordered()->limit(4)->get();
    }

    /**
     * Get activities media (6 items)
     */
    public static function getActivitiesMedia()
    {
        return self::forSection('aktivitas')->active()->ordered()->limit(6)->get();
    }

    /**
     * Get products media (2 items)
     */
    public static function getProductsMedia()
    {
        return self::forSection('products')->active()->withPrice()->ordered()->limit(2)->get();
    }

    /**
     * Get all active media for frontend
     */
    public static function getAllActiveMedia()
    {
        return [
            'hero' => self::getHeroMedia(),
            'story' => self::getStoryMedia(),
            'whylearn' => self::getWhyLearnMedia(),
            'features' => self::getFeaturesMedia(),
            'activities' => self::getActivitiesMedia(),
            'products' => self::getProductsMedia()
        ];
    }

    /**
     * Bulk delete media with files
     */
    public static function bulkDelete($ids)
    {
        $deleted = 0;
        $items = self::whereIn('id', $ids)->get();

        foreach ($items as $item) {
            if ($item->deleteFile()) {
                $item->delete();
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Bulk update media
     */
    public static function bulkUpdate($ids, $data)
    {
        return self::whereIn('id', $ids)->update($data);
    }

    /**
     * Bulk toggle active status
     */
    public static function bulkToggleActive($ids, $isActive)
    {
        return self::whereIn('id', $ids)->update(['is_active' => $isActive]);
    }

    // ==================== BOOT (MODEL EVENTS) ====================

    /**
     * Model boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Before saving, validate price
        static::saving(function ($media) {
            if ($media->price !== null && $media->price > 9999999999.99) {
                throw new \Exception('Harga tidak boleh melebihi Rp 9.999.999.999,99');
            }
        });

        // Before deleting, remove physical file
        static::deleting(function ($media) {
            // Hapus file fisik jika ada
            $filePath = public_path($media->file_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }

            // Juga coba hapus dari storage
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        });
    }

    /**
     * Magic method untuk handle dynamic calls
     */
    public function __call($method, $parameters)
    {
        // Handle calls to isImage() and isVideo() as methods
        if ($method === 'isImage') {
            return $this->type === 'image';
        }

        if ($method === 'isVideo') {
            return $this->type === 'video';
        }

        // Handle call to getMediaUrl() as method
        if ($method === 'getMediaUrl') {
            return $this->full_url;
        }

        return parent::__call($method, $parameters);
    }
}
