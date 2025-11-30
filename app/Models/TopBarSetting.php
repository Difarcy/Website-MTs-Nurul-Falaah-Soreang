<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopBarSetting extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
    ];
}
