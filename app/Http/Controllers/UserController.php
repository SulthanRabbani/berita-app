<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display the user's profile
     */
    public function profile(User $user = null)
    {
        $user = $user ?? Auth::user();

        // Get user's articles
        $articles = Article::where('user_id', $user->id)
            ->with(['category', 'comments'])
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        // Get user's recent comments
        $comments = Comment::where('user_id', $user->id)
            ->with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get user's bookmarks
        $bookmarks = $user->bookmarks()
            ->with(['article.category', 'article.user'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $isOwnProfile = Auth::id() === $user->id;

        return view('user.profile', compact('user', 'articles', 'comments', 'bookmarks', 'isOwnProfile'));
    }

    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $user->update($request->only(['name', 'email', 'bio', 'location', 'website']));

        return redirect()->route('user.profile')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Display user's articles
     */
    public function articles(User $user = null)
    {
        $user = $user ?? Auth::user();

        $articles = Article::where('user_id', $user->id)
            ->with(['category', 'user'])
            ->withCount('comments')
            ->when(Auth::id() !== $user->id, function ($query) {
                $query->where('status', 'published');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $isOwnProfile = Auth::id() === $user->id;

        return view('user.articles', compact('user', 'articles', 'isOwnProfile'));
    }

    /**
     * Display user's comments
     */
    public function comments(User $user = null)
    {
        $user = $user ?? Auth::user();

        $comments = Comment::where('user_id', $user->id)
            ->with(['article', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $isOwnProfile = Auth::id() === $user->id;

        return view('user.comments', compact('user', 'comments', 'isOwnProfile'));
    }
}
