<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublikasiController extends Controller
{
    public function index(Request $request): View
    {
        $viewPreference = session('publikasi_view', 'table');
        if ($request->filled('view') && in_array($request->input('view'), ['table', 'grid'], true)) {
            $viewPreference = $request->input('view');
            session(['publikasi_view' => $viewPreference]);
        }

        $query = Post::query();

        // Filter by type if specified
        if ($request->filled('type') && in_array($request->input('type'), ['berita', 'artikel'])) {
            $query->ofType($request->input('type'));
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply search
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

        $posts = $query->paginate(12)->withQueryString();

        return view('admin.publikasi.index', compact('posts', 'viewPreference'));
    }
}

