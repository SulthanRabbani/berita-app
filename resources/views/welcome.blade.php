<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Berita App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Berita App</span>
                    </a>
                </div>

                <!-- Search Bar - Always Visible -->
                <div class="flex-1 max-w-md mx-4">
                    <form method="GET" action="{{ route('home') }}" class="relative w-full">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari artikel..."
                               class="w-full px-4 py-2 text-sm border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 pr-10">
                        <!-- <button type="submit"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600 transition duration-200">
                            <i class="fas fa-search"></i>
                        </button> -->
                    </form>
                </div>

                <div class="flex items-center space-x-3 sm:space-x-4">
                    @auth
                        <a href="{{ route('bookmarks.index') }}"
                           class="text-gray-700 hover:text-yellow-600 transition duration-200">
                            <i class="fas fa-bookmark text-xl"></i>
                        </a>
                        <a href="{{ route('user.profile') }}"
                           class="text-gray-700 hover:text-blue-600 transition duration-200">
                            <i class="fas fa-user text-xl"></i>
                        </a>
                        <div class="flex items-center space-x-3 pl-2 border-l border-gray-200">
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=3b82f6&color=fff' }}"
                                 alt="{{ auth()->user()->name }}">
                            <span class="text-sm font-medium text-gray-900 hidden md:block">{{ auth()->user()->name }}</span>
                        </div>
                    @else
                        <button onclick="openLoginModal()"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 flex items-center justify-center z-50 hidden" style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="p-8">
                <!-- Close Button -->
                <div class="flex justify-end mb-4">
                    <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600 transition duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Header -->
                <div class="text-center mb-8">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-newspaper text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Berita App</h2>
                    <p class="text-gray-600">Bergabunglah untuk membaca, berkomentar, dan menyimpan artikel favorit Anda</p>
                </div>

                <!-- Google Login Button -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}"
                       class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center space-x-3 shadow-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Masuk dengan Google</span>
                    </a>
                </div>

                <!-- Terms -->
                <p class="text-xs text-gray-500 text-center mt-6">
                    Dengan masuk, Anda menyetujui
                    <a href="#" class="text-blue-600 hover:underline">Syarat & Ketentuan</a>
                    dan
                    <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a>
                    kami.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Temukan Berita <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Terkini</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Platform berita modern dengan pengalaman seperti media sosial untuk mengikuti perkembangan terkini
            </p>
        </div>

        @guest
        <!-- Login CTA -->
        <!-- <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-12 text-center">
            <div class="mb-6">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fab fa-google text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Bergabunglah dengan Komunitas</h3>
                <p class="text-gray-600 mb-6">Masuk untuk membaca, berkomentar, dan menyimpan artikel favorit Anda</p>
                <a href="{{ route('login') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-medium transition duration-200 inline-flex items-center space-x-2">
                    <i class="fab fa-google"></i>
                    <span>Masuk dengan Google</span>
                </a>
            </div>
        </div> -->
        @endguest

        <!-- Articles Feed -->
        <div class="space-y-8">
            @forelse($articles as $article)
            <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300">
                <!-- Article Header -->
                <div class="p-6 pb-4">
                    <div class="flex items-center justify-end mb-2">
                        <button class="text-gray-400 hover:text-gray-600 transition duration-200">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>
                </div>

                <!-- Article Image -->
                @if($article->featured_image)
                <div class="aspect-video bg-gradient-to-r from-blue-500 to-purple-600 relative">
                    <img class="w-full h-full object-cover"
                         src="{{ $article->featured_image }}"
                         alt="{{ $article->title }}"
                         loading="lazy">
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $article->category->name }}
                        </span>
                    </div>
                </div>
                @else
                <div class="aspect-video bg-gradient-to-r from-blue-500 to-purple-600 relative flex items-center justify-center">
                    <div class="text-white text-6xl opacity-20">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium">
                            {{ $article->category->name }}
                        </span>
                    </div>
                </div>
                @endif

                <!-- Article Actions -->
                <div class="p-6 pt-4">
                    <div class="flex items-center space-x-6 mb-4">
                        <button class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition duration-200 group like-btn"
                                data-article-id="{{ $article->id }}">
                            <i class="far fa-heart text-xl group-hover:fas"></i>
                            <span class="font-medium like-count">{{ number_format(rand(50, 2000)) }}</span>
                        </button>
                        <a href="{{ route('article.show', $article) }}"
                           class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 transition duration-200">
                            <i class="far fa-comment text-xl"></i>
                            <span class="font-medium">{{ $article->comments_count }}</span>
                        </a>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <i class="far fa-eye text-xl"></i>
                            <span class="font-medium">{{ number_format($article->views_count ?? rand(100, 10000)) }}</span>
                        </div>
                        @auth
                        <form method="POST" action="{{ route('article.bookmark', $article) }}" class="ml-auto">
                            @csrf
                            <button type="submit"
                                    class="flex items-center space-x-2 text-gray-600 hover:text-yellow-500 transition duration-200 bookmark-btn">
                                <i class="{{ $article->bookmarked_by_user ? 'fas' : 'far' }} fa-bookmark text-xl"></i>
                            </button>
                        </form>
                        @else
                        <button onclick="openLoginModal()"
                                class="flex items-center space-x-2 text-gray-600 hover:text-yellow-500 transition duration-200 ml-auto">
                            <i class="far fa-bookmark text-xl"></i>
                        </button>
                        @endauth
                    </div>

                    <!-- Article Content -->
                    <div class="space-y-3">
                        <a href="{{ route('article.show', $article) }}">
                            <h2 class="text-xl font-bold text-gray-900 hover:text-blue-600 transition duration-200 cursor-pointer">
                                {{ $article->title }}
                            </h2>
                        </a>

                        <!-- Article Meta -->
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="far fa-clock"></i>
                            <span>{{ $article->published_at->locale('id')->diffForHumans() }}</span>
                            <span>•</span>
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium">
                                {{ $article->category->name }}
                            </span>
                        </div>

                        <p class="text-gray-600 leading-relaxed">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 200) }}
                        </p>
                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">Disukai oleh</span>
                                <div class="flex -space-x-2">
                                    @for($i = 0; $i < 3; $i++)
                                    <img class="h-6 w-6 rounded-full border-2 border-white"
                                         src="https://ui-avatars.com/api/?name=User{{ $i }}&background={{ ['f59e0b', '10b981', '8b5cf6'][rand(0,2)] }}&color=fff" alt="">
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">dan {{ number_format(rand(50, 2000)) }} lainnya</span>
                            </div>
                            <a href="{{ route('article.show', $article) }}"
                               class="text-blue-600 hover:text-blue-700 font-medium text-sm transition duration-200">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <!-- No Articles State -->
            <div class="text-center py-16">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Artikel</h3>
                <p class="text-gray-500">Artikel akan muncul di sini setelah admin menerbitkannya.</p>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}"
                           class="mt-4 inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Artikel Pertama</span>
                        </a>
                    @endif
                @endauth
            </div>
            @endforelse

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="flex justify-center py-8">
                {{ $articles->links() }}
            </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-2 rounded-lg">
                            <i class="fas fa-newspaper text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Berita App</span>
                    </div>
                    <p class="text-gray-600 max-w-md">
                        Platform berita modern dengan teknologi Laravel dan desain seperti Instagram untuk pengalaman terbaik dalam mengikuti perkembangan terkini.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition duration-200">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition duration-200">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-600 transition duration-200">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-700 transition duration-200">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Teknologi</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Bisnis</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Gaya Hidup</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Olahraga</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Kontak</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Privasi</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Terms</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-12 pt-8 text-center">
                <p class="text-gray-500">
                    © {{ date('Y') }} Berita App. Dibuat dengan ❤️ untuk memberikan pengalaman membaca terbaik.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Modal functions
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');

            // Animate modal appearance
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');

            // Animate modal disappearance
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLoginModal();
            }
        });

        // Like button functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Like buttons
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const heart = this.querySelector('i');
                    const countSpan = this.querySelector('.like-count');
                    const currentCount = parseInt(countSpan.textContent.replace(/[^\d]/g, ''));

                    if (heart.classList.contains('far')) {
                        // Like
                        heart.classList.remove('far');
                        heart.classList.add('fas');
                        this.classList.add('text-red-500');
                        countSpan.textContent = formatNumber(currentCount + 1);

                        // Add animation
                        heart.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            heart.style.transform = 'scale(1)';
                        }, 200);
                    } else {
                        // Unlike
                        heart.classList.remove('fas');
                        heart.classList.add('far');
                        this.classList.remove('text-red-500');
                        countSpan.textContent = formatNumber(currentCount - 1);
                    }
                });
            });

            // Bookmark buttons
            document.querySelectorAll('.bookmark-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const bookmark = this.querySelector('i');

                    if (bookmark.classList.contains('far')) {
                        // Bookmark
                        bookmark.classList.remove('far');
                        bookmark.classList.add('fas');
                        this.classList.add('text-yellow-500');

                        // Add animation
                        bookmark.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            bookmark.style.transform = 'scale(1)';
                        }, 200);

                        // Show toast notification
                        showToast('Artikel berhasil disimpan!', 'success');
                    } else {
                        // Remove bookmark
                        bookmark.classList.remove('fas');
                        bookmark.classList.add('far');
                        this.classList.remove('text-yellow-500');

                        showToast('Artikel dihapus dari simpanan', 'info');
                    }
                });
            });

            // Format numbers (1000 -> 1k, etc.)
            function formatNumber(num) {
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'k';
                } else {
                    return num.toString();
                }
            }

            // Toast notification function
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${
                    type === 'success' ? 'bg-green-500' :
                    type === 'error' ? 'bg-red-500' :
                    'bg-blue-500'
                }`;
                toast.textContent = message;

                document.body.appendChild(toast);

                // Slide in
                setTimeout(() => {
                    toast.style.transform = 'translateX(0)';
                }, 100);

                // Slide out and remove
                setTimeout(() => {
                    toast.style.transform = 'translateX(full)';
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Smooth scroll for links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add loading animation to article links
            document.querySelectorAll('a[href*="article"]').forEach(link => {
                link.addEventListener('click', function() {
                    const loadingSpinner = document.createElement('div');
                    loadingSpinner.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                    loadingSpinner.innerHTML = `
                        <div class="bg-white p-6 rounded-lg flex items-center space-x-3">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <span class="text-gray-700">Sedang memuat artikel...</span>
                        </div>
                    `;
                    document.body.appendChild(loadingSpinner);
                });
            });
        });
    </script>
</body>
</html>
