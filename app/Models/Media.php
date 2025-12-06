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
        'price', // TAMBAHKAN INI
        'order',
        'is_active',
        'uploaded_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'order' => 'integer',
        'price' => 'decimal:2', // TAMBAHKAN INI
    ];

    protected $appends = ['full_url', 'file_size_formatted', 'formatted_price']; // TAMBAHKAN formatted_price

    // ==================== ATTRIBUTES ====================

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
        if ($this->isImage()) {
            return 'https://via.placeholder.com/800x600/7cb342/ffffff?text=' . urlencode($this->title);
        } else {
            return 'https://via.placeholder.com/800x600/d4f1f4/333333?text=Video+Placeholder';
        }
    }

    public function getMediaUrl()
    {
        return $this->full_url;
    }

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

    // TAMBAHKAN ACCESSOR UNTUK FORMAT HARGA
    public function getFormattedPriceAttribute()
    {
        if (!$this->price || $this->price == 0) {
            return 'Rp 0';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // ==================== METHODS ====================

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeForSection($query, $section)
    {
        return $query->where('section', $section);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    // ==================== RELATIONS ====================

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ==================== STATIC METHODS ====================

    public static function getSections()
    {
        return [
            'hero' => 'Hero Section (Intro)',
            'story' => 'Story Section (Background)',
            'features' => 'Features Section (4 items)',
            'whylearn' => 'Why Learn Section (1 item)',
            'aktivitas' => 'Aktivitas Section (6 items)',
            'products' => 'Products Section (2 items + price)', // UPDATE DESKRIPSI
            'other' => 'Other',
        ];
    }

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

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
}
