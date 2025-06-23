<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create($data);

        return redirect()->route('tags.index')
                         ->with('success', 'Tag criada com sucesso!');
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($data);

        return redirect()->route('tags.index')
                         ->with('success', 'Tag atualizada com sucesso!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')
                         ->with('success', 'Tag removida com sucesso!');
    }
}