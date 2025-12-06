<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function store(Request $request, string $type, string $slug)
    {
        abort_unless(in_array($type, ['berita', 'artikel']), 404);

        $post = Post::published()
            ->ofType($type)
            ->where('slug', $slug)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120'],
            'comment' => ['required', 'string', 'max:1000'],
            'anonymous' => ['sometimes', 'boolean'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 120 karakter.',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // Jika anonymous dicentang, set name menjadi "Anonymous"
        $name = $request->has('anonymous') && $request->anonymous ? 'Anonymous' : $validated['name'];

        Comment::create([
            'post_id' => $post->id,
            'name' => $name,
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Menunggu persetujuan admin
            'is_read' => false,
        ]);

        return redirect()
            ->route('informasi.show', ['type' => $type, 'slug' => $slug])
            ->with('comment_success', 'Komentar Anda telah dikirim dan menunggu persetujuan admin.');
    }
}
