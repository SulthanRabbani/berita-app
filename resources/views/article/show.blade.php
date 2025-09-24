<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - {{ config('app.name', 'Berita App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="description" content="{{ $article->excerpt }}">
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
                    @auth
                        <div class="flex items-center space-x-2">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                                 alt="{{ auth()->user()->name }}">
                            <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Masuk</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Article Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-6 pb-4">
                <div class="flex items-center space-x-3 mb-6">
                    <img class="h-12 w-12 rounded-full object-cover"
                         src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name) }}&background=3b82f6&color=fff"
                         alt="{{ $article->user->name }}">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">{{ $article->user->name }}</h4>
                        <p class="text-sm text-gray-500">
                            {{ $article->published_at->format('d F Y, H:i') }} • {{ $article->category->name }}
                        </p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $article->category->name }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                <p class="text-xl text-gray-600 leading-relaxed mb-6">
                    {{ $article->excerpt }}
                </p>
                @endif
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="aspect-video bg-gradient-to-r from-blue-500 to-purple-600 relative">
                <img class="w-full h-full object-cover"
                     src="{{ $article->featured_image }}"
                     alt="{{ $article->title }}"
                     loading="lazy">
            </div>
            @endif

            <!-- Article Actions -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-6">
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition duration-200 group like-btn">
                        <i class="far fa-heart text-xl group-hover:fas"></i>
                        <span class="font-medium like-count">{{ number_format(rand(100, 3000)) }}</span>
                    </button>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <i class="far fa-comment text-xl"></i>
                        <span class="font-medium">{{ $article->comments->count() }} Komentar</span>
                    </div>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <i class="far fa-eye text-xl"></i>
                        <span class="font-medium">{{ number_format($article->views_count) }} Kali Dilihat</span>
                    </div>
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-yellow-500 transition duration-200 ml-auto bookmark-btn">
                        <i class="far fa-bookmark text-xl"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </div>

            <!-- Article Content -->
            <div class="p-6">
                <div class="prose prose-lg max-w-none">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                Komentar ({{ $article->comments->count() }})
            </h3>

            @auth
            <!-- Comment Form -->
            <div class="mb-8">
                <div class="flex space-x-3">
                    <img class="h-10 w-10 rounded-full object-cover"
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff"
                         alt="{{ auth()->user()->name }}">
                    <div class="flex-1">
                        <textarea class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                  rows="3"
                                  placeholder="Tulis komentar Anda..."></textarea>
                        <div class="flex justify-end mt-3">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                                Kirim Komentar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-8 text-center py-8 bg-gray-50 rounded-lg">
                <p class="text-gray-600 mb-4">Masuk untuk memberikan komentar</p>
                <a href="{{ route('login') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Masuk
                </a>
            </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6">
                @forelse($article->comments->sortByDesc('created_at') as $comment)
                <div class="flex space-x-3">
                    <img class="h-10 w-10 rounded-full object-cover"
                         src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background={{ ['3b82f6', '10b981', '8b5cf6', 'f59e0b', 'ef4444'][rand(0,4)] }}&color=fff"
                         alt="{{ $comment->user->name }}">
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="text-gray-400 text-4xl mb-4">
                        <i class="far fa-comments"></i>
                    </div>
                    <p class="text-gray-500">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">
            <p class="text-gray-500">
                © {{ date('Y') }} Berita App. Dibuat dengan ❤️ untuk memberikan pengalaman membaca terbaik.
            </p>
        </div>
    </footer>

    <script>
        // Like and bookmark functionality (same as homepage)
        document.addEventListener('DOMContentLoaded', function() {
            // Like button
            document.querySelector('.like-btn')?.addEventListener('click', function() {
                const heart = this.querySelector('i');
                const countSpan = this.querySelector('.like-count');
                const currentCount = parseInt(countSpan.textContent.replace(/[^\d]/g, ''));

                if (heart.classList.contains('far')) {
                    heart.classList.remove('far');
                    heart.classList.add('fas');
                    this.classList.add('text-red-500');
                    countSpan.textContent = (currentCount + 1).toLocaleString('id-ID');

                    heart.style.transform = 'scale(1.2)';
                    setTimeout(() => heart.style.transform = 'scale(1)', 200);
                } else {
                    heart.classList.remove('fas');
                    heart.classList.add('far');
                    this.classList.remove('text-red-500');
                    countSpan.textContent = (currentCount - 1).toLocaleString('id-ID');
                }
            });

            // Bookmark button
            document.querySelector('.bookmark-btn')?.addEventListener('click', function() {
                const bookmark = this.querySelector('i');

                if (bookmark.classList.contains('far')) {
                    bookmark.classList.remove('far');
                    bookmark.classList.add('fas');
                    this.classList.add('text-yellow-500');

                    bookmark.style.transform = 'scale(1.2)';
                    setTimeout(() => bookmark.style.transform = 'scale(1)', 200);
                } else {
                    bookmark.classList.remove('fas');
                    bookmark.classList.add('far');
                    this.classList.remove('text-yellow-500');
                }
            });
        });
    </script>
</body>
</html>
