@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold text-black mb-4">Posts Recentes</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
        @foreach ($recentPosts as $post)
            <div class="bg-cyan-300 rounded shadow overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover rounded-t">
                </div>
                <div class="p-4 text-white">
                    <h3 class="font-bold">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-400">por <a href="{{ route('profile.show', $post->user->id) }}" class="text-indigo-400 hover:underline">{{ $post->user->name }}</a></p>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="text-xl font-semibold text-black mb-4">Mais Curtidos</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($popularPosts as $post)
            <div class="bg-cyan-300 rounded shadow overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover rounded-t">
                </div>
                <div class="p-4 text-white">
                    <h3 class="font-bold">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-400">por <a href="{{ route('profile.show', $post->user->id) }}" class="text-indigo-400 hover:underline">{{ $post->user->name }}</a></p>
                    <p class="text-sm text-gray-400 mt-1">Curtidas: {{ $post->likes_count ?? $post->likes->count() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
