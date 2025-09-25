<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'articles' => Article::count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'comments' => Comment::count(),
            'recent_articles' => Article::with(['user', 'category'])
                ->latest()
                ->take(5)
                ->get(),
            'recent_comments' => Comment::with(['user', 'article'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
