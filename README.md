# Berita App - Laravel News Website 📰# Berita App - Laravel News Website 📰



Website berita modern dengan Laravel 11+ yang dilengkapi CMS Admin dan Client UI. Dibuat dengan implementasi Google OAuth dan role-based access control.Sebuah website berita modern yang dibangun menggunakan Laravel 11+ dengan fitur CMS (Content Management System) dan Client UI untuk pembaca. Project ini dibuat sebagai Full Stack Developer Challenge dengan implementasi Google OAuth, sistem role, dan fitur-fitur modern lainnya.



## ✨ Key Features## � Screenshots



**CMS Admin Panel:***Screenshots akan ditambahkan setelah deployment*

- Dashboard dengan AdminLTE template

- CRUD Artikel dengan WYSIWYG editor- **Homepage**: Tampilan utama dengan daftar artikel terbaru

- Management Kategori & Tag- **Article Detail**: Halaman detail artikel dengan sistem komentar

- User Management dengan role system (Admin/Editor)- **Admin Dashboard**: Panel admin dengan AdminLTE theme

- **Profile Management**: Halaman pengaturan profil user

**Client Interface:**

- Homepage responsive dengan artikel listing## �🚀 Fitur Utama

- Detail artikel + sistem komentar

- Google OAuth login/register### CMS (Admin Panel)

- Profile management & bookmark artikel- **Dashboard Admin** dengan AdminLTE template yang responsive

- **Manajemen Artikel** - CRUD lengkap dengan WYSIWYG editor

**Security & Auth:**- **Manajemen Kategori** - CRUD kategori artikel dengan nested structure

- Google OAuth integration- **Manajemen Tag** - CRUD tag artikel dengan sistem tagging

- Role-based access control- **Manajemen User** - CRUD user dengan role-based access control

- CSRF protection & input validation- **Role System**:

  - **Admin**: Akses penuh ke seluruh fitur CMS

## 🛠️ Tech Stack  - **Editor**: Hanya dapat mengelola artikel dan konten



- **Backend**: Laravel 11+ (PHP 8.2+)### Client UI (Frontend)

- **Database**: MySQL / SQLite- **Homepage Modern** dengan layout responsive

- **Frontend**: Blade + Bootstrap + AdminLTE- **Daftar Artikel** dengan filter kategori/tag dan pagination

- **Auth**: Laravel Socialite (Google OAuth)- **Detail Artikel** dengan sistem komentar real-time

- **Build**: Vite + NPM- **Search Functionality** - pencarian artikel dengan full-text search

- **Bookmark/Save Artikel** untuk member terdaftar

## 🚀 Quick Setup- **Profile Management** untuk member

- **Google OAuth** untuk register/login yang seamless

### Prerequisites

- PHP 8.2+ with extensions (OpenSSL, PDO, Mbstring, etc.)### Authentication & Membership

- Composer- **Google OAuth** login/register dengan Laravel Socialite

- Node.js & NPM- **Profile Management** (nama, foto, bio, dll)

- MySQL (atau SQLite untuk testing)- **Role-based Access Control** dengan middleware

- **Session Management** yang secure

### Installation

## 🛠️ Tech Stack

```bash

# Clone repository- **Backend**: Laravel 11+ dengan PHP 8.2+

git clone https://github.com/SulthanRabbani/berita-app.git- **Database**: MySQL 8.0+ / SQLite (development)

cd berita-app- **Frontend**: Blade Templates dengan Bootstrap

- **Admin Template**: AdminLTE 3.x

# Install dependencies- **Authentication**: Laravel Socialite (Google OAuth)

composer install- **Styling**: Bootstrap 5 + Custom CSS

npm install- **Icons**: Font Awesome 6

- **Build Tool**: Vite

# Setup environment- **Package Manager**: Composer + NPM

cp .env.example .env

php artisan key:generate## 📋 Prerequisites (Yang Harus Diinstall Dulu)



# Configure database di .env fileSebelum menginstall aplikasi ini, pastikan sistem Anda sudah memiliki:

DB_CONNECTION=mysql

DB_DATABASE=berita_app### Required Software:

DB_USERNAME=root- **PHP 8.2 atau lebih tinggi** dengan extensions:

DB_PASSWORD=your_password  - OpenSSL

  - PDO

# Setup Google OAuth di .env  - Mbstring

GOOGLE_CLIENT_ID=your-client-id  - Tokenizer

GOOGLE_CLIENT_SECRET=your-client-secret  - XML

GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback  - Ctype

  - JSON

# Run migrations & seeders  - BCMath

php artisan migrate --seed  - Fileinfo

  - GD (untuk image processing)

# Build assets & run- **Composer** (PHP Package Manager)

npm run build- **Node.js 18+** dan **NPM** (untuk build frontend assets)

php artisan serve- **MySQL 8.0+** atau **PostgreSQL** (untuk production)

```- **Git** (untuk cloning repository)



