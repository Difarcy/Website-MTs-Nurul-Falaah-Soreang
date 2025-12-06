<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'excerpt',
        'body',
        'thumbnail_path',
        'status',
        'published_at',
        'is_featured',
        'author_id',
        'author_name',
        'meta_description',
        'tags',
        'images',
        'image_metadata',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'tags' => 'array',
        'images' => 'array',
        'image_metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            // Set ID ke ID terkecil yang tersedia agar selalu berurutan
            if (empty($post->id)) {
                $post->id = static::getNextAvailableId();
            }

            if (empty($post->slug)) {
                $post->slug = Str::slug(Str::limit($post->title, 60, ''));
            }

            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->body), 200);
            }
        });

        static::updating(function (Post $post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug(Str::limit($post->title, 60, ''));
            }
            
            // Jika body berubah dan excerpt kosong atau tidak sesuai, update excerpt dari body
            if ($post->isDirty('body')) {
                // Jika excerpt kosong atau excerpt tidak ada di awal body, generate ulang dari body
                $bodyText = strip_tags($post->body);
                $excerptText = $post->excerpt ? strip_tags($post->excerpt) : '';
                
                // Jika excerpt kosong atau tidak sesuai dengan awal body, generate ulang
                if (empty($excerptText) || !str_starts_with($bodyText, $excerptText)) {
                    $post->excerpt = Str::limit($bodyText, 200);
                }
            }
        });
    }

    /**
     * Get the smallest available ID (reuse deleted IDs)
     * Tujuannya agar ID selalu berurutan: 1, 2, 3, 4, 5, dst
     */
    public static function getNextAvailableId(): int
    {
        $existingIds = static::pluck('id')->toArray();
        
        if (empty($existingIds)) {
            return 1;
        }
        
        $maxId = max($existingIds);
        
        // Find the smallest missing ID
        for ($i = 1; $i <= $maxId; $i++) {
            if (!in_array($i, $existingIds)) {
                return $i;
            }
        }
        
        // If no gap found, return max + 1
        return $maxId + 1;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%");
        });
    }

    public function scopeByTag($query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->newest();
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->approved()->newest();
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }

    public function incrementViewCount(string $sessionId, ?string $ipAddress = null): void
    {
        // Check if this session already viewed this post
        $existingView = $this->views()
            ->where('session_id', $sessionId)
            ->first();

        if (!$existingView) {
            // Create new view record
            $this->views()->create([
                'session_id' => $sessionId,
                'ip_address' => $ipAddress,
                'viewed_at' => now(),
            ]);

            // Increment view_count
            $this->increment('view_count');
        }
    }
}
