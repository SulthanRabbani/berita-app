<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark for an article
     */
    public function toggle(Article $article)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $bookmark = Bookmark::where('user_id', Auth::id())
                           ->where('article_id', $article->id)
                           ->first();

        if ($bookmark) {
            // Remove bookmark
            $bookmark->delete();
            return response()->json([
                'bookmarked' => false,
                'status' => 'removed',
                'message' => 'Artikel dihapus dari bookmark'
            ]);
        } else {
            // Add bookmark
            Bookmark::create([
                'user_id' => Auth::id(),
                'article_id' => $article->id,
            ]);
            return response()->json([
                'bookmarked' => true,
                'status' => 'added',
                'message' => 'Artikel berhasil disimpan'
            ]);
        }
    }

    /**
     * Show user's bookmarked articles
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $bookmarks = Auth::user()
                        ->bookmarks()
                        ->with(['article.category', 'article.user'])
                        ->latest()
                        ->paginate(10);

        return view('bookmarks.index', compact('bookmarks'));
    }
}
