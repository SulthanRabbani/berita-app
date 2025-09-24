@props([
    'title' => config('app.name', 'Berita App'),
    'showSearch' => true,
    'backUrl' => null,
    'backText' => 'Kembali ke Beranda',
    'additionalButtons' => null
])

<!-- Navigation -->
<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="bg-blue-600 p-2 rounded-lg">
                        <i class="fas fa-newspaper text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Berita App</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Search Bar - Conditionally shown -->
                @if($showSearch)
                <div class="flex-1 max-w-md mx-4">
                    <form method="GET" action="{{ route('home') }}" class="relative w-full">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari artikel..."
                               class="w-full px-4 py-2 text-sm border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 pr-10">
                    </form>
                </div>
                @endif

                <!-- Back Button - Conditionally shown -->
                @if($backUrl)
                <a href="{{ $backUrl }}"
                   class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>{{ $backText }}</span>
                </a>
                @endif

                <!-- Additional Buttons Slot -->
                @if($additionalButtons)
                    {!! $additionalButtons !!}
                @endif

                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-3 pl-2 border-l border-gray-200 hover:bg-gray-50 rounded-lg px-3 py-2 transition duration-200">
                            <img class="h-8 w-8 rounded-full object-cover ring-2 ring-transparent hover:ring-blue-300 transition-all"
                                 src="{{ auth()->user()->getAvatarUrl(64) }}"
                                 alt="{{ auth()->user()->name }}">
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 z-50"
                             style="display: none;">

                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <img class="h-12 w-12 rounded-full object-cover"
                                         src="{{ auth()->user()->getAvatarUrl(80) }}"
                                         alt="{{ auth()->user()->name }}">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-gray-900 truncate">{{ auth()->user()->name }}</div>
                                        <div class="text-sm text-gray-500 truncate" title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</div>
                                        <div class="text-xs text-blue-600 capitalize">{{ auth()->user()->role }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                @unless(request()->routeIs('home'))
                                <a href="{{ route('home') }}"
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-home w-4"></i>
                                    <span>Beranda</span>
                                </a>
                                @endunless

                                @unless(request()->routeIs('user.profile'))
                                <a href="{{ route('user.profile') }}"
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user w-4"></i>
                                    <span>Profil Saya</span>
                                </a>
                                @endunless

                                @unless(request()->routeIs('user.profile.edit'))
                                <a href="{{ route('user.profile.edit') }}"
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-edit w-4"></i>
                                    <span>Edit Profil</span>
                                </a>
                                @endunless

                                @unless(request()->routeIs('bookmarks.index'))
                                <a href="{{ route('bookmarks.index') }}"
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition duration-200">
                                    <i class="fas fa-bookmark w-4"></i>
                                    <span>Artikel Tersimpan</span>
                                </a>
                                @endunless

                                @if(auth()->user()->canManageArticles())
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition duration-200">
                                        <i class="fas fa-tachometer-alt w-4"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                </div>
                                @endif

                                <!-- Logout -->
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <form method="POST" action="{{ route('auth.logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit"
                                                class="flex items-center space-x-3 px-4 py-2 text-red-600 hover:bg-red-50 transition duration-200 w-full text-left">
                                            <i class="fas fa-sign-out-alt w-4"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Login Button for guests -->
                    <a href="{{ route('google.redirect') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fab fa-google"></i>
                        <span>Login dengan Google</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
