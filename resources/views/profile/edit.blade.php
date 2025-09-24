<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - {{ config('app.name', 'Berita App') }}</title>
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
                    <a href="{{ route('user.profile') }}"
                       class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Profil</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-user-edit text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Profil</h1>
                    <p class="text-gray-600">Perbarui informasi profil Anda</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Profile Edit Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6">
                    <!-- Current Avatar Display -->
                    <div class="flex flex-col items-center mb-8">
                        <div class="relative">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-blue-200 shadow-lg"
                                 src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=3b82f6&color=fff&size=200' }}"
                                 alt="{{ auth()->user()->name }}"
                                 id="avatar-preview">
                            <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full cursor-pointer shadow-lg transition duration-200">
                                <i class="fas fa-camera text-sm"></i>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Klik icon kamera untuk mengubah foto profil</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-blue-600"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Email digunakan untuk login dengan Google</p>
                        </div>

                        <!-- Bio Field -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user-circle mr-2 text-blue-600"></i>Bio
                            </label>
                            <textarea id="bio" 
                                      name="bio" 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Ceritakan tentang diri Anda...">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>

                        <!-- Location Field -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Lokasi
                            </label>
                            <input type="text" 
                                   id="location" 
                                   name="location" 
                                   value="{{ old('location', auth()->user()->location) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Kota, Negara">
                        </div>

                        <!-- Website Field -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-globe mr-2 text-blue-600"></i>Website
                            </label>
                            <input type="url" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', auth()->user()->website) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://website-anda.com">
                        </div>

                        <!-- Password Section -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-key mr-2 text-blue-600"></i>Ubah Password (Opsional)
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Saat Ini
                                    </label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Masukkan password saat ini">
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Baru
                                    </label>
                                    <input type="password" 
                                           id="password" 
                                           name="password"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Masukkan password baru">
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah password</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                    <a href="{{ route('user.profile') }}" 
                       class="text-gray-600 hover:text-gray-800 font-medium transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mt-6">
            <div class="flex items-start space-x-3">
                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">Informasi Akun</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Akun Anda terdaftar melalui Google OAuth</li>
                        <li>• Perubahan email akan memengaruhi login Google</li>
                        <li>• Password opsional untuk keamanan tambahan</li>
                        <li>• Foto profil akan diperbarui di seluruh platform</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Preview avatar when file is selected
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>