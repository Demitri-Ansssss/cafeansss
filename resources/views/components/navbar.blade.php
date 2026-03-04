<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-xl font-bold tracking-tight text-slate-900 flex items-center gap-2">
                        <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <span>AnsssCafe</span>
                    </a>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:-my-px sm:ml-10 sm:flex sm:space-x-8 items-center">
                <a href="{{ route('order.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('order.*') ? 'border-amber-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium transition duration-150 ease-in-out">
                    Menu
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('orders.*') ? 'border-amber-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium transition duration-150 ease-in-out">
                    Pesanan
                </a>
            </div>

            <!-- User Actions (Desktop) -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <div x-data="{ userMenu: false }" class="ml-3 relative">
                        <div>
                            <button @click="userMenu = !userMenu" type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" id="user-menu" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-semibold border border-slate-300">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                        </div>
                        <div x-show="userMenu" 
                             @click.away="userMenu = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                            <!-- <a href="/admin" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Panel Admin</a> -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition underline-offset-4 hover:underline">Masuk</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-sm transition">
                            Daftar
                        </a>
                    </div> -->
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500 transition" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{'hidden': open, 'block': !open }" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{'block': open, 'hidden': !open }" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="sm:hidden border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->is('/') ? 'bg-amber-50 border-amber-500 text-amber-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium transition">
                Beranda
            </a>
            <a href="{{ route('order.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('order.*') ? 'bg-amber-50 border-amber-500 text-amber-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium transition">
                Menu
            </a>
            <a href="{{ route('orders.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('orders.*') ? 'bg-amber-50 border-amber-500 text-amber-700' : 'border-transparent text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-800' }} text-base font-medium transition">
                Pesanan
            </a>
        </div>
        <div class="pt-4 pb-3 border-t border-slate-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex shrink-0">
                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-semibold border border-slate-300 text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-slate-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-slate-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">Keluar</button>
                    </form>
                </div>
            @else
               
            @endauth
        </div>
    </div>
</nav>
