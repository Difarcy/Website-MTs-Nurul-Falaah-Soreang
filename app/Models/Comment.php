<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'email',
        'comment',
        'is_approved',
        'is_read',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_read' => 'boolean',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
