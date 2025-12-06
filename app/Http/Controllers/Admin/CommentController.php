<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('post')->newest();

        // Filter berdasarkan status approval
        if ($request->has('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Filter berdasarkan read status
        if ($request->has('read')) {
            if ($request->read === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->read === 'read') {
                $query->where('is_read', true);
            }
        }

        // Search
        if ($request->has('q') && $request->q) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $comments = $query->paginate(15)->withQueryString();

        // Count statistics
        $totalComments = Comment::count();
        $pendingComments = Comment::where('is_approved', false)->count();
        $unreadComments = Comment::where('is_read', false)->count();

        // Check if AJAX request
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $html = view('admin.comments.index', compact('comments', 'totalComments', 'pendingComments', 'unreadComments'))->render();
            return response()->json(['html' => $html]);
        }

        return view('admin.comments.index', compact('comments', 'totalComments', 'pendingComments', 'unreadComments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update([
            'is_approved' => true,
            'is_read' => true,
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar berhasil disetujui.');
    }

    public function reject(Comment $comment)
    {
        $comment->update([
            'is_approved' => false,
            'is_read' => true,
        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar ditolak.');
    }

    public function markAsRead(Comment $comment)
    {
        $comment->update(['is_read' => true]);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar ditandai sebagai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Comment::where('is_read', false)->update(['is_read' => true]);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Semua komentar ditandai sebagai sudah dibaca.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }
}
