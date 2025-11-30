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
        $query = Post::query();

        // Apply filters (if needed in future)
        if ($request->filled('type')) {
            $query->ofType($request->input('type'));
        }
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

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post([
            'status' => 'published',
            'type' => 'berita',
            'published_at' => now(),
        ]);

        return view('admin.posts.create', compact('post'));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);
        $data['author_id'] = Auth::id();

        $post = Post::create($data);

        $statusMessage = $data['status'] === 'published' 
            ? 'Berita berhasil dipublikasikan dan langsung muncul di website.' 
            : 'Berita berhasil disimpan sebagai draft.';

        return redirect()
            ->route('admin.posts.index')
            ->with('status', $statusMessage);
    }

    public function show(Post $post): RedirectResponse
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $oldStatus = $post->status;
        $data = $this->prepareData($request, $post);
        $post->update($data);

        $statusMessage = $data['status'] === 'published' 
            ? 'Berita berhasil dipublikasikan dan langsung muncul di website.' 
            : 'Berita berhasil diperbarui.';

        return redirect()
            ->route('admin.posts.index')
            ->with('status', $statusMessage);
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->thumbnail_path) {
            Storage::disk('public')->delete($post->thumbnail_path);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Berita berhasil dihapus.');
    }

    protected function prepareData(PostRequest $request, ?Post $post = null): array
    {
        $data = $request->validated();

        if (empty($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('thumbnail')) {
            if ($post?->thumbnail_path) {
                Storage::disk('public')->delete($post->thumbnail_path);
            }

            $data['thumbnail_path'] = $request->file('thumbnail')->store('posts', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        return $data;
    }
}
