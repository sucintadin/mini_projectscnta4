<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryMap = Category::pluck('id', 'slug');

        $products = [
            [
                'category_slug' => 'tanaman-hias-daun',
                'name' => 'Monstera Deliciosa King',
                'scientific_name' => 'Monstera deliciosa',
                'sku' => 'GB-FOL-001',
                'price' => 125000,
                'stock' => 18,
                'min_stock' => 5,
                'light_requirement' => 'Terang Tidak Langsung',
                'watering_schedule' => '2-3 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?auto=format&fit=crop&w=600&q=80',
                'description' => 'Tanaman hias tropis ikonik dengan daun berlubang khas yang memukau. Sangat populer untuk estetika ruang tamu minimalis modern.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'tanaman-hias-daun',
                'name' => 'Aglaonema Suksom Jaipong',
                'scientific_name' => 'Aglaonema sp.',
                'sku' => 'GB-FOL-002',
                'price' => 85000,
                'stock' => 3, // Low stock
                'min_stock' => 5,
                'light_requirement' => 'Teduh Hangat',
                'watering_schedule' => '3-4 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?auto=format&fit=crop&w=600&q=80',
                'description' => 'Ratu tanaman hias dengan daun berwarna merah menyala menyala eksotis tanpa banyak semburat hijau. Membawa energi cerah dalam ruangan.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'tanaman-hias-daun',
                'name' => 'Sansevieria Lidah Mertua Laurentii',
                'scientific_name' => 'Sansevieria trifasciata',
                'sku' => 'GB-FOL-003',
                'price' => 45000,
                'stock' => 25,
                'min_stock' => 5,
                'light_requirement' => 'Toleran Segala Cahaya',
                'watering_schedule' => '1-2 Minggu Sekali',
                'image_url' => 'images/plants/lidah_mertua.jpg',
                'description' => 'Tanaman pembersih udara alami paling tangguh. Mampu menyerap racun udara dan menghasilkan oksigen melimpah di malam hari.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'tanaman-hias-daun',
                'name' => 'Philodendron Pink Princess Variegata',
                'scientific_name' => 'Philodendron erubescens',
                'sku' => 'GB-FOL-004',
                'price' => 275000,
                'stock' => 0, // Out of stock
                'min_stock' => 3,
                'light_requirement' => 'Terang Tersaring',
                'watering_schedule' => '3 Hari Sekali',
                'image_url' => 'images/plants/philodendron_pink.jpg',
                'description' => 'Koleksi langka dengan variegasi warna merah muda lembut berpadu hijau gelap pekat. Menjadi incaran para kolektor tanaman eksklusif.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'tanaman-hias-daun',
                'name' => 'Calathea Orbifolia Jumbo',
                'scientific_name' => 'Goeppertia orbifolia',
                'sku' => 'GB-FOL-005',
                'price' => 95000,
                'stock' => 12,
                'min_stock' => 4,
                'light_requirement' => 'Teduh Lembap',
                'watering_schedule' => '2 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1509423350716-97f9360b4e09?auto=format&fit=crop&w=600&q=80',
                'description' => 'Daun bundar berukuran besar dengan garis perak metalik artistik. Membutuhkan kelembapan udara yang stabil.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'bunga-dan-anggrek',
                'name' => 'Anggrek Bulan Putih Royal Formosa',
                'scientific_name' => 'Phalaenopsis amabilis',
                'sku' => 'GB-FLW-001',
                'price' => 165000,
                'stock' => 8,
                'min_stock' => 5,
                'light_requirement' => 'Cahaya Pagi Lembut',
                'watering_schedule' => '3-4 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1525310072745-f49212b5ac6d?auto=format&fit=crop&w=600&q=80',
                'description' => 'Puspa pesona Indonesia dengan kuntum bunga putih anggun berdiameter besar yang mekar tahan hingga 2-3 bulan.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'bunga-dan-anggrek',
                'name' => 'Peace Lily Variegata Domino',
                'scientific_name' => 'Spathiphyllum wallisii',
                'sku' => 'GB-FLW-002',
                'price' => 75000,
                'stock' => 2, // Low stock
                'min_stock' => 5,
                'light_requirement' => 'Teduh Parsial',
                'watering_schedule' => '2 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1598880940080-ff9a29891b85?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga lili perdamaian berwarna putih dengan bercak putih marbled pada daunnya. Indikator air yang baik karena merunduk saat haus.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'bunga-dan-anggrek',
                'name' => 'Kembang Sepatu Hibrida Kuning Lemon',
                'scientific_name' => 'Hibiscus rosa-sinensis',
                'sku' => 'GB-FLW-003',
                'price' => 55000,
                'stock' => 14,
                'min_stock' => 5,
                'light_requirement' => 'Matahari Penuh Terik',
                'watering_schedule' => 'Setiap Hari',
                'image_url' => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga cerah tropis penghias halaman luar dengan mahkota berlapis ganda yang rajin mekar sepanjang tahun.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'sukulen-dan-kaktus',
                'name' => 'Echeveria Elegans Rose Alabaster',
                'scientific_name' => 'Echeveria elegans',
                'sku' => 'GB-SUC-001',
                'price' => 35000,
                'stock' => 30,
                'min_stock' => 10,
                'light_requirement' => 'Matahari Pagi 4-6 Jam',
                'watering_schedule' => '7-10 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1446071103084-c257b5f70672?auto=format&fit=crop&w=600&q=80',
                'description' => 'Sukulen berbentuk bunga mawar porselen berwarna hijau kebiruan dengan lapisan lilin alami pelindung panas.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'sukulen-dan-kaktus',
                'name' => 'Kaktus Koboi San Pedro Pilar',
                'scientific_name' => 'Echinopsis pachanoi',
                'sku' => 'GB-SUC-002',
                'price' => 140000,
                'stock' => 6,
                'min_stock' => 4,
                'light_requirement' => 'Matahari Penuh Terik',
                'watering_schedule' => '2-3 Minggu Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1509223197845-458d87318791?auto=format&fit=crop&w=600&q=80',
                'description' => 'Kaktus tegak menjulang bergaya gurun rustic. Pilihan tepat untuk pojok teras atau fasad rumah bernuansa mediterania.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'sukulen-dan-kaktus',
                'name' => 'Haworthia Zebra Fasciata',
                'scientific_name' => 'Haworthiopsis fasciata',
                'sku' => 'GB-SUC-003',
                'price' => 40000,
                'stock' => 1, // Low stock
                'min_stock' => 5,
                'light_requirement' => 'Terang Tidak Langsung',
                'watering_schedule' => '10 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1509937528035-ad76254b0356?auto=format&fit=crop&w=600&q=80',
                'description' => 'Sukulen mungil dengan pola garis zebra putih timbul pada daun berdaging tebal. Sangat cocok diletakkan di meja kerja.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'herbal-dan-aromatik',
                'name' => 'Peppermint Segar Organik',
                'scientific_name' => 'Mentha piperita',
                'sku' => 'GB-HRB-001',
                'price' => 25000,
                'stock' => 22,
                'min_stock' => 8,
                'light_requirement' => 'Matahari Pagi Hangat',
                'watering_schedule' => 'Setiap Pagi',
                'image_url' => 'https://images.unsplash.com/photo-1628556270448-4d4e4148e1b1?auto=format&fit=crop&w=600&q=80',
                'description' => 'Aroma mint segar alami untuk infuse water, teh herbal hangat, atau garnish hidangan manis.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'herbal-dan-aromatik',
                'name' => 'Rosemary Mediterania Herbal',
                'scientific_name' => 'Salvia rosmarinus',
                'sku' => 'GB-HRB-002',
                'price' => 38000,
                'stock' => 0, // Out of stock
                'min_stock' => 5,
                'light_requirement' => 'Matahari Penuh 6+ Jam',
                'watering_schedule' => '2-3 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1515586000433-a5ac1a389f13?auto=format&fit=crop&w=600&q=80',
                'description' => 'Herba wangi kayu pinus khas kuliner barat. Mengeluarkan harum menenangkan dan bermanfaat untuk konsentrasi.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'bonsai-dan-tanaman-kayu',
                'name' => 'Bonsai Beringin Kimeng Matang',
                'scientific_name' => 'Ficus microcarpa',
                'sku' => 'GB-BON-001',
                'price' => 650000,
                'stock' => 4,
                'min_stock' => 2,
                'light_requirement' => 'Matahari Penuh',
                'watering_schedule' => '1-2 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1512428813834-c702c7702b78?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bonsai berkarakter batang kokoh dengan akar gantung artistik. Sudah berumur 4 tahun dalam pot keramik impor.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'bonsai-dan-tanaman-kayu',
                'name' => 'Bonsai Anting Putri Salju Putih',
                'scientific_name' => 'Wrightia religiosa',
                'sku' => 'GB-BON-002',
                'price' => 850000,
                'stock' => 2,
                'min_stock' => 2,
                'light_requirement' => 'Matahari Penuh',
                'watering_schedule' => 'Setiap Hari',
                'image_url' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=600&q=80',
                'description' => 'Koleksi master bonsai dengan bunga putih menggantung semerbak wangi di pagi hari. Lekukan batang bernilai seni tinggi.',
                'is_featured' => true,
            ],
            [
                'category_slug' => 'media-tanam-dan-nutrisi',
                'name' => 'Media Tanam Premium Porous Mix 5Kg',
                'scientific_name' => 'Organic Substrate Blend',
                'sku' => 'GB-MED-001',
                'price' => 28000,
                'stock' => 45,
                'min_stock' => 15,
                'light_requirement' => 'Simpan di Tempat Kering',
                'watering_schedule' => 'Sesuai Kebutuhan',
                'image_url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?auto=format&fit=crop&w=600&q=80',
                'description' => 'Racikan tanah kompos fermentasi, sekam bakar, perlite putih, dan cocopeat cuci bersih. Anti busuk akar dan sangat porous.',
                'is_featured' => false,
            ],
            [
                'category_slug' => 'media-tanam-dan-nutrisi',
                'name' => 'Pupuk Organik Cair Bloom & Foliage 500ml',
                'scientific_name' => 'Bio-Nutrient Liquid',
                'sku' => 'GB-MED-002',
                'price' => 48000,
                'stock' => 19,
                'min_stock' => 10,
                'light_requirement' => 'Hindari Terik Matahari',
                'watering_schedule' => 'Aplikasi 1x Seminggu',
                'image_url' => 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?auto=format&fit=crop&w=600&q=80',
                'description' => 'Konsentrat nutrisi organik kaya mikroba fotosintesis dan hormon pertumbuhan. Mempercepat munculnya tunas daun dan kuncup bunga baru.',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $item) {
            $catSlug = $item['category_slug'];
            unset($item['category_slug']);
            $item['category_id'] = $categoryMap[$catSlug] ?? 1;

            Product::updateOrCreate(['sku' => $item['sku']], $item);
        }
    }
}
