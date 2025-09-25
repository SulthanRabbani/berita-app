# Berita App - Website Berita Berbasis Laravel 📰

Aplikasi website berita modern yang dibangun dengan **Laravel 11**, dilengkapi sistem CMS (Content Management System) untuk admin dan antarmuka yang ramah pengguna untuk pembaca. Proyek ini mengimplementasikan autentikasi **Google OAuth** dan kontrol akses berbasis peran (*role-based access control*).


## ✨ Fitur Utama

| CMS (Admin Panel) | Client UI (Frontend) |
| :--- | :--- |
| ✅ Dashboard admin dengan AdminLTE | ✅ Homepage modern & responsif |
| ✅ Manajemen Artikel (CRUD) dengan editor WYSIWYG | ✅ Daftar artikel dengan filter & pencarian |
| ✅ Manajemen Kategori & Tag | ✅ Halaman detail artikel yang bersih |
| ✅ Manajemen User & Peran (Admin/Editor) | ✅ Sistem komentar pada artikel |
| ✅ Sistem otorisasi berbasis peran | ✅ Login & Registrasi via Google OAuth |
| | ✅ Fitur Bookmark artikel untuk member |
| | ✅ Halaman profil pengguna |

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade, Bootstrap 5, Vite
- **Admin Template**: AdminLTE 3
- **Database**: MySQL / SQLite
- **Autentikasi**: Laravel Socialite (Google OAuth)
- **Package Manager**: Composer & NPM
- **Icons**: Font Awesome 6

---

## 🚀 Panduan Instalasi

### 1. Prasyarat (Prerequisites)

Pastikan lingkungan development Anda sudah terpasang:
- **PHP 8.2+**
- **Composer**
- **Node.js 18+** & **NPM**
- **MySQL** atau **SQLite**
- **Git**

<details>
<summary>Klik di sini untuk panduan instalasi prasyarat di berbagai OS</summary>

#### Windows:
1.  Install **Laragon** atau **XAMPP** (sudah termasuk PHP, MySQL).
2.  Install **Composer** dari [getcomposer.org](https://getcomposer.org/download/).
3.  Install **Node.js** dari [nodejs.org](https://nodejs.org/).
4.  Install **Git** dari [git-scm.com](https://git-scm.com/).

#### macOS (via Homebrew):
```bash
# Install Homebrew jika belum ada
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install semua kebutuhan
brew install php@8.2 mysql node composer git
```

#### Ubuntu/Linux:
```bash
# Update package manager
sudo apt update

# Install PHP dan ekstensi
sudo apt install php8.2 php8.2-cli php8.2-mysql php8.2-xml php8.2-curl php8.2-gd php8.2-mbstring php8.2-zip php8.2-intl -y

# Install MySQL
sudo apt install mysql-server -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install Git
sudo apt install git -y
```
</details>

---

### 2. Langkah Instalasi

Ikuti langkah-langkah berikut secara berurutan:

#### Clone Repository
```bash
git clone https://github.com/SulthanRabbani/berita-app.git
cd berita-app
```

#### Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### Setup Environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### Konfigurasi Database
Edit file `.env` dan sesuaikan pengaturan database:

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=berita_app
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

**Untuk SQLite (Development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
# Comment atau hapus setting MySQL lainnya
```

#### Buat Database
**MySQL:**
```sql
CREATE DATABASE berita_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**SQLite:**
```bash
touch database/database.sqlite
```

#### Setup Google OAuth
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Aktifkan **Google+ API** atau **Google Identity API**
4. Buat **OAuth 2.0 credentials**:
   - Application type: **Web application**
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback`

5. Tambahkan ke file `.env`:
```env
GOOGLE_CLIENT_ID=your-google-client-id.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

#### Jalankan Migrasi & Seeder
```bash
# Jalankan migrasi database
php artisan migrate

# Jalankan seeder untuk data dummy (opsional tapi direkomendasikan)
php artisan db:seed
```

#### Build Assets & Jalankan Server
```bash
# Build assets frontend
npm run build

# Atau untuk development dengan file watching
npm run dev

# Buat symbolic link untuk storage
php artisan storage:link

# Jalankan server development
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## 🎯 Cara Menggunakan

### Akses Aplikasi

| URL | Deskripsi |
| :--- | :--- |
| `http://localhost:8000` | **Homepage** - Interface publik untuk membaca artikel |
| `http://localhost:8000/login` | **Admin Panel** - Dashboard untuk mengelola konten |

### Kredensial Login Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

| Role | Email | Password | Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@example.com` | `password` | Full access ke semua fitur CMS |
| **Editor** | `editor@example.com` | `password` | Hanya manajemen artikel & konten |

### Fitur yang Dapat Dicoba

#### 👥 Untuk Pembaca (Public):
- Browse dan baca artikel di homepage
- Gunakan fitur pencarian dan filter kategori
- Login dengan akun Google untuk fitur member
- Tinggalkan komentar pada artikel
- Bookmark artikel favorit

#### 🔧 Untuk Admin/Editor:
- Login ke admin panel dengan kredensial di atas
- Kelola artikel: buat, edit, hapus dengan WYSIWYG editor
- Atur kategori dan tag artikel
- Kelola komentar pengguna
- (Khusus Admin) Kelola user accounts dan permissions

---

## 🔧 Perintah Development

### Artisan Commands
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Database operations
php artisan migrate:fresh --seed    # Reset database
php artisan migrate:rollback        # Rollback migrations

# Queue (jika diperlukan)
php artisan queue:work
```

### NPM Scripts
```bash
npm run dev          # Development dengan hot reload
npm run build        # Production build
npm run watch        # Watch file changes
```

---

## 🚨 Troubleshooting

### Error Umum dan Solusinya

#### 1. Google OAuth Error
**Problem**: `redirect_uri_mismatch`
```bash
# Pastikan URL di Google Console sama persis:
http://localhost:8000/auth/google/callback
```

#### 2. Database Connection Error
**Problem**: `SQLSTATE[HY000] [1049] Unknown database`
```bash
# Pastikan database sudah dibuat
mysql -u root -p
CREATE DATABASE berita_app;
```

#### 3. Permission Error (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

#### 4. Composer/NPM Install Error
```bash
# Clear cache dan reinstall
composer clear-cache
composer install

npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

---

## 📁 Struktur Project

```
berita-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/              # Admin panel controllers
│   │   ├── Auth/               # Google OAuth controller
│   │   └── Client/             # Public website controllers
│   ├── Models/                 # Eloquent models
│   └── Policies/               # Authorization policies
├── database/
│   ├── migrations/             # Database schema
│   ├── seeders/               # Sample data
│   └── factories/             # Model factories
├── resources/
│   ├── views/
│   │   ├── admin/             # AdminLTE views
│   │   ├── client/            # Public website views
│   │   └── auth/              # Authentication views
│   ├── css/ & js/             # Frontend assets
└── routes/
    ├── web.php                # Web routes
    └── api.php                # API routes (future)
```

---

## 🤝 Contributing

Contributions welcome! Silakan:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

---

## 📄 Lisensi

Proyek ini menggunakan [MIT License](LICENSE). Anda bebas menggunakan, memodifikasi, dan mendistribusikan dengan tetap menyertakan credit.

---

## 👨‍💻 Developer

**Dikembangkan oleh**: [SulthanRabbani](https://github.com/SulthanRabbani)  
**Repository**: https://github.com/SulthanRabbani/berita-app  

---

*⭐ Jika project ini membantu, jangan lupa berikan star di GitHub!*


