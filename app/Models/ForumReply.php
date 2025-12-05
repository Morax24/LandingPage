<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'name',
        'email',
        'message',
        'status',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relasi ke Contact (parent comment)
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Relasi ke User (admin yang approve)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope untuk approved replies
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk pending replies
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Check status
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }
}
