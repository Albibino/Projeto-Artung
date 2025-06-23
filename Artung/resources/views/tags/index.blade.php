@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-gray-800">Gerenciar Tags</h1>
      <div class="space-x-2">
        <a href="{{ route('home') }}"
           class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
          Voltar
        </a>
        <a href="{{ route('tags.create') }}"
           class="inline-block bg-cyan-500 hover:bg-cyan-600 text-white px-4 py-2 rounded">
          Nova Tag
        </a>
      </div>
    </div>

    <div class="px-6 py-6">
      @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
          {{ session('success') }}
        </div>
      @endif

      <div class="overflow-x-auto">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-50">
              <th class="px-4 py-2 text-left text-gray-600">Nome</th>
              <th class="px-4 py-2 text-center text-gray-600">Ações</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tags as $tag)
              <tr class="border-t hover:bg-gray-50">
                <td class="px-4 py-2 text-gray-800">{{ $tag->name }}</td>
                <td class="px-4 py-2 text-center space-x-4">
                  <a href="{{ route('tags.edit', $tag) }}"
                     class="text-blue-600 hover:underline">
                    Editar
                  </a>
                  <form action="{{ route('tags.destroy', $tag) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Excluir tag “{{ $tag->name }}”?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:underline">
                      Excluir
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="px-4 py-4 text-center text-gray-500">
                  Nenhuma tag cadastrada.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection