<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoSekolah extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'type',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}
