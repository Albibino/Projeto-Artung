@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h1 class="text-2xl font-semibold text-gray-800">Editar Postagem</h1>
    </div>

    <div class="px-6 py-6">
      @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
          <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST"
            action="{{ route('posts.update', $post) }}"
            enctype="multipart/form-data"
            class="space-y-6">
        @csrf
        @method('PUT')

        <div>
          <label for="title" class="block text-gray-700 font-medium mb-1">Título</label>
          <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title', $post->title) }}"
            class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
            required
          >
        </div>

        <div>
          <label for="description" class="block text-gray-700 font-medium mb-1">Descrição (opcional)</label>
          <textarea
            name="description"
            id="description"
            rows="4"
            class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
          >{{ old('description', $post->description) }}</textarea>
        </div>

        <div>
          <label class="block text-gray-700 font-medium mb-1">Imagem</label>
          <img
            src="{{ asset('storage/' . $post->image_path) }}"
            alt="{{ $post->title }}"
            class="w-full max-h-95 object-cover rounded mb-2">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          @for($i = 1; $i <= 3; $i++)
            @php
              $field = "tag{$i}_id";
              $current = old($field, $post->$field);
            @endphp
            <div>
              <label for="{{ $field }}" class="block text-gray-700 font-medium mb-1">
                Tag {{ $i }}
              </label>
              <select
                name="{{ $field }}"
                id="{{ $field }}"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
              >
                <option value="">Nenhuma</option>
                @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                  <option value="{{ $tag->id }}" {{ $current == $tag->id ? 'selected' : '' }}>
                    {{ $tag->name }}
                  </option>
                @endforeach
              </select>
            </div>
          @endfor
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end space-x-3">
          <a
            href="{{ route('profile.show', $post->user) }}"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
          >
            Cancelar
          </a>
          <button
            type="submit"
            class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded shadow transition"
          >
            Atualizar
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection