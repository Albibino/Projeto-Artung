@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto px-4 space-y-8">

    {{-- Foto e upload --}}
    <div class="flex items-center space-x-6">
      <div class="relative w-32 h-32 rounded-full overflow-hidden group">
        <img
          src="{{ $user->profile_photo_url }}"
          alt="Foto de perfil de {{ $user->name }}"
          class="w-full h-full object-cover"
        >

        @if(auth()->id() === $user->id)
          <form
            action="{{ route('profile.photo.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-full"
          >
            @csrf
            <label for="photo" class="cursor-pointer text-white px-3 py-1 bg-gray-800 bg-opacity-75 rounded">
              Alterar
            </label>
            <input
              id="photo"
              name="photo"
              type="file"
              accept="image/*"
              class="hidden"
              onchange="this.form.submit()"
            >
          </form>
        @endif
      </div>

      <div>
        <h1 class="text-3xl font-bold text-gray-900">Perfil de {{ $user->name }}</h1>
        <p class="mt-1 text-gray-600">{{ $user->email }}</p>
      </div>
    </div>

    {{-- Posts --}}
    <section class="space-y-4">
      <h2 class="text-2xl font-semibold text-gray-800">Posts de {{ $user->name }}</h2>

      @if($user->posts->isEmpty())
        <p class="text-gray-500 italic">Este usuário ainda não publicou nenhum post.</p>
      @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($user->posts as $post)
            <li class="bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col overflow-hidden">
              {{-- Imagem --}}
              <div class="aspect-w-16 aspect-h-9">
                <img
                  src="{{ asset('storage/' . $post->image_path) }}"
                  alt="{{ $post->title }}"
                  class="w-full h-full object-cover"
                >
              </div>

              <div class="p-4 flex-1 flex flex-col justify-between">
                <h3 class="text-lg font-bold text-gray-800">{{ $post->title }}</h3>

                @if(auth()->id() === $post->user_id)
                  <form
                    action="{{ route('posts.destroy', $post) }}"
                    method="POST"
                    class="mt-4 text-right"
                    onsubmit="return confirm('Excluir post “{{ $post->title }}”?');"
                  >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                      🗑️ Excluir
                    </button>
                  </form>
                @endif
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </section>
    <div class="mt-10">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Posts Curtidos</h2>
      @if($likedPosts->isEmpty())
        <p class="text-gray-500 italic">Este usuário ainda não curtiu nenhum post.</p>
      @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($likedPosts as $post)
            <li class="bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col overflow-hidden">
              <div class="aspect-w-16 aspect-h-9">
                <img
                  src="{{ asset('storage/' . $post->image_path) }}"
                  alt="{{ $post->title }}"
                  class="w-full h-full object-cover"
                >
              </div>

              <div class="p-4 flex-1 flex flex-col justify-between">
                <h3 class="text-lg font-bold text-gray-800">{{ $post->title }}</h3>
                <p class="text-sm text-gray-600 mt-2">
                  por
                  <a href="{{ route('profile.show', $post->user_id) }}" class="text-indigo-400 hover:underline">
                    {{ $post->user->name }}
                  </a>
                </p>
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
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
@endsection
