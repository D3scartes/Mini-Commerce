<nav x-data="{ open: false, dark: localStorage.getItem('theme') === 'dark' }"
     x-init="
        $watch('dark', value => {
            localStorage.setItem('theme', value ? 'dark' : 'light');
            if(value){ document.documentElement.classList.add('dark'); }
            else { document.documentElement.classList.remove('dark'); }
        });
        if(dark){ document.documentElement.classList.add('dark'); }
        else { document.documentElement.classList.remove('dark'); }
     "
>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- Dashboard selalu ada --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    {{-- Semua user bisa lihat Produk --}}
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        Produk
                    </x-nav-link>

                    @auth
                        {{-- Buyer Menu --}}
                        @if(auth()->user()->role === 'buyer')
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                Keranjang
                            </x-nav-link>

                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                                Pesanan
                            </x-nav-link>
                        @endif

                        {{-- Admin Menu --}}
                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                Kelola Produk
                            </x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            Kelola Kategori
                            </x-nav-link>
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                Kelola Pesanan
                            </x-nav-link>
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                                Keranjang Admin
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <!-- Theme Toggle -->
                <button @click="dark = !dark" type="button"
                        class="p-2 rounded-full border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <span class="text-xs font-bold dark:text-gray-200" x-text="dark ? '🌙' : '☀️'"></span>
                </button>

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profile
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-200">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-200">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Dashboard --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            {{-- Produk selalu ada --}}
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                Produk
            </x-responsive-nav-link>

            @auth
                {{-- Buyer --}}
                @if(auth()->user()->role === 'buyer')
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        Keranjang
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        Pesanan
                    </x-responsive-nav-link>
                @endif

                {{-- Admin --}}
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        Kelola Produk
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                        Pesanan Admin
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profile
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                              onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4 flex gap-2">
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-200">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-2 text-sm rounded hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-700 dark:text-gray-200">Register</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
