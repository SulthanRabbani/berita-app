<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories if they don't exist
        $categories = [
            'Teknologi' => 'Berita terbaru seputar teknologi dan inovasi',
            'Bisnis' => 'Update dunia bisnis dan ekonomi',
            'Gaya Hidup' => 'Tips dan tren gaya hidup modern',
            'Olahraga' => 'Berita olahraga terkini',
            'Politik' => 'Berita politik dan pemerintahan',
        ];

        foreach ($categories as $name => $description) {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'description' => $description,
                ]
            );
        }

        // Get admin user
        $adminUser = User::where('email', 'admin@example.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        // Sample articles
        $articles = [
            [
                'title' => 'Revolusi AI dalam Dunia Teknologi: Bagaimana Kecerdasan Buatan Mengubah Cara Kita Bekerja',
                'excerpt' => 'Kecerdasan buatan (AI) telah menjadi salah satu teknologi paling revolusioner di era modern. Dari asisten virtual hingga algoritma pembelajaran mesin yang canggih, AI mengubah cara kita bekerja dan berinteraksi dengan teknologi.',
                'content' => '<p>Kecerdasan buatan (AI) telah menjadi salah satu teknologi paling revolusioner di era modern. Dari asisten virtual hingga algoritma pembelajaran mesin yang canggih, AI mengubah cara kita bekerja dan berinteraksi dengan teknologi.</p>

<p>Dalam beberapa tahun terakhir, kita telah menyaksikan perkembangan pesat dalam teknologi AI. ChatGPT, DALL-E, dan berbagai tools AI lainnya telah membuktikan bahwa masa depan sudah tiba. Namun, bagaimana sebenarnya dampak AI terhadap dunia kerja kita?</p>

<h2>Transformasi Digital di Berbagai Sektor</h2>
<p>AI tidak hanya mengubah sektor teknologi, tetapi juga healthcare, finance, education, dan bahkan creative industries. Dokter kini dapat mendiagnosis penyakit lebih akurat dengan bantuan AI, sementara guru dapat memberikan pembelajaran yang lebih personal kepada siswa.</p>

<p>Di dunia bisnis, AI membantu perusahaan menganalisis data dengan lebih efisien, memprediksi tren pasar, dan mengoptimalkan operasional. Ini bukan lagi tentang science fiction, tetapi realitas yang kita hadapi setiap hari.</p>',
                'category' => 'Teknologi',
                'views_count' => 5420,
                'featured_image' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=450&fit=crop&crop=center',
            ],
            [
                'title' => 'Startup Indonesia Raih Pendanaan Series A: Strategi Ekspansi ke Asia Tenggara',
                'excerpt' => 'Dunia startup Indonesia kembali mencatatkan prestasi membanggakan. Salah satu startup teknologi finansial terkemuka berhasil meraih pendanaan Series A senilai $15 juta untuk ekspansi ke Asia Tenggara.',
                'content' => '<p>Dunia startup Indonesia kembali mencatatkan prestasi membanggakan. Salah satu startup teknologi finansial terkemuka berhasil meraih pendanaan Series A senilai $15 juta untuk ekspansi ke Asia Tenggara.</p>

<p>Pendanaan ini dipimpin oleh venture capital terkemuka di Asia dengan partisipasi dari beberapa angel investor berpengalaman. Dana yang diperoleh akan digunakan untuk pengembangan produk, ekspansi tim, dan penetrasi pasar regional.</p>

<h2>Strategi Ekspansi yang Terukur</h2>
<p>CEO startup ini menjelaskan bahwa ekspansi ke Asia Tenggara merupakan langkah strategis mengingat potensi pasar yang besar dan kesamaan karakteristik konsumen dengan Indonesia. Thailand dan Vietnam menjadi target pasar pertama dalam fase ekspansi ini.</p>

<p>Dengan pendanaan Series A ini, startup berharap dapat menggandakan jumlah pengguna aktif dan mencapai break-even point dalam 18 bulan ke depan.</p>',
                'category' => 'Bisnis',
                'views_count' => 3200,
                'featured_image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=800&h=450&fit=crop&crop=center',
            ],
            [
                'title' => 'Tips Produktivitas untuk Remote Worker: Panduan Lengkap Bekerja dari Rumah',
                'excerpt' => 'Bekerja dari rumah telah menjadi norma baru dalam dunia kerja modern. Namun, menjaga produktivitas sambil bekerja remote membutuhkan strategi khusus dan disiplin yang tinggi.',
                'content' => '<p>Bekerja dari rumah telah menjadi norma baru dalam dunia kerja modern. Namun, menjaga produktivitas sambil bekerja remote membutuhkan strategi khusus dan disiplin yang tinggi.</p>

<p>Berdasarkan survei terbaru, 78% pekerja remote melaporkan peningkatan work-life balance, namun 45% mengalami kesulitan dalam menjaga fokus dan produktivitas. Berikut adalah tips yang dapat membantu Anda bekerja lebih efektif dari rumah.</p>

<h2>1. Ciptakan Workspace yang Nyaman</h2>
<p>Investasi dalam setup workspace yang ergonomis sangat penting. Pastikan Anda memiliki kursi yang nyaman, pencahayaan yang cukup, dan area kerja yang terpisah dari area pribadi.</p>

<h2>2. Tetapkan Rutinitas Harian</h2>
<p>Mulai hari dengan rutinitas yang konsisten. Mandi, berpakaian seperti akan ke kantor, dan tetapkan jam kerja yang jelas. Ini membantu otak Anda masuk ke "mode kerja".</p>

<h2>3. Gunakan Teknik Time Management</h2>
<p>Teknik Pomodoro (25 menit fokus, 5 menit istirahat) terbukti efektif untuk menjaga konsentrasi. Gunakan aplikasi seperti Toggl atau Forest untuk tracking waktu.</p>',
                'category' => 'Gaya Hidup',
                'views_count' => 8700,
                'featured_image' => 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?w=800&h=450&fit=crop&crop=center',
            ],
            [
                'title' => 'Liga Champions 2024: Prediksi dan Analisis Pertandingan Semifinal',
                'excerpt' => 'Memasuki fase semifinal Liga Champions 2024, empat tim terbaik Eropa siap bertarung untuk merebut tiket final. Analisis mendalam tentang kekuatan dan strategi setiap tim.',
                'content' => '<p>Memasuki fase semifinal Liga Champions 2024, empat tim terbaik Eropa siap bertarung untuk merebut tiket final. Real Madrid, Manchester City, Bayern Munich, dan PSG telah menunjukkan performa luar biasa sepanjang turnamen.</p>

<p>Dengan format leg ganda, setiap pertandingan menjadi crucial dan tidak ada ruang untuk kesalahan. Mari kita analisis peluang setiap tim untuk melaju ke final.</p>

<h2>Real Madrid vs Manchester City</h2>
<p>Pertandingan ulang final tahun lalu ini menjanjikan spektakel sepak bola terbaik. Real Madrid dengan pengalaman Liga Champions yang tak tertandingi akan berhadapan dengan mesin gol Manchester City yang efisien.</p>

<p>Kylian Mbappé yang tampil gemilang di pertandingan sebelumnya menjadi kunci serangan Los Blancos, sementara Erling Haaland diharapkan dapat memecah rekor golnya di kompetisi ini.</p>

<h2>Bayern Munich vs PSG</h2>
<p>Di semifinal lainnya, Bayern Munich yang sedang dalam performa terbaiknya akan menghadapi PSG yang haus gelar. Kedua tim memiliki lini serang yang mematikan dan pertahanan yang solid.</p>',
                'category' => 'Olahraga',
                'views_count' => 6500,
                'featured_image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=450&fit=crop&crop=center',
            ],
            [
                'title' => 'Kebijakan Digital Indonesia 2024: Roadmap Transformasi Ekonomi Digital',
                'excerpt' => 'Pemerintah Indonesia meluncurkan roadmap transformasi ekonomi digital 2024-2030 dengan target kontribusi sektor digital mencapai 17% dari PDB nasional.',
                'content' => '<p>Pemerintah Indonesia meluncurkan roadmap transformasi ekonomi digital 2024-2030 dengan target kontribusi sektor digital mencapai 17% dari PDB nasional. Inisiatif ini meliputi pengembangan infrastruktur digital, literasi digital, dan ekosistem startup.</p>

<p>Menteri Komunikasi dan Informatika menekankan bahwa transformasi digital bukan hanya tentang teknologi, tetapi juga tentang mengubah mindset dan cara kerja di semua sektor ekonomi.</p>

<h2>Pilar Utama Transformasi Digital</h2>
<p>Roadmap ini dibangun atas empat pilar utama: infrastruktur digital yang merata, sumber daya manusia yang kompeten, regulasi yang adaptif, dan ekosistem inovasi yang berkelanjutan.</p>

<p>Target pembangunan 4G di seluruh Indonesia diharapkan rampung pada akhir 2024, sementara rollout 5G akan dimulai di kota-kota besar pada tahun 2025.</p>

<h2>Dukungan untuk UMKM</h2>
<p>Program khusus untuk UMKM mencakup pelatihan digital marketing, akses platform e-commerce, dan kemudahan akses financing untuk digitalisasi usaha.</p>',
                'category' => 'Politik',
                'views_count' => 4100,
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&h=450&fit=crop&crop=center',
            ],
        ];

        foreach ($articles as $articleData) {
            $category = Category::where('name', $articleData['category'])->first();

            Article::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'status' => 'published',
                'user_id' => $adminUser->id,
                'category_id' => $category->id,
                'published_at' => now()->subHours(rand(1, 72)),
                'views_count' => $articleData['views_count'],
                'featured_image' => $articleData['featured_image'],
            ]);
        }
    }
}
