@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 space-y-12">
        <form method="GET" action="{{ route('home') }}" class="flex mb-6">
            <input
            type="text"
            name="search"
            value="{{ old('search', $search) }}"
            placeholder="Buscar por título, autor ou tag…"
            class="flex-1 px-4 py-2 rounded-l bg-white text-black focus:outline-none"
            >
            <button
            type="submit"
            class="px-4 py-2 bg-cyan-500 text-white rounded-r hover:bg-cyan-600 transition"
            >
            Pesquisar
            </button>
        </form>
        <section>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Posts Recentes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPosts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow flex flex-col overflow-hidden">
                        <div class="overflow-hidden rounded-t">
                            <img
                                src="{{ asset('storage/'.$post->image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-auto object-cover max-h-96"
                            >
                        </div>

                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold">{{ $post->title }}</h3>
                                <div class="flex space-x-1">
                                    @if($post->tag1)
                                        <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag1->name }}</span>
                                    @endif
                                    @if($post->tag2)
                                        <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag2->name }}</span>
                                    @endif
                                    @if($post->tag3)
                                        <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag3->name }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-sm text-gray-600 mt-2">
                                por
                                <a href="{{ route('profile.show', $post->user_id) }}" class="text-indigo-400 hover:underline">
                                    {{ $post->user->name }}
                                </a>
                                </p>

                                @if(auth()->user()->isAdmin() or auth()->user()->isModerator())
                                    <form
                                    action="{{ route('posts.PostdestroyAdmin', $post) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esse post?')"
                                    class="mt-4 text-right"
                                    >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm"
                                    >
                                        🗑️ Excluir Post
                                    </button>
                                    </form>
                                @endif

                                <div class="flex items-center space-x-2">
                                    @auth
                                        @php
                                            $liked = $post->likes->contains('user_id', auth()->id());
                                        @endphp

                                        @if(! $liked)
                                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="text-sm text-blue-500 hover:text-blue-700"
                                                >
                                                    👍
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('posts.unlike', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="text-sm text-red-500 hover:text-red-700"
                                                >
                                                    👎
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                    <span class="text-sm text-gray-600">❤️ {{ $post->likes_count ?? $post->likes->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Mais Curtidos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularPosts as $post)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow flex flex-col overflow-hidden">
                        <div class="overflow-hidden rounded-t">
                            <img
                                src="{{ asset('storage/'.$post->image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-auto object-cover max-h-96"
                            >
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold">{{ $post->title }}</h3>
                            <div class="flex space-x-1">
                                @if($post->tag1)
                                    <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag1->name }}</span>
                                @endif
                                @if($post->tag2)
                                    <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag2->name }}</span>
                                @endif
                                @if($post->tag3)
                                    <span class="bg-cyan-600 text-xs px-2 py-1 rounded">{{ $post->tag3->name }}</span>
                                @endif
                            </div>
                        </div>
                            <div class="mt-4 flex justify-between items-center">
                                <p class="text-sm text-gray-600 mt-2">
                                por
                                <a href="{{ route('profile.show', $post->user_id) }}" class="text-indigo-400 hover:underline">
                                    {{ $post->user->name }}
                                </a>
                                </p>
                                @if(auth()->user()->isAdmin() or auth()->user()->isModerator())
                                    <form
                                    action="{{ route('posts.PostdestroyAdmin', $post) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esse post?')"
                                    class="mt-4 text-right"
                                    >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 text-sm"
                                    >
                                        🗑️ Excluir Post
                                    </button>
                                    </form>
                                @endif
                                <div class="flex items-center space-x-2">
                                    @auth
                                        @php
                                            $liked = $post->likes->contains('user_id', auth()->id());
                                        @endphp
                                        @if(! $liked)
                                            <form action="{{ route('posts.like', $post) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm text-blue-500 hover:text-blue-700">👍</button>
                                            </form>
                                        @else
                                            <form action="{{ route('posts.unlike', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:text-red-700">👎</button>
                                            </form>
                                        @endif
                                    @endauth
                                    <span class="text-sm text-gray-600">❤️ {{ $post->likes_count ?? $post->likes->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection