<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment
     */
    public function store(Request $request, Article $article)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk berkomentar.');
        }

        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Create the comment
        Comment::create([
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'article_id' => $article->id,
        ]);

        return redirect()->route('article.show', $article)
                        ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        // Check if user owns the comment or is admin
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
