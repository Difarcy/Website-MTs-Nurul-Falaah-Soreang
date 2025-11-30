<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiSiswa extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal_prestasi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'tanggal_prestasi' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('tanggal_prestasi', 'desc');
    }
}
