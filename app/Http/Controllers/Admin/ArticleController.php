<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user', 'category', 'tags'])
            ->when(Auth::user()->role === 'editor', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at if status is published
        if ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        // Attach tags
        if (!empty($validated['tags'])) {
            $article->tags()->attach($validated['tags']);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $this->authorizeArticleAccess($article);

        $article->load(['user', 'category', 'tags', 'comments.user']);

        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $this->authorizeArticleAccess($article);

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $this->authorizeArticleAccess($article);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'remove_image' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
                $validated['featured_image'] = null;
            }
        }

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if uploading new one
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at if status is published
        if ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        // Sync tags
        if (isset($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorizeArticleAccess($article);

        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Authorize article access for editors
     */
    private function authorizeArticleAccess(Article $article)
    {
        if (Auth::user()->role === 'editor' && $article->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this article.');
        }
    }

    /**
     * Upload image for WYSIWYG editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/articles/content', $filename, 'public');

            return response()->json([
                'url' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
