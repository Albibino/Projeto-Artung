@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-black mb-6">Criar Novo Post</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-600 text-white rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="bg-cyan-300 p-6 rounded shadow text-white">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-black font-semibold mb-1">Título</label>
            <input type="text" name="title" id="title" class="w-full rounded p-2 text-black" required value="{{ old('title') }}">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-black font-semibold mb-1">Descrição (opcional)</label>
            <textarea name="description" id="description" rows="3" class="w-full rounded p-2 text-black">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-black font-semibold mb-1">Imagem</label>
            <input type="file" name="image" id="image" class="w-full text-black" required>
        </div>

        <button type="submit" class="bg-cyan-500 hover:bg-cyan-700 text-black font-semibold py-2 px-4 rounded">
            Publicar
        </button>
    </form>
</div>
@endsection
