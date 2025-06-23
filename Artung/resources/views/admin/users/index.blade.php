@extends('layouts.app')

@section('content')
@if(Auth::user()->role === 'user')
@else
<div class="max-w-7xl mx-auto px-4 py-6 space-y-4">

  @if(session('success'))
    <div class="p-3 bg-green-500 text-white rounded">
      {{ session('success') }}
    </div>
  @endif

  <h2 class="text-2xl font-semibold">Gerenciar Usuários</h2>

  <table class="w-full bg-white rounded shadow overflow-hidden">
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2 text-left">Nome</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2 text-center">Status</th>
        <th class="px-4 py-2 text-right">Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $user)
        <tr class="border-t">
          <td class="px-4 py-2">
            <div class="flex items-center">
              <img
                src="{{ $user->profile_photo_path
                          ? asset('storage/' . $user->profile_photo_path)
                          : asset('images/default-avatar.png') }}"
                alt="{{ $user->name }}"
                class="h-8 w-8 rounded-full object-cover mr-3"
              />
              <a href="{{ route('profile.show', $user) }}"
                class="font-medium text-gray-800 hover:underline">
                {{ $user->name }}
              </a>
            </div>
          </td>
          <td class="px-4 py-2">{{ $user->email }}</td>
          <td class="px-4 py-2 text-center">
            @if($user->banned_at)
              <span class="text-red-600 font-semibold">
                Banido em {{ $user->banned_at->format('d/m/Y H:i') }}
              </span>
            @else
              <span class="text-green-600 font-semibold">Ativo</span>
            @endif
          </td>
          <td class="px-4 py-2 text-right space-x-2">
            @if($user->isAdmin())
            @else
            @if(!$user->banned_at)
              <form method="POST" action="{{ route('users.ban', $user) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="text-red-600 hover:underline">
                  Banir
                </button>
              </form>
            @else
              <form method="POST" action="{{ route('users.unban', $user) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="text-green-600 hover:underline">
                  Desbanir
                </button>
              </form>
            @endif
            @endif

            @if ($user->isAdmin() or $user->isModerator())
            @else
            <form method="POST" action="{{route('users.promote', $user)}}" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit"
              class="text-blue-600 hover:underline">
              Promover
            </form>
            @endif

            @if ($user->isAdmin() or $user->isUser())
            @else
            </form>
            <form method="POST" action="{{route('users.demote', $user)}}" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit"
              class="text-red-600 hover:underline">
              Demotar
            </form>
            @endif

            @if ($user->isAdmin())
            @else
            <form method="POST"
                  action="{{ route('users.destroy', $user) }}"
                  class="inline"
                  onsubmit="return confirm('Excluir usuário &quot;{{ $user->name }}&quot;?');">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="text-red-600 hover:underline">
                Excluir
              </button>
            </form>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="px-4 py-2 text-center text-gray-500">
            Nenhum usuário encontrado.
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endif 
@endsection