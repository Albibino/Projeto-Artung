
<nav x-data="{ open: false }"
     class="fixed inset-y-0 right-0 w-64 bg-cyan-200 border-l border-gray-100 flex flex-col">

    <div class="px-6 py-4 border-b border-gray-100">
        <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-800">
            {{ config('app.name', 'Artung') }}
        </a>
    </div>

    <div class="flex-1 overflow-y-auto px-6 py-8 flex flex-col space-y-2">
        <x-nav-link 
            :href="route('home')" 
            :active="request()->routeIs('home')"
            class="block py-2"
        >
            {{ __('Página Inicial') }}
        </x-nav-link>

        <x-nav-link 
            :href="route('posts.create')" 
            :active="request()->routeIs('posts.create')"
            class="block py-2"
        >
            {{ __('Criar Post') }}
        </x-nav-link>

        @if(auth()->user()->isAdmin() or auth()->user()->isModerator()) 
        <x-nav-link 
            :href="route('tags.index')" 
            :active="request()->routeIs('tags.index')"
            class="block py-2"
        >
            {{ __('Criar Tags') }}
        </x-nav-link>
        @endif

        @if(auth()->user()->isAdmin() or auth()->user()->isModerator())       
          <x-nav-link 
              :href="route('users.index')" 
              :active="request()->routeIs('users.index')"
              class="block py-2"
          >
              {{ __('Gerenciar Usuários') }}
          </x-nav-link>
        @endif
        
    </div>

  <div class="px-6 py-4 border-t mt-auto flex items-center space-x-3">
  @php
      $navPhoto = Auth::user()->profile_photo_path
          && file_exists(public_path('storage/' . Auth::user()->profile_photo_path))
          ? asset('storage/' . Auth::user()->profile_photo_path)
          : asset('images/default-avatar.gif');
  @endphp

      <img 
      src="{{ $navPhoto }}" 
      alt="{{ Auth::user()->name }}" 
      class="h-10 w-10 rounded-full object-cover border"
    />

    <div>
      <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
      <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
    </div>
  </div>

  <div class="px-6 pb-4 space-y-1">
    <x-responsive-nav-link :href="route('profile.show',Auth::user())" class="block py-2">
      {{ __('Perfil') }}
    </x-responsive-nav-link>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <x-responsive-nav-link 
        :href="route('logout')" 
        onclick="event.preventDefault(); this.closest('form').submit();" 
        class="block py-2"
      >
        {{ __('Sair da conta') }}
      </x-responsive-nav-link>
    </form>
  </div>
</nav>
