@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto px-4 space-y-8">

    <div class="flex items-center space-x-6">
      @php
          $photo = $user->profile_photo_path
                && file_exists(public_path('storage/'.$user->profile_photo_path))
              ? asset('storage/'.$user->profile_photo_path)
              : asset('images/default-avatar.gif');
      @endphp

      <div class="relative w-32 h-32 rounded-full overflow-hidden group">
          <img
              class="w-32 h-32 rounded-full object-cover"
              src="{{ $photo }}"
              alt="Foto de perfil de {{ $user->name }}"
          >

          @if(auth()->id() === $user->id)
            <form
              action="{{ route('profile.photo.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition rounded-full"
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

    @if($user->banned_at)
      <div class="p-6 bg-red-100 border border-red-300 text-red-800 rounded-lg text-center">
        Usuário banido em {{ $user->banned_at->format('d/m/Y H:i') }}.
      </div>
    @else

    <section class="space-y-4">
      <h2 class="text-2xl font-semibold text-gray-800">Posts de {{ $user->name }}</h2>

      @if($user->posts->isEmpty())
        <p class="text-gray-500 italic">Este usuário ainda não publicou nenhum post.</p>
      @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach($user->posts as $post)
            <li class="bg-white rounded-lg shadow hover:shadow-md transition-shadow flex flex-col overflow-hidden">
              <div class="overflow-hidden rounded-t">
                <img
                  src="{{ asset('storage/' . $post->image_path) }}"
                  alt="{{ $post->title }}"
                  class="w-full h-auto object-cover max-h-80"
                >
              </div>

              <div class="p-4 flex-1 flex flex-col justify-between">
                <h3 class="text-lg font-bold text-gray-800">{{ $post->title }}</h3>

                @php $viewer = auth()->user(); @endphp

                @if($viewer->isAdmin() || $viewer->isModerator())

                  <div class="flex justify-end space-x-4 mt-4">
                    <a href="{{ route('posts.edit', $post) }}"
                      class="text-blue-600 hover:text-blue-800 text-sm inline-block">
                      ✏️ Editar
                    </a>
                    <form action="{{ route('posts.PostdestroyAdmin', $post) }}"
                          method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir esse post?')"
                          class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="text-red-600 hover:text-red-800 text-sm">
                        🗑️ Excluir Post (Admin)
                      </button>
                    </form>
                  </div>

                @elseif($viewer->id === $post->user_id)

                    <div class="flex justify-end space-x-4 mt-4">
                    <a href="{{ route('posts.edit', $post) }}"
                      class="text-blue-600 hover:text-blue-800 text-sm inline-block">
                      ✏️ Editar
                    </a>
                    <form action="{{ route('posts.edit', $post) }}"
                          method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir esse post?')"
                          class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="text-red-600 hover:text-red-800 text-sm">
                        🗑️ Excluir meu post
                      </button>
                    </form>
                  </div>
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
              <div class="overflow-hidden rounded-t">
                <img
                  src="{{ asset('storage/' . $post->image_path) }}"
                  alt="{{ $post->title }}"
                  class="w-full h-auto object-cover max-h-96"
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
  @endif
@endsection
