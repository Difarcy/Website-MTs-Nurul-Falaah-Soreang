<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunningText extends Model
{
    protected $fillable = [
        'text',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('created_at', 'asc');
    }
}
