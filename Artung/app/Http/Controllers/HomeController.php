<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = Post::with('user')->latest()->take(10)->get();

        $popularPosts = Post::with('user')
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->take(10)
            ->get();

        return view('home', compact('recentPosts', 'popularPosts'));
    }
}
