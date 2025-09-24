@extends('layouts.app')

@section('title', 'Beranda - ' . config('app.name', 'Berita App'))

@section('content')
@php
    $showSearch = true;
@endphp
    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @guest
        <!-- Welcome Message for Guests -->
        <!-- <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 mb-8 text-center text-white">
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
                        <form method="POST" action="{{ route('bookmark.toggle', $article) }}" class="ml-auto">
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
    </div>

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
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-200">Syarat Layanan</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} Berita App. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

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
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fab fa-google text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Bergabunglah dengan Komunitas</h3>
                    <p class="text-gray-600">Masuk untuk membaca, berkomentar, dan menyimpan artikel favorit Anda</p>
                </div>

                <!-- Login Button -->
                <a href="{{ route('google.redirect') }}"
                   class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl text-lg font-medium transition duration-200 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fab fa-google text-xl"></i>
                    <span>Masuk dengan Google</span>
                </a>

                <!-- Features -->
                <div class="mt-6 space-y-3 text-sm text-gray-600">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Baca artikel tanpa batas</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Simpan artikel favorit</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Berikan komentar dan feedback</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Login Modal Functions
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');

            // Trigger animation
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Like Button Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-btn');

            likeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const icon = this.querySelector('i');
                    const countSpan = this.querySelector('.like-count');
                    const currentCount = parseInt(countSpan.textContent.replace(/[^\d]/g, ''));

                    // Toggle like state
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.classList.add('text-red-500');
                        countSpan.textContent = (currentCount + 1).toLocaleString();
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.classList.remove('text-red-500');
                        countSpan.textContent = (currentCount - 1).toLocaleString();
                    }

                    // Add animation
                    icon.classList.add('animate-pulse');
                    setTimeout(() => {
                        icon.classList.remove('animate-pulse');
                    }, 600);
                });
            });

            // Smooth scroll for article links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Infinite scroll placeholder (if needed in future)
            const loadMoreBtn = document.querySelector('.load-more');
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    // Show loading spinner
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
            }
        });
    </script>
@endpush
