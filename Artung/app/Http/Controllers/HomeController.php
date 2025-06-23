<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

    $search = $request->input('search');

    $baseQuery = Post::with(['user','tag1','likes']);

    if ($search) {
        $baseQuery->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('user', fn($q2) => 
                  $q2->where('name', 'like', "%{$search}%")
              )
              ->orWhereHas('tag1', fn($q3) =>
                  $q3->where('name', 'like', "%{$search}%")
              );
        });
    }

    $recentPosts = (clone $baseQuery)->orderBy('created_at','desc')->get();
    $popularPosts = (clone $baseQuery)->withCount('likes')->orderByDesc('likes_count')->get();

    return view('home', compact('recentPosts','popularPosts','search'));
    }
}
