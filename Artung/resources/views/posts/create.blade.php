@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
      <h1 class="text-2xl font-semibold text-gray-800">Novo Post</h1>
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

      <form method="POST" action="{{ route('posts.store') }}"
            enctype="multipart/form-data"
            class="space-y-6">
        @csrf

        <div>
          <label for="title" class="block text-gray-700 font-medium mb-1">Título</label>
          <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title') }}"
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
          >{{ old('description') }}</textarea>
        </div>

        <div>
          <label for="image" class="block text-gray-700 font-medium mb-1">Imagem</label>
          <input
            type="file"
            name="image"
            id="image"
            class="w-full text-gray-700"
            required
          >
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          @for($i = 1; $i <= 3; $i++)
            <div>
              <label for="tag{{ $i }}_id" class="block text-gray-700 font-medium mb-1">
                Tag {{ $i }}
              </label>
              <select
                name="tag{{ $i }}_id"
                id="tag{{ $i }}_id"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
              >
                <option value="">Nenhuma</option>
                @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                  <option
                    value="{{ $tag->id }}"
                    {{ old("tag{$i}_id") == $tag->id ? 'selected' : '' }}
                  >
                    {{ $tag->name }}
                  </option>
                @endforeach
              </select>
            </div>
          @endfor
        </div>

        <div class="pt-4 border-t border-gray-200 flex justify-end">
          <button
            type="submit"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold px-6 py-2 rounded shadow"
          >
            Publicar
          </button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const selects = [
      document.getElementById('tag1_id'),
      document.getElementById('tag2_id'),
      document.getElementById('tag3_id'),
    ];

    function refreshOptions() {
      const chosen = selects.map(s => s.value).filter(v => v !== '');
      selects.forEach(sel => {
        Array.from(sel.options).forEach(opt => {
          opt.disabled = (
            opt.value !== '' &&
            chosen.includes(opt.value) &&
            sel.value !== opt.value
          );
        });
      });
    }

    selects.forEach(sel => sel.addEventListener('change', refreshOptions));

    refreshOptions();
  });
  </script>
  @endpush
@endsection