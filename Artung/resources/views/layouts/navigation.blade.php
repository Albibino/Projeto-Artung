{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }"
     class="fixed inset-y-0 right-0 w-64 bg-cyan-200 border-l border-gray-100 flex flex-col">

    {{-- Logo / Título --}}
    <div class="px-6 py-4 border-b border-gray-100">
        <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-800">
            {{ config('app.name', 'Artung') }}
        </a>
    </div>

    {{-- Links de navegação (vertical) --}}
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

        {{-- Adicione outros links aqui, um por linha --}}
    </div>

    {{-- Bloco de perfil no rodapé --}}
  <div class="px-6 py-4 border-t mt-auto flex items-center space-x-3">
    {{-- Avatar --}}
    <img 
      src="{{ Auth::user()->profile_photo_url }}" 
      alt="{{ Auth::user()->name }}" 
      class="h-10 w-10 rounded-full object-cover border"
    />

    {{-- Nome / E-mail --}}
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
