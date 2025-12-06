<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Pengumuman;
use App\Models\Agenda;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function berita(Request $request)
    {
        $posts = Post::published()
            ->ofType('berita')
            ->search($request->input('q'))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $sidebarArticles = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(4)
            ->get();

        $infoTerkini = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('informasi.berita', compact('posts', 'sidebarArticles', 'infoTerkini'));
    }

    public function artikel(Request $request)
    {
        $posts = Post::published()
            ->ofType('artikel')
            ->search($request->input('q'))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $sidebarNews = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(4)
            ->get();

        $infoTerkini = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('informasi.artikel', compact('posts', 'sidebarNews', 'infoTerkini'));
    }

    public function byTag(Request $request, string $tag)
    {
        $decodedTag = urldecode($tag);
        
        $posts = Post::published()
            ->byTag($decodedTag)
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $sidebarArticles = Post::published()
            ->ofType('artikel')
            ->latest('published_at')
            ->take(4)
            ->get();

        $sidebarNews = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(4)
            ->get();

        $infoTerkini = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('informasi.tag', compact('posts', 'decodedTag', 'sidebarArticles', 'sidebarNews', 'infoTerkini'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::active()->ordered()->paginate(10);
        
        // Data untuk sidebar
        $berita = Post::published()
            ->ofType('berita')
            ->latest('published_at')
            ->take(4)
            ->get()
            ->map(function($item) {
                return [
                    'judul' => $item->title,
                    'deskripsi' => $item->excerpt ?? substr(strip_tags($item->body), 0, 100),
                    'tanggal' => $item->published_at?->toDateTimeString()
                ];
            });
        
        $infoTerkini = Pengumuman::active()
            ->ordered()
            ->latest('tanggal')
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'judul' => $item->judul,
                    'tanggal' => $item->tanggal?->format('Y-m-d')
                ];
            });
        
        return view('pengumuman', compact('pengumuman', 'berita', 'infoTerkini'));
    }

    public function agenda()
    {
        $agenda = Agenda::active()->ordered()->get();
        return view('informasi.agenda', compact('agenda'));
    }

    public function show(string $type, string $slug)
    {
        abort_unless(in_array($type, ['berita', 'artikel']), 404);

        $post = Post::published()
            ->ofType($type)
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::published()
            ->ofType($type)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Get current post tags (tags yang diinput admin) - langsung muncul
        $postTags = $post->tags ?? [];
        $postTagsLower = array_map(fn($tag) => strtolower(trim($tag)), $postTags);
        
        // Get tags that appear in at least 2 published posts (for auto-tags)
        $allTags = Post::published()
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->map(fn($tag) => strtolower(trim($tag)))
            ->countBy();

        // Filter tags: only show if count >= 2 (minimum 2 posts with same tag)
        $validTags = $allTags->filter(fn($count) => $count >= 2)->keys()->toArray();
        
        // Combine: tags dari admin (langsung muncul) + tags yang common (minimal 2 artikel)
        $displayTags = [];
        
        // 1. Tags yang diinput admin (langsung muncul, tidak perlu cek minimal 2)
        foreach ($postTags as $tag) {
            $tagTrimmed = trim($tag);
            if ($tagTrimmed !== '' && !in_array($tagTrimmed, $displayTags)) {
                $displayTags[] = $tagTrimmed;
            }
        }
        
        // 2. Tags yang common (minimal 2 artikel) tapi belum ada di postTags
        $tagsToAdd = [];
        foreach ($validTags as $validTag) {
            if (!in_array($validTag, $postTagsLower)) {
                // Find original case from database
                $originalTag = Post::published()
                    ->whereNotNull('tags')
                    ->get()
                    ->pluck('tags')
                    ->flatten()
                    ->filter()
                    ->first(fn($tag) => strtolower(trim($tag)) === $validTag);
                
                if ($originalTag) {
                    $tagTrimmed = trim($originalTag);
                    if (!in_array($tagTrimmed, $displayTags)) {
                        $displayTags[] = $tagTrimmed;
                        // Simpan tag common ke array untuk ditambahkan ke database
                        $tagsToAdd[] = $tagTrimmed;
                    }
                }
            }
        }
        
        // Simpan tag common ke database jika ada tag baru yang perlu ditambahkan
        // Hanya tambahkan jika total tag tidak melebihi 10
        if (!empty($tagsToAdd)) {
            $currentTagsCount = count($postTags);
            $maxTags = 10;
            $remainingSlots = $maxTags - $currentTagsCount;
            
            if ($remainingSlots > 0) {
                // Ambil tag baru sebanyak slot yang tersedia
                $tagsToSave = array_slice($tagsToAdd, 0, $remainingSlots);
                
                // Gabungkan dengan tag yang sudah ada dan pastikan tidak ada duplikat
                $updatedTags = array_unique(array_merge($postTags, $tagsToSave));
                $updatedTags = array_values($updatedTags); // Re-index array
                
                // Simpan ke database tanpa trigger event (untuk menghindari loop)
                $post->tags = $updatedTags;
                $post->saveQuietly(); // saveQuietly() untuk menghindari event yang mungkin trigger reload
                
                // Refresh post dan update postTags untuk digunakan di relatedPosts
                $post->refresh();
                $postTags = $post->tags ?? [];
            }
        }

        // Get approved comments for this post
        $comments = $post->approvedComments()->get();

        // Latest posts for sidebar (5 posts)
        $latestPosts = Post::published()
            ->ofType($type)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Suggested posts untuk "Berita yang Disarankan" - berdasarkan terbaru
        $suggestedPosts = Post::published()
            ->ofType($type)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        
        // Related posts untuk "Baca Juga:" - berdasarkan tag yang sama (lebih relevan)
        $relatedPosts = Post::published()
            ->ofType($type)
            ->where('id', '!=', $post->id)
            ->where(function($query) use ($postTags) {
                if (!empty($postTags)) {
                    foreach ($postTags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->latest('published_at')
            ->take(3)
            ->get();
        
        // Jika related posts kurang dari 3, tambahkan dari suggested posts
        if ($relatedPosts->count() < 3) {
            $remaining = 3 - $relatedPosts->count();
            $additionalPosts = $suggestedPosts->whereNotIn('id', $relatedPosts->pluck('id'))->take($remaining);
            $relatedPosts = $relatedPosts->merge($additionalPosts);
        }

        // Track view: 1 device = 1 viewer (using session_id)
        $sessionId = request()->session()->getId();
        $ipAddress = request()->ip();
        $post->incrementViewCount($sessionId, $ipAddress);
        
        // Refresh post to get updated view_count
        $post->refresh();

        return view('informasi.detail', compact('post', 'related', 'displayTags', 'comments', 'latestPosts', 'suggestedPosts', 'relatedPosts'));
    }
}

