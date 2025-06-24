<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('AcessoNegado.notice');
        }

        return view('posts.edit', compact('post'));
    } 

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'required|image',
            'tag1_id'       => 'nullable|exists:tags,id',
            'tag2_id'       => 'nullable|exists:tags,id',
            'tag3_id'       => 'nullable|exists:tags,id',
        ]);

            $tags = array_filter([
        $data['tag1_id'] ?? null,
        $data['tag2_id'] ?? null,
        $data['tag3_id'] ?? null,
        ]);
        if (count($tags) !== count(array_unique($tags))) {
            return back()
                ->withInput()
                ->withErrors(['tags' => 'Você deve selecionar tags diferentes.']);
        }


        $data['image_path'] = $request->file('image')->store('posts', 'public');
        $data['user_id'] = auth()->id();
        $post = Post::create($data);

        return redirect()->route('home')
                        ->with('success', 'Post criado com sucesso!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('AcessoNegado.notice');
        }

        if ($post->image_path) {
            \Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post excluído com sucesso!');
    }

       public function PostdestroyAdmin(Post $post)
    {

        if ($post->image_path) {
            \Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post excluído com sucesso!');
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        if (! $post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }

    public function unlike(Post $post)
    {
        $user = Auth::user();

        $post->likes()
             ->where('user_id', $user->id)
             ->delete();

        return back();
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'tag1_id'       => 'nullable|exists:tags,id',
            'tag2_id'       => 'nullable|exists:tags,id',
            'tag3_id'       => 'nullable|exists:tags,id',
        ]);

        $post->update($data);

    return redirect()
        ->route('profile.show', auth()->user()->id)
        ->with('success', 'Post atualizado com sucesso!');
    }
}
