@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 space-y-6">

    {{-- Foto + formulário de upload --}}
    <div class="relative w-32 h-32 rounded-full overflow-hidden group">
        {{-- Foto atual --}}
        <img
        class="w-32 h-32 rounded-full object-cover"
        src="{{ $user->profile_photo_url }}"
        alt="Foto de perfil de {{ $user->name }}"
        >

        @if (Auth::id() === $user->id)
            {{-- Overlay ao hover --}}
            <form
                action="{{ route('profile.photo.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="absolute inset-0 rounded-full bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
            >
                @csrf

                <label for="photo" class="cursor-pointer text-white">
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
    {{-- Título e detalhes --}}
    <h1 class="text-2xl font-bold text-gray-900">Perfil de {{ $user->name }}</h1>
    <p class="text-gray-700">Email: {{ $user->email }}</p>

    {{-- Posts --}}
    <div class="max-w-4xl mx-auto py-6 px-4">
        <h2 class="text-xl mt-6 mb-2 text-black">Posts de {{ $user->name }}:</h2>

        @forelse ($user->posts as $post)
        @empty
            <p class="text-gray-500 italic">Este usuário ainda não publicou nenhum post.</p>
        @endforelse

        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($user->posts as $post)
                <li class="bg-cyan-300 p-4 rounded text-white">
                    <div class="aspect-w-16 aspect-h-9">
                        <img
                            src="{{ asset('storage/' . $post->image_path) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover rounded-t"
                        >
                    </div>
                    <strong class="text-black">{{ $post->title }}</strong>

                    @if (auth()->check() && auth()->id() === $post->user_id)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                onclick="return confirm('Tem certeza que deseja excluir este post?')"
                                class="text-red-400 hover:text-red-600 text-sm"
                            >
                                🗑️ Excluir post
                            </button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
