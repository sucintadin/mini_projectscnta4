<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tanaman Hias Daun (Foliage & Indoor)',
                'slug' => 'tanaman-hias-daun',
                'icon' => 'fa-leaf',
                'description' => 'Tanaman hias dengan corak dan bentuk daun estetis yang cocok untuk interior rumah, apartemen, atau ruang kerja.',
            ],
            [
                'name' => 'Bunga & Anggrek (Flowering Plants)',
                'slug' => 'bunga-dan-anggrek',
                'icon' => 'fa-spa',
                'description' => 'Koleksi tanaman berbunga mempesona, anggrek hias, dan flora tropis penghias pekarangan.',
            ],
            [
                'name' => 'Sukulen & Kaktus (Succulents & Cacti)',
                'slug' => 'sukulen-dan-kaktus',
                'icon' => 'fa-sun',
                'description' => 'Tanaman berduri dan berdaun tebal penyimpan air yang tangguh, hemat air, dan minim perawatan.',
            ],
            [
                'name' => 'Tanaman Herbal & Aromatik',
                'slug' => 'herbal-dan-aromatik',
                'icon' => 'fa-heart-pulse',
                'description' => 'Tanaman berkhasiat herbal, rempah dapur alami, dan tanaman pengusir serangga.',
            ],
            [
                'name' => 'Bonsai & Tanaman Kayu Eksotis',
                'slug' => 'bonsai-dan-tanaman-kayu',
                'icon' => 'fa-tree',
                'description' => 'Miniatur pohon artistik dan tanaman berkayu dengan nilai seni serta filosofi estetika tinggi.',
            ],
            [
                'name' => 'Media Tanam & Nutrisi Pupuk',
                'slug' => 'media-tanam-dan-nutrisi',
                'icon' => 'fa-seedling',
                'description' => 'Tanah subur, sekam fermentasi, perlite, kompos organik, dan nutrisi pupuk pertumbuhan tanaman.',
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
