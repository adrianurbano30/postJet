<nav class="bg-gradient-to-r from-white via-gray-300 to-gray-600 fixed top-0 left-0 right-0 z-30" x-data="menu_principal">
    <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button @click="open2=!open2" type="button" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-500 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="sr-only">Open main menu</span>

            <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <svg class="hidden w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
          <div class="flex items-center flex-shrink-0">
            <a href="{{route('/')}} "><img class="block w-8 h-8 rounded-full lg:hidden" src="imagenes/logos/logo.png"></a>
            <a href="{{route('/')}} "><img class="hidden w-10 h-10 rounded-full lg:block" src="imagenes/logos/logo.png"></a>
          </div>
          <div class="hidden sm:block sm:ml-6">
            <div class="flex space-x-4">
                <x-nav-link-tuneado href="{{ route('/') }}" :active="request()->routeIs('/')">
                    Publicaciones
                </x-nav-link-tuneado>
                <x-nav-link-tuneado href="{{ route('prueba') }}" :active="request()->routeIs('prueba')">
                    Pruebas
                </x-nav-link-tuneado>

            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

          @auth
          <div class="relative ml-3">
            <div>
              <button  @click="open=!open" type="button" class="flex p-2 text-sm transition duration-700 {{--bg-gray-800--}} rounded-full focus:outline-none focus:ring-2 focus:ring-offset-1 {{--focus:ring-offset-gray-800--}} focus:ring-white">
                <span class="sr-only">Open user menu</span>
                <img class="object-cover  w-8 h-8 rounded-full"  src="{{$usuario->profile_img}}">
                <span class="self-end font-bold text-white">{{$usuario->name}}</span>
              </button>
            </div>


            <div x-show="open"
                 @click.away="open=false"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 px-1 w-48 py-1 mt-2 origin-top-right bg-gray-500  rounded-md shadow-md shadow-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                <x-dropdown-link-tuneado class="text-base text-gray-900  hover:bg-gray-50 hover:text-gray-900 " href="{{route('perfil')}}">
                    Perfil
                </x-dropdown-link-tuneado>
                {{--FORM CERRAR SESIÓN--}}

                <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link-tuneado class="text-base text-gray-900  hover:bg-gray-50 hover:text-gray-900" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                    this.closest('form').submit();">
                         Cerrar Sesión
                        </x-dropdown-link-tuneado>
                </form>
                {{--END FORM CERRAR SESIÓN--}}
            </div>
          </div>
          @else
            {{-- <x-dropdown-link-tuneado class="text-base text-white hover:bg-gray-700 hover:text-white" href="{{route('login')}}"> --}}
              <x-nav-link-tuneado href="{{ route('login') }}" :active="request()->routeIs('login')">
                {{--Iniciar Sesión--}}
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
              </x-nav-link-tuneado>
              <x-nav-link-tuneado href="{{ route('register') }}" :active="request()->routeIs('register')">
                {{--Registrate--}}
                <i class="fa-solid fa-address-book"></i>
              </x-nav-link-tuneado>
            {{-- </x-dropdown-link-tuneado> --}}
          @endauth
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open2"
         x-cloak
         @click.away="open2=false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="sm:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1">
          <x-responsive-nav-link-tuneado href="{{ route('/') }}" :active="request()->routeIs('/')">
              Publicaciones
          </x-responsive-nav-link-tuneado>
          <x-responsive-nav-link-tuneado href="{{ route('prueba') }}" :active="request()->routeIs('prueba')">
              Pruebas
        </x-responsive-nav-link-tuneado>
      </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('menu_principal', () => ({

                open: false,
                open2:false,


            }))
        })
    </script>
</nav>
