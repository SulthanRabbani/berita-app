<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }} - Profil - {{ config('app.name', 'Berita App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
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
                    <a href="{{ route('home') }}"
                       class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                    
                    @auth
                        @if($isOwnProfile)
                        <a href="{{ route('user.profile.edit') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('bookmarks.index') }}"
                           class="text-gray-700 hover:text-yellow-600 transition duration-200">
                            <i class="fas fa-bookmark text-xl"></i>
                        </a>

                        <div class="flex items-center space-x-2 pl-2 border-l border-gray-200">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=3b82f6&color=fff' }}"
                                 alt="{{ auth()->user()->name }}">
                            <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-32"></div>
            <div class="px-8 pb-8">
                <div class="flex flex-col md:flex-row items-start md:items-end space-y-4 md:space-y-0 md:space-x-6 -mt-16">
                    <!-- Avatar -->
                    <div class="relative">
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-lg bg-white"
                             src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=300' }}"
                             alt="{{ $user->name }}">
                        @if($isOwnProfile)
                        <a href="{{ route('user.profile.edit') }}" 
                           class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-lg transition duration-200">
                            <i class="fas fa-camera text-sm"></i>
                        </a>
                        @endif
                    </div>

                    <!-- User Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            @if($user->role === 'admin')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-crown mr-1"></i>
                                Admin
                            </span>
                            @elseif($user->role === 'editor')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-pen mr-1"></i>
                                Editor
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-user mr-1"></i>
                                Member
                            </span>
                            @endif
                        </div>
                        
                        @if($user->bio)
                        <p class="text-gray-600 mb-3">{{ $user->bio }}</p>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            @if($user->location)
                            <span class="flex items-center space-x-1">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $user->location }}</span>
                            </span>
                            @endif
                            
                            @if($user->website)
                            <a href="{{ $user->website }}" target="_blank" 
                               class="flex items-center space-x-1 text-blue-600 hover:text-blue-700">
                                <i class="fas fa-globe"></i>
                                <span>Website</span>
                            </a>
                            @endif
                            
                            <span class="flex items-center space-x-1">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Bergabung {{ $user->created_at->locale('id')->format('F Y') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $articles->total() }}</p>
                        <p class="text-sm text-gray-600">Artikel</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <i class="fas fa-comments text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $comments->count() }}</p>
                        <p class="text-sm text-gray-600">Komentar</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <i class="fas fa-bookmark text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $bookmarks->count() }}</p>
                        <p class="text-sm text-gray-600">Tersimpan</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <i class="fas fa-eye text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($articles->sum('views_count')) }}</p>
                        <p class="text-sm text-gray-600">Total Views</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-8">
                    <button class="tab-btn py-4 text-blue-600 border-b-2 border-blue-600 font-medium" data-tab="articles">
                        <i class="fas fa-newspaper mr-2"></i>
                        Artikel ({{ $articles->total() }})
                    </button>
                    <button class="tab-btn py-4 text-gray-500 hover:text-gray-700 font-medium" data-tab="comments">
                        <i class="fas fa-comments mr-2"></i>
                        Komentar Terbaru
                    </button>
                    <button class="tab-btn py-4 text-gray-500 hover:text-gray-700 font-medium" data-tab="bookmarks">
                        <i class="fas fa-bookmark mr-2"></i>
                        Artikel Tersimpan
                    </button>
                </nav>
            </div>

            <!-- Articles Tab -->
            <div id="articles" class="tab-content p-8">
                @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($articles as $article)
                    <article class="group cursor-pointer">
                        <a href="{{ route('article.show', $article) }}" class="block">
                            <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition duration-300">
                                @if($article->featured_image)
                                <img class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                                     src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                                @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                                </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                            {{ $article->category->name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $article->published_at->locale('id')->diffForHumans() }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition duration-300 mb-2">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 100) }}
                                    </p>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <i class="far fa-comment"></i>
                                            <span>{{ $article->comments_count }}</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <i class="far fa-eye"></i>
                                            <span>{{ number_format($article->views_count ?? 0) }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
                
                @if($articles->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $articles->links() }}
                </div>
                @endif
                @else
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">{{ $isOwnProfile ? 'Anda belum menulis artikel' : $user->name . ' belum menulis artikel' }}</p>
                </div>
                @endif
            </div>

            <!-- Comments Tab -->
            <div id="comments" class="tab-content hidden p-8">
                @if($comments->count() > 0)
                <div class="space-y-4">
                    @foreach($comments as $comment)
                    <div class="border border-gray-100 rounded-lg p-4 hover:bg-gray-50 transition duration-200">
                        <div class="flex items-start justify-between mb-2">
                            <a href="{{ route('article.show', $comment->article) }}" 
                               class="text-blue-600 hover:text-blue-700 font-medium">
                                {{ $comment->article->title }}
                            </a>
                            <span class="text-xs text-gray-500">
                                {{ $comment->created_at->locale('id')->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">{{ $isOwnProfile ? 'Anda belum memberikan komentar' : $user->name . ' belum memberikan komentar' }}</p>
                </div>
                @endif
            </div>

            <!-- Bookmarks Tab -->
            <div id="bookmarks" class="tab-content hidden p-8">
                @if($isOwnProfile)
                    @if($bookmarks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($bookmarks as $bookmark)
                        @php $article = $bookmark->article @endphp
                        <article class="group">
                            <a href="{{ route('article.show', $article) }}" class="block">
                                <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition duration-300">
                                    @if($article->featured_image)
                                    <img class="w-full h-32 object-cover group-hover:scale-105 transition duration-300"
                                         src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                                    @else
                                    <div class="w-full h-32 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-2xl opacity-50"></i>
                                    </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition duration-300 mb-1">
                                            {{ $article->title }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-2">
                                            {{ Str::limit($article->excerpt ?? strip_tags($article->content), 80) }}
                                        </p>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span>{{ $article->category->name }}</span>
                                            <span>{{ $bookmark->created_at->locale('id')->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-bookmark text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Anda belum menyimpan artikel</p>
                        <a href="{{ route('bookmarks.index') }}" class="text-blue-600 hover:text-blue-700 text-sm mt-2 inline-block">
                            Lihat semua bookmark →
                        </a>
                    </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-lock text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Bookmark bersifat privat</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.getAttribute('data-tab');

                    // Remove active classes
                    tabBtns.forEach(b => {
                        b.classList.remove('text-blue-600', 'border-blue-600');
                        b.classList.add('text-gray-500');
                    });

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Add active classes
                    btn.classList.remove('text-gray-500');
                    btn.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>