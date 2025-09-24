@extends('layouts.app')

@section('title', 'Artikel Tersimpan - ' . config('app.name', 'Berita App'))

@php
    $backUrl = route('home');
    $backText = 'Kembali ke Beranda';
@endphp

@section('content')
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
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $bookmark->article->user->name }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>{{ $bookmark->article->published_at->locale('id')->format('d M Y') }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="far fa-eye"></i>
                                    <span>{{ number_format($bookmark->article->views_count ?? 0) }} views</span>
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('article.show', $bookmark->article) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 text-sm">
                                    Baca Artikel
                                </a>
                                
                                <form method="POST" action="{{ route('bookmark.toggle', $bookmark->article) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 p-2 rounded-lg transition duration-200"
                                            title="Hapus dari tersimpan">
                                        <i class="fas fa-bookmark"></i>
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
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 inline-flex items-center space-x-2">
                    <i class="fas fa-search"></i>
                    <span>Jelajahi Artikel</span>
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
@endsection