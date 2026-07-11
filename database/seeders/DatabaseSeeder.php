<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & User Biasa
        User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Mahasiswa Biasa',
            'email' => 'user@amikom.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // 2. Buat Kategori
        $musik = Category::create(['name' => 'Konser Musik', 'slug' => 'konser-musik']);
        $tech = Category::create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        $edu = Category::create(['name' => 'Edukasi', 'slug' => 'edukasi']);
        $sport = Category::create(['name' => 'Olahraga', 'slug' => 'olahraga']);

        // 3. Buat Partner
        Partner::create([
            'name' => 'Universitas Amikom Yogyakarta',
            'logo_url' => 'https://placehold.co/200x80/6366f1/ffffff?text=AMIKOM',
            'website_url' => 'https://amikom.ac.id',
        ]);
        Partner::create([
            'name' => 'Dicoding Indonesia',
            'logo_url' => 'https://placehold.co/200x80/10b981/ffffff?text=DICODING',
            'website_url' => 'https://dicoding.com',
        ]);
        Partner::create([
            'name' => 'Tokopedia',
            'logo_url' => 'https://placehold.co/200x80/059669/ffffff?text=TOKOPEDIA',
            'website_url' => 'https://tokopedia.com',
        ]);

        // 4. Buat Event (Pastikan tanggal di masa depan agar muncul di homepage)
        Event::create([
            'category_id' => $musik->id,
            'title' => 'Konser Amikom Music Fest 2026',
            'slug' => 'amikom-music-fest-2026',
            'description' => 'Nikmati penampilan band-band indie terbaik dari seluruh Indonesia di kampus Amikom Yogyakarta. Sebuah malam yang penuh dengan musik, cahaya, dan kebersamaan.',
            'location' => 'Lapangan Parkir Amikom Yogyakarta',
            'date' => now()->addDays(14)->setHour(19)->setMinute(0), // 2 minggu lagi, jam 19:00
            'price' => 75000,
            'stock' => 500,
        ]);

        Event::create([
            'category_id' => $tech->id,
            'title' => 'Workshop Laravel & AI Integration',
            'slug' => 'workshop-laravel-ai',
            'description' => 'Pelajari cara mengintegrasikan Artificial Intelligence ke dalam aplikasi Laravel modern. Cocok untuk developer tingkat menengah.',
            'location' => 'Gedung B Lantai 3, Amikom',
            'date' => now()->addDays(7)->setHour(13)->setMinute(0), // 1 minggu lagi, jam 13:00
            'price' => 150000,
            'stock' => 50,
        ]);

        Event::create([
            'category_id' => $edu->id,
            'title' => 'Seminar Nasional Kewirausahaan Digital',
            'slug' => 'seminar-kewirausahaan',
            'description' => 'Membangun startup digital di era society 5.0 bersama para founder sukses tanah air.',
            'location' => 'Auditorium Utama Amikom',
            'date' => now()->addDays(30)->setHour(8)->setMinute(0), // 1 bulan lagi
            'price' => 0, // Gratis
            'stock' => 200,
        ]);

        Event::create([
            'category_id' => $sport->id,
            'title' => 'Turnamen E-Sport Mobile Legends',
            'slug' => 'turnamen-ml-amikom',
            'description' => 'Tunjukkan skill timmu dan raih hadiah total puluhan juta rupiah!',
            'location' => 'Student Center Amikom',
            'date' => now()->addDays(21)->setHour(10)->setMinute(0),
            'price' => 50000,
            'stock' => 100,
        ]);
    }
}