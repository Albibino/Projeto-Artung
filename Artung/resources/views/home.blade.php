@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Posts Recentes</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-8">
        @foreach($recentPosts as $post)
            <div class="bg-white rounded-lg shadow">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-t-lg w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-600">por <a href="{{ route('profile.show', $post->user->id) }}" class="text-blue-600 hover:underline">{{ $post->user->name }}</a></p>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="text-2xl font-bold mb-4">Mais Curtidos</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($popularPosts as $post)
            <div class="bg-white rounded-lg shadow">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="rounded-t-lg w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-600">por <a href="{{ route('profile.show', $post->user->id) }}" class="text-blue-600 hover:underline">{{ $post->user->name }}</a></p>
                    <p class="mt-2 text-sm text-gray-500">Curtidas: {{ $post->likes_count ?? $post->likes->count() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
