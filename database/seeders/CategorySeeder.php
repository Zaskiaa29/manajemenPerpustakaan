<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
        'nama_kategori' => 'Fiksi',
        'deskripsi' => 'Buku-buku karangan atau imajinasi'
    ]);

    Category::create([
        'nama_kategori' => 'Teknologi',
        'deskripsi' => 'Buku tentang pemrograman dan perangkat keras'
    ]);
    }
}

