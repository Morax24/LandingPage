<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara mass assignment
     */
    protected $fillable = [
        'name',
        'email',
        'institution',
        'message',
        'rating',     // <-- TAMBAHKAN INI
        'type',
        'status',
        'approved_at',
        'approved_by',
        'admin_notes'
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'rating' => 'integer',  // <-- TAMBAHKAN INI
    ];

    /**
     * Relasi ke User (admin yang approve)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check apakah status pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check apakah status approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check apakah status rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope untuk filter berdasarkan type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForum($query)
    {
        return $query->where('type', 'forum');
    }

    public function scopeTestimonial($query)
    {
        return $query->where('type', 'testimonial');
    }

    /**
     * Scope untuk urutkan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Accessor untuk status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Accessor untuk status text Indonesia
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Accessor untuk type text
     */
    public function getTypeTextAttribute()
    {
        return match($this->type) {
            'forum' => 'Forum',
            'testimonial' => 'Testimoni',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Accessor untuk rating dalam bentuk bintang HTML
     */
    public function getStarsHtmlAttribute()
    {
        if (!$this->rating || $this->type !== 'testimonial') {
            return '<span style="color: #999;">-</span>';
        }

        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<span style="color: #FFC107; font-size: 1rem;">★</span>';
            } else {
                $stars .= '<span style="color: #ddd; font-size: 1rem;">★</span>';
            }
        }

        $ratingText = match($this->rating) {
            5 => 'Sangat Baik',
            4 => 'Baik',
            3 => 'Cukup',
            2 => 'Kurang',
            1 => 'Sangat Kurang',
            default => ''
        };

        return '<div class="rating-stars" title="' . $ratingText . '">' . $stars . ' <span style="font-size:0.75rem; color:#666;">(' . $this->rating . ')</span></div>';
    }

    /**
     * Relasi ke Forum Replies
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class)->where('status', 'approved')->latest();
    }

    public function allReplies()
    {
        return $this->hasMany(ForumReply::class)->latest();
    }
}
