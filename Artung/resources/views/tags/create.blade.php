@extends('layouts.app')

@section('content')
  <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-gray-800">Nova Tag</h1>
      <a href="{{ route('tags.index') }}"
         class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
        Voltar
      </a>
    </div>

    <div class="px-6 py-6">
      @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('tags.store') }}" class="space-y-6">
        @csrf

        <div>
          <label for="name" class="block text-gray-700 font-medium mb-2">
            Nome da Tag
          </label>
          <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name') }}"
            required
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500"
          >
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-cyan-500 hover:bg-cyan-600 text-white font-semibold px-6 py-2 rounded"
          >
            Criar Tag
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
