<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the homepage with latest articles
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category', 'comments'])
            ->withCount('comments')
            ->when(Auth::check(), function ($query) {
                $query->with(['bookmarks' => function ($q) {
                    $q->where('user_id', Auth::id());
                }]);
            })
            ->where('status', 'published')
            ->where('published_at', '<=', now());

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by tag if provided
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('content', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'LIKE', "%{$searchTerm}%");
            });
        }

        $articles = $query->orderBy('published_at', 'desc')->paginate(10);

        // Preserve query parameters in pagination
        $articles->appends($request->query());

        // Add bookmarked status for each article
        if (Auth::check()) {
            $articles->getCollection()->transform(function ($article) {
                $article->bookmarked_by_user = $article->bookmarks->isNotEmpty();
                return $article;
            });
        }

        $categories = Category::withCount('articles')->get();
        $tags = Tag::withCount('articles')->limit(10)->get();

        return view('home', compact('articles', 'categories', 'tags'));
    }

    /**
     * Display a specific article
     */
    public function show(Article $article)
    {
        // Increment views count
        $article->increment('views_count');

        // Load relationships
        $article->load(['user', 'category', 'comments.user', 'tags']);

        // Get related articles
        $relatedArticles = Article::where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->where('status', 'published')
            ->limit(3)
            ->get();

        return view('article.show', compact('article', 'relatedArticles'));
    }

    /**
     * Display articles by category
     */
    public function category(Category $category)
    {
        $articles = $category->articles()
            ->with(['user', 'category', 'comments'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('category.show', compact('category', 'articles'));
    }

    /**
     * Search articles
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $articles = Article::with(['user', 'category', 'comments'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('search.results', compact('articles', 'query'));
    }
}
