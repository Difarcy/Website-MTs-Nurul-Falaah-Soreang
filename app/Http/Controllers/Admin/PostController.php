<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Determine type from route name
        $type = $request->route()->getName() === 'admin.artikel.index' ? 'artikel' : 'berita';
        
        // Handle view preference: save to session if provided, otherwise use session or default to 'table'
        if ($request->has('view')) {
            session(['posts_view' => $request->input('view')]);
        }
        $viewPreference = session('posts_view', 'table'); // Default to 'table'

        $query = Post::query();
        
        // Filter by type based on route
        $query->ofType($type);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('q')) {
            $query->search($request->input('q'));
        }

        // Apply sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'published_asc':
                $query->orderBy('published_at', 'asc');
                break;
            case 'published_desc':
                $query->orderBy('published_at', 'desc');
                break;
            case 'latest':
            default:
                $query->latest('published_at')->latest('created_at');
                break;
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts', 'viewPreference', 'type'));
    }

    public function create(Request $request)
    {
        // Determine type from route name
        $type = $request->route()->getName() === 'admin.artikel.create' ? 'artikel' : 'berita';
        
        $post = new Post([
            'status' => 'published',
            'type' => $type,
            'published_at' => now()->setSeconds(0), // Set detik ke 0 untuk datetime-local
        ]);

        return view('admin.posts.create', compact('post', 'type'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);
        $data['author_id'] = Auth::id();

        $post = Post::create($data);

        $type = $data['type'];
        $typeLabel = $type === 'artikel' ? 'Artikel' : 'Berita';
        
        $statusMessage = match($data['status']) {
            'published' => $typeLabel . ' berhasil dipublikasikan dan langsung muncul di website.',
            'unpublished' => $typeLabel . ' berhasil dinonaktifkan dan disembunyikan dari website.',
            default => $typeLabel . ' berhasil disimpan sebagai draft.',
        };

        $viewPreference = session('posts_view', 'table');
        $routeName = $type === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index';
        return redirect()
            ->route($routeName, ['view' => $viewPreference])
            ->with('status', $statusMessage)
            ->with('reload', true);
    }

    public function show(Post $post): RedirectResponse
    {
        $routeName = $post->type === 'artikel' ? 'admin.artikel.edit' : 'admin.berita.edit';
        return redirect()->route($routeName, $post);
    }

    public function edit(Post $post)
    {
        $type = $post->type;
        return view('admin.posts.edit', compact('post', 'type'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $oldStatus = $post->status;
        
        // Get redirect URL from request BEFORE validation
        // Access raw request data to get the value before it might be filtered
        $allRequestData = $request->all();
        $redirectUrl = $allRequestData['_redirect_after_save'] ?? null;
        
        $data = $this->prepareData($request, $post);
        
        // Pastikan updated_at terupdate untuk trigger auto-refresh di website resmi
        $data['updated_at'] = now();
        
        $post->update($data);

        $type = $data['type'];
        $typeLabel = $type === 'artikel' ? 'Artikel' : 'Berita';
        
        $statusMessage = match($data['status']) {
            'published' => $typeLabel . ' berhasil dipublikasikan dan langsung muncul di website.',
            'unpublished' => $typeLabel . ' berhasil dinonaktifkan dan disembunyikan dari website.',
            default => $typeLabel . ' berhasil diperbarui.',
        };

        // Check if there's a redirect URL from sidebar navigation
        if (!empty($redirectUrl) && is_string($redirectUrl)) {
            // Clean and validate URL
            $redirectUrl = trim($redirectUrl);
            
            // If it's a relative path (starts with /), redirect directly
            if (str_starts_with($redirectUrl, '/')) {
                return redirect($redirectUrl)
                    ->with('status', $statusMessage)
                    ->with('reload', true);
            }
            
            // If it's a full URL, validate it's from same domain
            if (filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
                $redirectHost = parse_url($redirectUrl, PHP_URL_HOST);
                $appHost = parse_url(config('app.url'), PHP_URL_HOST);
                if ($redirectHost && $redirectHost === $appHost) {
                    return redirect($redirectUrl)
                        ->with('status', $statusMessage)
                        ->with('reload', true);
                }
            }
            
            // If URL doesn't match patterns above, extract path from URL
            if (str_contains($redirectUrl, '/')) {
                $parsed = parse_url($redirectUrl);
                if (isset($parsed['path'])) {
                    return redirect($parsed['path'])
                        ->with('status', $statusMessage)
                        ->with('reload', true);
                }
            }
        }

        $viewPreference = session('posts_view', 'table');
        $routeName = $type === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index';
        return redirect()
            ->route($routeName, ['view' => $viewPreference])
            ->with('status', $statusMessage)
            ->with('reload', true);
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->thumbnail_path) {
            Storage::disk('public')->delete($post->thumbnail_path);
        }

        $type = $post->type;
        $typeLabel = $type === 'artikel' ? 'Artikel' : 'Berita';
        
        $post->delete();

        $viewPreference = session('posts_view', 'table');
        $routeName = $type === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index';
        return redirect()
            ->route($routeName, ['view' => $viewPreference])
            ->with('status', $typeLabel . ' berhasil dihapus.')
            ->with('reload', true);
    }

    protected function prepareData(PostRequest $request, ?Post $post = null): array
    {
        $data = $request->validated();
        
        // Pastikan author_name selalu ada (jika tidak ada, gunakan default)
        if (empty($data['author_name'])) {
            $data['author_name'] = 'Admin';
        }

        if (empty($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle thumbnail upload (file saja, tanpa URL)
        if ($request->hasFile('thumbnail')) {
            if ($post?->thumbnail_path) {
                Storage::disk('public')->delete($post->thumbnail_path);
            }

            $data['thumbnail_path'] = $request->file('thumbnail')->store('posts', 'public');
        } elseif ($post?->thumbnail_path) {
            // Jika tidak ada upload baru, pertahankan thumbnail existing
            $data['thumbnail_path'] = $post->thumbnail_path;
        }

        // Handle images upload (file saja, tanpa URL baru)
        $uploadedImages = [];
        $imageMetadata = [];
        
        // Get existing metadata
        $existingMetadata = $post?->image_metadata ?? [];
        $metadataMap = [];
        if (is_array($existingMetadata)) {
            foreach ($existingMetadata as $meta) {
                if (isset($meta['path'])) {
                    $metadataMap[$meta['path']] = $meta;
                }
            }
        }
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('posts/images', 'public');
                    $uploadedImages[] = $path;
                    // File upload tidak punya metadata sumber
                    $imageMetadata[] = [
                        'path' => $path,
                        'source_url' => null,
                        'source_name' => null,
                    ];
                }
            }
        }

        // Merge with existing images
        $existingImages = $request->input('existing_images', []);
        $allImages = array_merge($existingImages, $uploadedImages);
        
        // Preserve metadata untuk existing images
        foreach ($existingImages as $existingPath) {
            if (isset($metadataMap[$existingPath])) {
                $imageMetadata[] = $metadataMap[$existingPath];
            } else {
                $imageMetadata[] = [
                    'path' => $existingPath,
                    'source_url' => null,
                    'source_name' => null,
                ];
            }
        }
        
        // Remove deleted images from storage
        if ($post) {
            $oldImages = $post->images ?? [];
            $imagesToDelete = array_diff($oldImages, $existingImages);
            foreach ($imagesToDelete as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $data['images'] = !empty($allImages) ? $allImages : null;
        $data['image_metadata'] = !empty($imageMetadata) ? $imageMetadata : null;

        // Handle published_at: ambil tanggal dari published_at_date, waktu otomatis dari waktu saat ini
        if ($data['status'] === 'published') {
            if (!empty($request->input('published_at_date'))) {
                // Ambil tanggal dari input, waktu dari waktu saat ini (otomatis)
                $date = \Carbon\Carbon::parse($request->input('published_at_date'));
                $now = now();
                $data['published_at'] = $date->setTime($now->hour, $now->minute, $now->second);
            } else {
                // Jika tidak ada tanggal yang dipilih, gunakan waktu sekarang (tanggal dan waktu saat ini)
                $data['published_at'] = now();
            }
        } else {
            // Jika status draft atau unpublished, hapus published_at
            $data['published_at'] = null;
        }
        
        // Hapus published_at_date dari data karena tidak ada di database
        unset($data['published_at_date']);

        // Process tags: trim and filter empty values
        if (isset($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', $data['tags']));
            $data['tags'] = !empty($data['tags']) ? array_values($data['tags']) : null;
        }
        
        // Pastikan excerpt sinkron dengan body jika excerpt kosong atau tidak sesuai
        if (isset($data['body'])) {
            $bodyText = strip_tags($data['body']);
            $excerptText = isset($data['excerpt']) ? strip_tags($data['excerpt']) : '';
            
            // Jika excerpt kosong atau tidak sesuai dengan awal body, generate dari body
            if (empty($excerptText) || !str_starts_with($bodyText, $excerptText)) {
                $data['excerpt'] = \Illuminate\Support\Str::limit($bodyText, 200);
            }
        }

        return $data;
    }
    
    /**
     * Extract source name from URL
     */
    private function extractSourceNameFromUrl(string $url): ?string
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (!$host) {
            return null;
        }
        
        // Extract domain name
        $host = str_replace('www.', '', $host);
        $parts = explode('.', $host);
        if (count($parts) >= 2) {
            return ucfirst($parts[count($parts) - 2]);
        }
        
        return ucfirst($host);
    }
}
