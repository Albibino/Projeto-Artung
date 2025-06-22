<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('home')->with('success', 'Post criado com sucesso!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para excluir este post.');
        }

        if ($post->image_path) {
            \Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post excluído com sucesso!');
    }
}
