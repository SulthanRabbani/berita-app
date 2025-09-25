<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Berita App'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar Component -->
    <x-navbar
        title="{{ isset($navTitle) ? $navTitle : config('app.name', 'Berita App') }}"
        :show-search="isset($showSearch) ? $showSearch : false"
        :back-url="isset($backUrl) ? $backUrl : null"
        back-text="{{ isset($backText) ? $backText : 'Kembali ke Beranda' }}"
        :additional-buttons="isset($additionalButtons) ? $additionalButtons : null"
    />

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
