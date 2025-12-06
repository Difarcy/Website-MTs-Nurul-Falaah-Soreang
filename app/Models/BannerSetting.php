<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
    protected $fillable = [
        'tagline',
        'judul',
        'deskripsi',
        'link',
        'button_text',
        'show_logo',
        'show_tagline',
        'show_title',
        'show_description',
        'show_button',
        'promosi_banner_path',
    ];

    protected $casts = [
        'show_logo' => 'boolean',
        'show_tagline' => 'boolean',
        'show_title' => 'boolean',
        'show_description' => 'boolean',
        'show_button' => 'boolean',
    ];
}


