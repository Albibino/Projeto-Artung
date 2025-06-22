<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = Post::with('user')
            ->latest()
            ->take(9)
            ->get();

        $popularPosts = Post::with('user')
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->take(9)
            ->get();

        return view('home', compact('recentPosts', 'popularPosts'));
    }
}