### Google OAuth Setup### Cara Install Prerequisites:



1. Buka [Google Cloud Console](https://console.cloud.google.com/)#### Windows:

2. Create new project atau pilih existing1. Install **XAMPP** atau **Laragon** (sudah include PHP, MySQL, Apache)

3. Enable "Google+ API" atau "Google Identity API"2. Install **Composer** dari https://getcomposer.org/download/

4. Create OAuth 2.0 credentials:3. Install **Node.js** dari https://nodejs.org/

   - Application type: Web application4. Install **Git** dari https://git-scm.com/

   - Authorized redirect URI: `http://localhost:8000/auth/google/callback`

5. Copy Client ID & Secret ke file `.env`#### macOS:

```bash

## 🎯 Access Points# Install Homebrew jika belum ada

/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

- **Homepage**: `http://localhost:8000` - Public website

- **Admin Panel**: `http://localhost:8000/admin` - CMS dashboard# Install requirements

- **Login**: Login dengan Google OAuthbrew install php@8.2 mysql node composer git

```

### Default Admin Accounts

- **Admin**: admin@example.com / password#### Ubuntu/Debian:

- **Editor**: editor@example.com / password```bash

# Update package manager

## 🔧 Key Commandssudo apt update



```bash# Install PHP dan extensions

# Developmentsudo apt install php8.2 php8.2-cli php8.2-common php8.2-mysql php8.2-xml php8.2-xmlrpc php8.2-curl php8.2-gd php8.2-imagick php8.2-dev php8.2-imap php8.2-mbstring php8.2-opcache php8.2-soap php8.2-zip php8.2-intl -y

npm run dev              # Watch assets

php artisan serve        # Start server# Install MySQL

sudo apt install mysql-server -y

# Database

php artisan migrate:fresh --seed   # Reset DB# Install Composer

php artisan storage:link           # Link storagecurl -sS https://getcomposer.org/installer | php

sudo mv composer.phar /usr/local/bin/composer

# Cache (production)

php artisan config:cache# Install Node.js dan NPM

php artisan route:cachecurl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -

php artisan view:cachesudo apt-get install -y nodejs

```

# Install Git

## 🚨 Common Issuessudo apt install git -y

```

**Google OAuth Error:**

- Pastikan redirect URI di Google Console exact match## 🚀 Installation Guide (Step by Step)

- Check GOOGLE_* variables di .env

### Step 1: Clone Repository

**Database Error:**

- Buat database manual: `CREATE DATABASE berita_app;````bash

- Check DB credentials di .env# Clone project dari GitHub

git clone https://github.com/SulthanRabbani/berita-app.git

**Permission Error:**

```bash# Masuk ke folder project

chmod -R 775 storage bootstrap/cachecd berita-app

```

# Cek apakah berhasil

## 📁 Project Structurels -la

```

```

app/Http/Controllers/### Step 2: Install Dependencies

├── Admin/          # Admin panel controllers

├── Auth/           # Google OAuth controller```bash

└── Client/         # Public website controllers# Install PHP dependencies dengan Composer

composer install

resources/views/

├── admin/          # AdminLTE views# Jika ada error "composer command not found", pastikan Composer sudah diinstall

├── client/         # Public website views

└── auth/           # Authentication views# Install NPM dependencies untuk frontend

npm install

database/

├── migrations/     # Database schema# Jika ada error npm, coba:

└── seeders/        # Sample data# npm install --legacy-peer-deps

``````



## 🔐 User Roles### Step 3: Environment Configuration



- **Admin**: Full access ke semua fitur CMS```bash

- **Editor**: Hanya manage artikel & content# Copy file environment template

- **Member**: Read, comment, bookmark artikel (via Google login)cp .env.example .env



## 🌐 Production Ready# Generate application key

php artisan key:generate

Project sudah include:```

- Environment-based configuration

- Security best practices**Penting**: Edit file `.env` yang baru dibuat dengan konfigurasi yang sesuai:

- Production optimization commands

- Error handling & validation```env

# Ubah nama aplikasi sesuai keinginan

## 📞 ContactAPP_NAME="My News Website"

APP_URL=http://localhost:8000

**Developer**: [SulthanRabbani](https://github.com/SulthanRabbani)

**Repository**: https://github.com/SulthanRabbani/berita-app# Database Configuration

DB_CONNECTION=mysql

---DB_HOST=127.0.0.1

DB_PORT=3306

**Built with ❤️ using Laravel 11+**DB_DATABASE=berita_app
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Step 4: Database Setup

#### Opsi A: Menggunakan MySQL (Recommended untuk Production)

1. **Buka MySQL/phpMyAdmin atau MySQL Command Line:**
```sql
-- Login ke MySQL
mysql -u root -p

-- Buat database baru
CREATE DATABASE berita_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Cek database berhasil dibuat
SHOW DATABASES;

-- Keluar dari MySQL
exit;
```

2. **Update file `.env` dengan konfigurasi MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=berita_app
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

#### Opsi B: Menggunakan SQLite (Untuk Development/Testing)

```bash
# Buat file database SQLite
touch database/database.sqlite

# Update .env
DB_CONNECTION=sqlite
# Comment atau hapus setting MySQL lainnya
```

### Step 5: Google OAuth Setup (WAJIB)

Aplikasi ini menggunakan Google OAuth untuk login. Ikuti langkah berikut:

1. **Buka [Google Cloud Console](https://console.cloud.google.com/)**

2. **Buat Project Baru atau Pilih Project yang Ada:**
   - Klik "Select a project" > "New Project"
   - Nama project: "Berita App" (atau sesuai keinginan)
   - Klik "Create"

3. **Enable Google+ API:**
   - Di dashboard, klik "Enable APIs and Services"
   - Cari "Google+ API" dan enable
   - Atau enable "Google Identity API"

4. **Buat OAuth 2.0 Credentials:**
   - Pergi ke "Credentials" di sidebar
   - Klik "Create Credentials" > "OAuth client ID"
   - Application type: "Web application"
   - Name: "Berita App OAuth"
   - Authorized JavaScript origins: `http://localhost:8000`
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
   - Klik "Create"

5. **Copy Credentials ke `.env`:**
```env
GOOGLE_CLIENT_ID=1234567890-abcdef.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-your-client-secret-here
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

**⚠️ Penting**: Jangan share Client Secret ke publik atau commit ke Git!

### Step 6: Run Database Migrations

```bash
# Jalankan migration untuk membuat tabel database
php artisan migrate

# Jika ada error "database not found", pastikan database sudah dibuat di Step 4

# Jalankan seeder untuk data dummy (optional tapi recommended)
php artisan db:seed
```

**Data Default Setelah Seeding:**
- **Admin User**: 
  - Email: admin@example.com
  - Password: password
  - Role: Admin
- **Editor User**: 
  - Email: editor@example.com  
  - Password: password
  - Role: Editor

### Step 7: Storage Setup

```bash
# Create symbolic link untuk storage
php artisan storage:link

# Set permission (Linux/Mac only)
chmod -R 775 storage bootstrap/cache
```

### Step 8: Compile Frontend Assets

```bash
# Untuk development (dengan file watching)
npm run dev

# Atau untuk production build
npm run build
```

**Catatan**: Jika menggunakan `npm run dev`, biarkan terminal ini tetap berjalan di background.

### Step 9: Run the Application

```bash
# Start Laravel development server
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

## 🎯 Testing the Application

### Access Points:

1. **Homepage**: `http://localhost:8000`
   - Tampilan utama website dengan daftar artikel
   - Try: Klik artikel, coba login dengan Google

2. **Admin Panel**: `http://localhost:8000/admin`
   - Login dengan: admin@example.com / password
   - Test: Create artikel, manage categories

3. **Google Login**: `http://localhost:8000/login`
   - Klik "Login with Google"
   - Pastikan redirect berjalan dengan benar

### Troubleshooting Testing:

```bash
# Test Google OAuth configuration
php artisan route:list | grep google

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Clear caches jika ada masalah
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 🔧 Development Commands

### Artisan Commands Berguna:

```bash
# Create new admin user (custom command)
php artisan make:admin-user

# Clear all caches
php artisan optimize:clear

# Run tests
php artisan test

# Check routes
php artisan route:list

# Database operations
php artisan migrate:fresh --seed   # Reset database
php artisan db:seed --class=AdminUserSeeder  # Run specific seeder

# Queue operations (jika menggunakan jobs)
php artisan queue:work
```

### NPM Commands:

```bash
# Development dengan hot reload
npm run dev

# Production build
npm run build  

# Check dependencies
npm list

# Update dependencies
npm update
```

## 🚨 Common Issues & Solutions

### Issue 1: "Class not found" Error
```bash
# Solution:
composer dump-autoload
php artisan config:clear
```

### Issue 2: Google OAuth "redirect_uri_mismatch"
```bash
# Check your Google Console settings:
# Authorized redirect URIs must exactly match:
http://localhost:8000/auth/google/callback
```

### Issue 3: "Permission denied" on storage
```bash
# Linux/Mac:
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache

# Windows: Run CMD as Administrator
icacls storage /grant Everyone:F /T
```

### Issue 4: Database Migration Errors
```bash
# Drop and recreate database
php artisan migrate:fresh

# Or check database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Issue 5: NPM Install Errors
```bash
# Clear NPM cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

### Issue 6: "Vite manifest not found"
```bash
# Build assets properly
npm run build

# Or run dev server
npm run dev
```

## 📁 Project Structure

```
berita-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/              # Admin panel controllers
│   │   ├── Auth/               # Authentication controllers
│   │   └── Client/             # Client-facing controllers
│   ├── Models/                 # Eloquent models
│   │   ├── Article.php
│   │   ├── Category.php
│   │   ├── User.php
│   │   └── ...
│   └── Policies/               # Authorization policies
├── database/
│   ├── migrations/             # Database schema
│   ├── seeders/               # Sample data
│   └── factories/             # Model factories for testing
├── resources/
│   ├── views/
│   │   ├── admin/             # Admin panel views (AdminLTE)
│   │   ├── client/            # Public website views
│   │   └── auth/              # Authentication views
│   ├── css/                   # Custom stylesheets
│   └── js/                    # JavaScript files
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes (future)
├── public/                    # Public assets
└── storage/                   # File uploads, logs, cache
```

## 🔐 Security Features

- **CSRF Protection** pada semua form
- **SQL Injection Prevention** dengan Eloquent ORM
- **XSS Protection** dengan Blade templating
- **Route Protection** dengan middleware authentication
- **Role-based Access Control** untuk admin/editor
- **Input Validation** & Sanitization pada semua input
- **Secure Session Management**
- **File Upload Security** dengan validation

## 🌐 Production Deployment

### Persiapan untuk Production:

1. **Update Environment:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Database Production:**
```env
DB_CONNECTION=mysql
DB_HOST=your-production-host
DB_DATABASE=your-production-db
DB_USERNAME=your-production-user
DB_PASSWORD=your-secure-password
```

3. **Optimize untuk Production:**
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build production assets
npm run build

# Set proper permissions
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

### Deployment Platforms:

- **Shared Hosting**: Upload via FTP/cPanel
- **VPS**: Setup with Nginx/Apache + PHP-FPM
- **Cloud**: Heroku, DigitalOcean, AWS, Google Cloud
- **Laravel Forge**: Automated deployment

## 📝 API Documentation

Basic API endpoints tersedia di `/api` route (untuk future mobile app development):

```
GET    /api/articles           # List articles
GET    /api/articles/{id}      # Show article
GET    /api/categories         # List categories
POST   /api/comments           # Create comment (auth required)
```

API menggunakan Laravel Sanctum untuk authentication.

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage (jika xdebug enabled)
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/ArticleTest.php
```

## 🤝 Contributing

Contributions sangat welcomed! Silakan:

1. Fork repository ini
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buka Pull Request

### Development Guidelines:

- Follow PSR-12 coding standards
- Write tests untuk fitur baru
- Update documentation
- Ensure no breaking changes

## 📞 Support & Community

- **GitHub Issues**: [Report bugs or request features](https://github.com/SulthanRabbani/berita-app/issues)
- **Email**: sulthanrabbani@example.com
- **Documentation**: Lihat folder `/docs` untuk dokumentasi detail

## 📄 License

Project ini adalah open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Credits

- **Developer**: [SulthanRabbani](https://github.com/SulthanRabbani)
- **Framework**: Laravel 11+
- **Admin Theme**: AdminLTE
- **Challenge**: Full Stack Developer Position
- **Special Thanks**: Laravel Community, AdminLTE Team

## 🎉 What's Next?

Roadmap untuk development selanjutnya:
- [ ] Mobile App dengan Flutter/React Native
- [ ] RESTful API dengan Laravel Sanctum
- [ ] Real-time notifications dengan WebSockets
- [ ] Advanced search dengan Elasticsearch
- [ ] Multi-language support
- [ ] Newsletter system
- [ ] Social media sharing
- [ ] SEO optimization

---

**🚀 Happy Coding! Selamat mencoba aplikasi Berita App!**

Jika ada pertanyaan atau masalah, jangan ragu untuk membuat issue di GitHub atau hubungi developer. Good luck! 💪

## 🎯 Usage Guide

### Access Points & Testing:

1. **Homepage - Client Interface**
   - URL: `http://localhost:8000`
   - Features: Browse articles, search, filter by categories
   - Test: Klik artikel untuk melihat detail, coba fitur search

2. **Admin Panel - Content Management**
   - URL: `http://localhost:8000/admin`  
   - Login: admin@example.com / password
   - Features: Manage articles, categories, tags, users
   - Test: Buat artikel baru, upload gambar, manage categories

3. **Google OAuth Authentication**
   - URL: `http://localhost:8000/login`
   - Klik "Login with Google" untuk testing OAuth
   - Pastikan Google credentials sudah dikonfigurasi dengan benar

### Default User Accounts

Setelah menjalankan database seeder (`php artisan db:seed`), tersedia user default:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`
- Role: Admin (full access)
- Akses: Seluruh fitur CMS dan manajemen user

**Editor Account:**
- Email: `editor@example.com`  
- Password: `password`
- Role: Editor (limited access)
- Akses: Hanya manajemen artikel dan konten

### User Role Permissions

#### 🔧 Admin Role
- ✅ Create, read, update, delete articles
- ✅ Manage categories dan tags
- ✅ Manage users dan roles  
- ✅ Access admin dashboard dan analytics
- ✅ System settings dan configuration

#### ✏️ Editor Role
- ✅ Create, read, update, delete articles (own articles)
- ✅ Manage categories dan tags
- ❌ Cannot manage users
- ❌ Limited dashboard access
- ❌ No system settings access

#### 👤 Member/User Role (via Google OAuth)
- ✅ Read articles dan browse content
- ✅ Comment on articles
- ✅ Bookmark/save articles
- ✅ Edit own profile
- ❌ No admin panel access

## 🔧 Development

### Artisan Commands

```bash
# Create new admin user
php artisan make:admin-user

# Clear all caches
php artisan optimize:clear

# Run tests
php artisan test
```

### File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   ├── Auth/           # Authentication controllers
│   └── Client/         # Client-facing controllers
├── Models/             # Eloquent models
├── Policies/           # Authorization policies
└── Providers/          # Service providers

resources/
├── views/
│   ├── admin/          # Admin panel views (AdminLTE)
│   ├── client/         # Client UI views
│   └── auth/           # Authentication views
└── js/                 # JavaScript assets

database/
├── migrations/         # Database migrations
├── seeders/           # Database seeders
└── factories/         # Model factories
```

## 🔐 Security Features

- CSRF Protection
- SQL Injection Prevention
- XSS Protection
- Route Protection with Middleware
- Role-based Access Control
- Input Validation & Sanitization

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 📝 API Documentation

API endpoints tersedia di `/api` dengan authentication via Sanctum (jika diperlukan untuk mobile app di masa depan).

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👥 Team

- **Developer**: [Your Name]
- **Challenge**: Full Stack Developer Position
- **Framework**: Laravel 11+

## 📞 Support

Jika ada pertanyaan atau issue, silakan buat [GitHub Issue](https://github.com/your-username/berita-app/issues) atau hubungi developer.

---

**Happy Coding! 🚀**


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
