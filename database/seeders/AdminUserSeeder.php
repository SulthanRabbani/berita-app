<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@berita-app.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]
        );

        // Create Editor User
        $editor = User::firstOrCreate(
            ['email' => 'editor@berita-app.com'],
            [
                'name' => 'Editor',
                'email_verified_at' => now(),
                'role' => 'editor',
                'password' => bcrypt('password'),
            ]
        );

        // Create Member User
        $member = User::firstOrCreate(
            ['email' => 'member@berita-app.com'],
            [
                'name' => 'Member',
                'email_verified_at' => now(),
                'role' => 'member',
                'password' => bcrypt('password'),
            ]
        );

        // Create Categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Technology news and updates'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports news and events'],
            ['name' => 'Politics', 'slug' => 'politics', 'description' => 'Political news and analysis'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'description' => 'Entertainment news and celebrity updates'],
            ['name' => 'Health', 'slug' => 'health', 'description' => 'Health tips and medical news'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Create Tags
        $tags = [
            'Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'MySQL', 'Bootstrap',
            'Programming', 'Web Development', 'Tutorial', 'News', 'Tips', 'Guide'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName, 'slug' => Str::slug($tagName)]
            );
        }

        // Create Sample Articles
        $techCategory = Category::where('slug', 'technology')->first();
        $laravelTag = Tag::where('slug', 'laravel')->first();
        $phpTag = Tag::where('slug', 'php')->first();

        $sampleArticles = [
            [
                'title' => 'Getting Started with Laravel 11',
                'slug' => 'getting-started-with-laravel-11',
                'excerpt' => 'Learn the basics of Laravel 11 and build your first web application.',
                'content' => '<h2>Introduction to Laravel 11</h2><p>Laravel 11 brings exciting new features and improvements that make web development even more enjoyable. In this comprehensive guide, we\'ll explore the fundamentals of Laravel and build a complete application from scratch.</p><h3>What\'s New in Laravel 11</h3><p>Laravel 11 introduces several enhancements including improved performance, new Artisan commands, and better testing capabilities. Let\'s dive into these features and see how they can benefit your development workflow.</p><h3>Setting Up Your Development Environment</h3><p>Before we start building our application, let\'s make sure your development environment is properly configured with PHP 8.2+, Composer, and other necessary tools.</p><p>This is just a sample article content to demonstrate the CMS functionality.</p>',
                'status' => 'published',
                'user_id' => $admin->id,
                'category_id' => $techCategory->id,
                'published_at' => now()->subDays(2),
                'views_count' => 156,
            ],
            [
                'title' => 'Advanced PHP Programming Techniques',
                'slug' => 'advanced-php-programming-techniques',
                'excerpt' => 'Explore advanced PHP concepts and best practices for professional development.',
                'content' => '<h2>Advanced PHP Concepts</h2><p>PHP has evolved significantly over the years, and modern PHP development involves many advanced concepts that can help you write cleaner, more efficient code.</p><h3>Object-Oriented Programming in PHP</h3><p>Understanding OOP principles is crucial for advanced PHP development. We\'ll cover encapsulation, inheritance, polymorphism, and abstraction with practical examples.</p><h3>Design Patterns</h3><p>Learn about common design patterns like Singleton, Factory, Observer, and MVC that are widely used in PHP frameworks and applications.</p>',
                'status' => 'published',
                'user_id' => $editor->id,
                'category_id' => $techCategory->id,
                'published_at' => now()->subDays(1),
                'views_count' => 89,
            ],
            [
                'title' => 'Building Modern Web Applications',
                'slug' => 'building-modern-web-applications',
                'excerpt' => 'A comprehensive guide to building modern, responsive web applications.',
                'content' => '<h2>Modern Web Development</h2><p>Building modern web applications requires understanding of various technologies and best practices. This guide will walk you through the process of creating a full-stack application.</p><h3>Frontend Technologies</h3><p>We\'ll explore HTML5, CSS3, JavaScript ES6+, and modern frameworks like Vue.js and React for creating interactive user interfaces.</p><h3>Backend Development</h3><p>Learn about server-side development with PHP, database design, API development, and security best practices.</p>',
                'status' => 'draft',
                'user_id' => $editor->id,
                'category_id' => $techCategory->id,
                'published_at' => null,
                'views_count' => 0,
            ],
        ];

        foreach ($sampleArticles as $articleData) {
            $article = Article::firstOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );

            // Attach tags to articles
            if ($article->wasRecentlyCreated) {
                $article->tags()->attach([$laravelTag->id, $phpTag->id]);
            }
        }

        $this->command->info('Sample data created successfully!');
        $this->command->info('Admin login: admin@berita-app.com / password');
        $this->command->info('Editor login: editor@berita-app.com / password');
        $this->command->info('Member login: member@berita-app.com / password');
    }
}
