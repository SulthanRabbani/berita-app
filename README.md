# Berita App - Laravel News Website

Sebuah website berita yang dibangun menggunakan Laravel 11+ dengan fitur CMS (Content Management System) dan Client UI untuk pembaca. Project ini dibuat sebagai Full Stack Developer Challenge.

## 🚀 Fitur Utama

### CMS (Admin Panel)
- **Dashboard Admin** dengan AdminLTE template
- **Manajemen Artikel** - CRUD dengan WYSIWYG editor
- **Manajemen Kategori** - CRUD kategori artikel
- **Manajemen Tag** - CRUD tag artikel
- **Manajemen User** - CRUD user dengan role system
- **Role System**:
  - **Admin**: Akses penuh ke seluruh fitur CMS
  - **Editor**: Hanya dapat mengelola artikel

### Client UI (Frontend)
- **Daftar Artikel** dengan filter kategori/tag
- **Detail Artikel** dengan sistem komentar
- **Bookmark/Save Artikel** untuk member
- **Profile Management** untuk member
- **Google OAuth** untuk register/login

### Authentication & Membership
- **Google OAuth** login/register
- **Profile Management** (nama, foto, dll)
- **Role-based Access Control**

## 🛠️ Tech Stack

- **Backend**: Laravel 11+
- **Database**: MySQL
- **Frontend**: Blade Templates
- **Admin Template**: AdminLTE
- **Authentication**: Laravel Socialite (Google OAuth)
- **Styling**: Bootstrap (via AdminLTE)

## 📋 Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL
- Git

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/your-username/berita-app.git
cd berita-app
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=berita_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Buat database MySQL:
```sql
CREATE DATABASE berita_app;
```

Jalankan migration:
```bash
php artisan migrate
```

Jalankan seeder (optional):
```bash
php artisan db:seed
```

### 5. Google OAuth Setup

1. Buat project di [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Google+ API
3. Buat OAuth 2.0 credentials
4. Tambahkan konfigurasi di `.env`:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

### 6. Compile Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Run Application

```bash
# Start development server
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🎯 Usage

### Access Points

- **Homepage**: `http://localhost:8000` - Client UI untuk pembaca
- **Admin Panel**: `http://localhost:8000/admin` - CMS untuk admin/editor
- **Login**: `http://localhost:8000/login` - Google OAuth login

### Default Users

Setelah menjalankan seeder, akan tersedia user default:

- **Admin**:
  - Email: admin@example.com
  - Role: Admin
  - Access: Full CMS access

- **Editor**:
  - Email: editor@example.com
  - Role: Editor
  - Access: Article management only

### User Roles

1. **Admin**
   - Manage articles, categories, tags
   - Manage users and roles
   - Full access to admin panel

2. **Editor**
   - Create, edit, delete articles
   - Manage own articles
   - Limited admin panel access

3. **Member**
   - Read articles
   - Comment on articles
   - Bookmark articles
   - Edit own profile

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
