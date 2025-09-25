<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample users for comments
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Sari Melati',
                'email' => 'sari.melati@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Riko Wijaya',
                'email' => 'riko.wijaya@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Nina Rahayu',
                'email' => 'nina.rahayu@example.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $createdUsers = User::whereIn('email', array_column($users, 'email'))->get();
        $articles = Article::all();

        // Sample comments for each article
        $commentTemplates = [
            // Technology article comments
            [
                'article_title_contains' => 'AI',
                'comments' => [
                    'Artikel yang sangat menarik! AI memang sudah mengubah banyak hal dalam kehidupan kita sehari-hari. Terima kasih sudah berbagi informasi yang berharga ini.',
                    'Setuju banget nih, tapi kadang khawatir juga sama dampak AI terhadap lapangan kerja. Gimana ya cara kita adaptasi?',
                    'ChatGPT dan tools AI lainnya emang game changer sih. Udah mulai pakai di kerjaan juga dan hasilnya impressive!',
                    'Penjelasannya mudah dipahami. Jadi makin penasaran sama perkembangan AI ke depannya.',
                    'Thanks infonya! Jadi tahu lebih banyak tentang implementasi AI di berbagai sektor.',
                ]
            ],
            // Business article comments
            [
                'article_title_contains' => 'Startup',
                'comments' => [
                    'Wah keren banget startup Indonesia bisa dapet funding segede ini! Semoga makin banyak unicorn dari Indonesia.',
                    'Ekspansi ke Asia Tenggara emang strategi yang tepat. Market di sana juga potensial banget.',
                    'Inspiring! Semoga bisa jadi motivasi buat startup lokal lainnya.',
                    'Series A $15 juta itu lumayan besar ya. Pasti business model-nya udah proven.',
                    'Good job! Indonesia makin diakui di kancah startup Asia.',
                ]
            ],
            // Lifestyle article comments
            [
                'article_title_contains' => 'Remote',
                'comments' => [
                    'Tips yang sangat berguna! Sebagai remote worker, saya setuju banget dengan poin-poin ini.',
                    'Pomodoro technique emang efektif banget buat jaga fokus. Udah coba dan working well!',
                    'Workspace setup itu penting banget ya ternyata. Harus invest di kursi yang bagus nih.',
                    'Work-life balance emang challenging kalau WFH. Thanks tipsnya!',
                    'Artikel yang tepat waktu! Lagi butuh banget tips productivity buat kerja dari rumah.',
                ]
            ],
            // Sports article comments
            [
                'article_title_contains' => 'Liga Champions',
                'comments' => [
                    'Semifinal tahun ini seru banget! Prediksinya Real Madrid vs City bakal sengit nih.',
                    'Mbappé lagi on fire ya sekarang. Bisa jadi kunci kemenangan Madrid.',
                    'City punya depth squad yang bagus sih, tapi pengalaman Madrid di UCL ga bisa diremehkan.',
                    'Bayern vs PSG juga menarik! Dua tim dengan serangan yang deadly.',
                    'Haaland vs Mbappé, siapa yang bakal lebih produktif ya di semifinal?',
                ]
            ],
            // Politics article comments
            [
                'article_title_contains' => 'Digital Indonesia',
                'comments' => [
                    'Roadmap yang ambisius! Semoga implementasinya bisa berjalan sesuai rencana.',
                    'Target 17% kontribusi sektor digital ke PDB itu realistis ga ya? Tapi optimis sih!',
                    'UMKM harus diperhatikan banget nih dalam transformasi digital ini.',
                    'Infrastructure 4G dan 5G memang kunci utama. Semoga merata di seluruh Indonesia.',
                    'Bagus ada focus ke literasi digital juga, bukan cuma teknologinya aja.',
                ]
            ]
        ];

        foreach ($articles as $article) {
            // Find matching comment template
            $commentData = null;
            foreach ($commentTemplates as $template) {
                if (stripos($article->title, $template['article_title_contains']) !== false) {
                    $commentData = $template['comments'];
                    break;
                }
            }

            if ($commentData) {
                // Add 3-5 comments per article
                $numComments = rand(3, 5);
                $selectedComments = array_rand($commentData, $numComments);

                if (!is_array($selectedComments)) {
                    $selectedComments = [$selectedComments];
                }

                foreach ($selectedComments as $index) {
                    $randomUser = $createdUsers->random();

                    Comment::create([
                        'content' => $commentData[$index],
                        'user_id' => $randomUser->id,
                        'article_id' => $article->id,
                        'created_at' => now()->subHours(rand(1, 48)),
                        'updated_at' => now()->subHours(rand(1, 48)),
                    ]);
                }
            }
        }
    }
}
