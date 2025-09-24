<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with latest articles
     */
    public function index()
    {
        $articles = Article::with(['user', 'category', 'comments'])
            ->withCount('comments')
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Category::withCount('articles')->get();

        return view('welcome', compact('articles', 'categories'));
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
