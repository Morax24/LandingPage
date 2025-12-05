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

    // Tambahkan di dalam class Contact
public function replies()
{
    return $this->hasMany(ForumReply::class)->where('status', 'approved')->latest();
}

public function allReplies()
{
    return $this->hasMany(ForumReply::class)->latest();
}
}
