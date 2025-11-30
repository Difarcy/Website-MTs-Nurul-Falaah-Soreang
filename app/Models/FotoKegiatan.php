<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKegiatan extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
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
        return $query->orderBy('urutan')->orderBy('created_at', 'desc');
    }
}
