<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel Tersimpan - {{ config('app.name', 'Berita App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Berita App</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}"
                       class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="flex items-center space-x-2 pl-2 border-l border-gray-200 hover:bg-gray-50 rounded-lg px-3 py-2 transition duration-200">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ auth()->user()->getAvatarUrl(64) }}"
                                 alt="{{ auth()->user()->name }}">
                            <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
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
                             class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50"
                             style="display: none;">
                            
                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('home') }}" 
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-home w-4"></i>
                                    <span>Beranda</span>
                                </a>
                                
                                <a href="{{ route('user.profile') }}" 
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-user w-4"></i>
                                    <span>Profil Saya</span>
                                </a>
                                
                                <a href="{{ route('user.profile.edit') }}" 
                                   class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                                    <i class="fas fa-edit w-4"></i>
                                    <span>Edit Profil</span>
                                </a>

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
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <i class="fas fa-bookmark text-yellow-500 mr-2"></i>
                Artikel Tersimpan
            </h1>
            <p class="text-xl text-gray-600">
                Kumpulan artikel yang telah Anda simpan untuk dibaca nanti
            </p>
        </div>

        <!-- Bookmarked Articles -->
        <div class="space-y-6">
            @forelse($bookmarks as $bookmark)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300">
                <div class="md:flex">
                    @if($bookmark->article->featured_image)
                    <div class="md:w-1/3">
                        <img class="w-full h-48 md:h-full object-cover"
                             src="{{ $bookmark->article->featured_image }}"
                             alt="{{ $bookmark->article->title }}">
                    </div>
                    @endif

                    <div class="p-6 {{ $bookmark->article->featured_image ? 'md:w-2/3' : 'w-full' }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $bookmark->article->category->name }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Disimpan {{ $bookmark->created_at->locale('id')->diffForHumans() }}
                            </span>
                        </div>

                        <a href="{{ route('article.show', $bookmark->article) }}">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition duration-200">
                                {{ $bookmark->article->title }}
                            </h3>
                        </a>

                        <p class="text-gray-600 mb-4 leading-relaxed">
                            {{ Str::limit($bookmark->article->excerpt ?? strip_tags($bookmark->article->content), 150) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $bookmark->article->published_at->locale('id')->diffForHumans() }}
                                </span>
                                <span>
                                    <i class="far fa-eye mr-1"></i>
                                    {{ number_format($bookmark->article->views_count) }}
                                </span>
                                <span>
                                    <i class="far fa-comment mr-1"></i>
                                    {{ $bookmark->article->comments_count ?? 0 }}
                                </span>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('article.show', $bookmark->article) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                                    Baca Artikel
                                </a>
                                <form method="POST" action="{{ route('article.bookmark', $bookmark->article) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200"
                                            onclick="return confirm('Yakin ingin menghapus artikel dari bookmark?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- No Bookmarks State -->
            <div class="text-center py-16">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="far fa-bookmark"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Artikel Tersimpan</h3>
                <p class="text-gray-500 mb-6">Mulai menyimpan artikel favorit Anda untuk dibaca nanti</p>
                <a href="{{ route('home') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                    Jelajahi Artikel
                </a>
            </div>
            @endforelse

            <!-- Pagination -->
            @if($bookmarks->hasPages())
            <div class="flex justify-center py-8">
                {{ $bookmarks->links() }}
            </div>
            @endif
        </div>
    </main>
</body>
</html>
