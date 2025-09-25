@extends('layouts.app')

@section('title', $user->name . ' - Profil - ' . config('app.name', 'Berita App'))

@php
    $backUrl = route('home');
    $backText = 'Kembali ke Beranda';
    $additionalButtons = $isOwnProfile ?
        '<a href="' . route('user.profile.edit') . '" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
            <i class="fas fa-edit"></i>
            <span>Edit Profil</span>
        </a>' : null;
@endphp

@section('content')
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6">
                <!-- Avatar -->
                <div class="relative flex-shrink-0">
                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-gray-50"
                         src="{{ $user->getAvatarUrl(200) }}"
                         alt="{{ $user->name }}">
                    <!-- @if($isOwnProfile)
                    <a href="{{ route('user.profile.edit') }}"
                       class="">
                        <i class="fas fa-pen text-xs"></i>
                    </a>
                    @endif -->
                </div>

                <!-- User Info -->
                <div class="flex-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2 sm:mb-0">{{ $user->name }}</h1>
                        @if($user->role === 'admin')
                        <span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            <i class="fas fa-crown mr-1"></i>
                            Admin
                        </span>
                        @elseif($user->role === 'editor')
                        <span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            <i class="fas fa-pen mr-1"></i>
                            Editor
                        </span>
                        @else
                        <span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            <i class="fas fa-user mr-1"></i>
                            Member
                        </span>
                        @endif
                    </div>

                    @if($user->bio)
                    <p class="text-gray-600 mb-3">{{ $user->bio }}</p>
                    @endif

                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-sm text-gray-500">
                        @if($user->location)
                        <span class="flex items-center space-x-1">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                            <span class="ml-2">{{ $user->location }}</span>
                        </span>
                        @endif

                        @if($user->website)
                        <a href="{{ $user->website }}" target="_blank"
                           class="flex items-center space-x-1 text-blue-600 hover:text-blue-700 transition duration-200">
                            <i class="fas fa-globe text-gray-400"></i>
                            <span>Website</span>
                        </a>
                        @endif

                        <span class="flex items-center space-x-1">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <span class="ml-2">Bergabung {{ $user->created_at->locale('id')->format('M Y') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $articles->total() }}</div>
                <div class="text-sm text-gray-500">Artikel</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $comments->count() }}</div>
                <div class="text-sm text-gray-500">Komentar</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $bookmarks->count() }}</div>
                <div class="text-sm text-gray-500">Tersimpan</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($articles->sum('views_count')) }}</div>
                <div class="text-sm text-gray-500">Views</div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-100">
                <nav class="flex space-x-0">
                    <button class="tab-btn flex-1 py-3 px-4 text-center font-medium text-blue-600 bg-blue-50 border-b-2 border-blue-500" data-tab="articles">
                        Artikel ({{ $articles->total() }})
                    </button>
                    <button class="tab-btn flex-1 py-3 px-4 text-center font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition duration-200" data-tab="comments">
                        Komentar
                    </button>
                    <button class="tab-btn flex-1 py-3 px-4 text-center font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition duration-200" data-tab="bookmarks">
                        Tersimpan
                    </button>
                </nav>
            </div>

            <!-- Articles Tab -->
            <div id="articles" class="tab-content p-6">
                @if($articles->count() > 0)
                <div class="space-y-4">
                    @foreach($articles as $article)
                    <article class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 transition duration-200 border border-transparent hover:border-gray-200">
                        @if($article->featured_image)
                        <img class="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                             src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                        @else
                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-newspaper text-white text-lg"></i>
                        </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('article.show', $article) }}" class="block">
                                <h3 class="font-semibold text-gray-900 hover:text-blue-600 transition duration-200 mb-1 truncate">
                                    {{ $article->title }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                </p>
                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                        {{ $article->category->name }}
                                    </span>
                                    <span>{{ $article->published_at->locale('id')->format('d M Y') }}</span>
                                    <span class="flex items-center space-x-1">
                                        <i class="far fa-eye"></i>
                                        <span>{{ number_format($article->views_count ?? 0) }}</span>
                                    </span>
                                    <span class="flex items-center space-x-1">
                                        <i class="far fa-comment"></i>
                                        <span>{{ $article->comments_count }}</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>

                @if($articles->hasPages())
                <div class="mt-6 flex justify-center">
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
            <div id="comments" class="tab-content hidden p-6">
                @if($comments->count() > 0)
                <div class="space-y-3">
                    @foreach($comments as $comment)
                    <div class="border-l-4 border-blue-200 pl-4 py-3">
                        <div class="flex items-center justify-between mb-1">
                            <a href="{{ route('article.show', $comment->article) }}"
                               class="font-medium text-blue-600 hover:text-blue-700 text-sm">
                                {{ Str::limit($comment->article->title, 60) }}
                            </a>
                            <span class="text-xs text-gray-400">
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
            <div id="bookmarks" class="tab-content hidden p-6">
                @if($isOwnProfile)
                    @if($bookmarks->count() > 0)
                    <div class="space-y-4">
                        @foreach($bookmarks as $bookmark)
                        @php $article = $bookmark->article @endphp
                        <article class="flex items-center space-x-4 p-4 rounded-lg hover:bg-gray-50 transition duration-200 border border-transparent hover:border-gray-200">
                            @if($article->featured_image)
                            <img class="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                                 src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                            @else
                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bookmark text-white text-lg"></i>
                            </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <a href="{{ route('article.show', $article) }}" class="block">
                                    <h3 class="font-semibold text-gray-900 hover:text-blue-600 transition duration-200 mb-1 truncate">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                        {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                    </p>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                            {{ $article->category->name }}
                                        </span>
                                        <span>Disimpan {{ $bookmark->created_at->locale('id')->diffForHumans() }}</span>
                                        <span>{{ $article->user->name }}</span>
                                    </div>
                                </a>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-bookmark text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Anda belum menyimpan artikel</p>
                        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 text-sm mt-2 inline-block">
                            Jelajahi artikel →
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
    </div>
@endsection

@push('scripts')
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
                        b.classList.remove('text-blue-600', 'bg-blue-50', 'border-blue-500');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Add active classes
                    btn.classList.remove('text-gray-500', 'border-transparent');
                    btn.classList.add('text-blue-600', 'bg-blue-50', 'border-b-2', 'border-blue-500');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>
@endpush
