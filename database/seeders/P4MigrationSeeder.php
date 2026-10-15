<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class P4MigrationSeeder extends Seeder
{
    /**
     * Run the database seeds to import P4 data.
     */
    public function run(): void
    {
        $floweringCategory = Category::where('slug', 'bunga-dan-anggrek')->first() ?? Category::first();
        $herbalCategory = Category::where('slug', 'herbal-dan-aromatik')->first() ?? Category::first();

        // 1. Import Flower Products from P4
        $p4Products = [
            [
                'category_id' => $floweringCategory->id,
                'name' => 'Bunga Mawar Merah Valentine (Red Rose)',
                'scientific_name' => 'Rosa rubiginosa',
                'sku' => 'P4-FLW-001',
                'price' => 185000,
                'stock' => 20,
                'min_stock' => 5,
                'light_requirement' => 'Matahari Penuh Terik',
                'watering_schedule' => 'Setiap Pagi',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga mawar merah beludru segar romantis untuk buket dan hadiah istimewa (Migrasi dari P4 Petal & Co).',
                'is_featured' => true,
            ],
            [
                'category_id' => $floweringCategory->id,
                'name' => 'Bunga Tulip Belanda Pastel (Dutch Tulip)',
                'scientific_name' => 'Tulipa gesneriana',
                'sku' => 'P4-FLW-002',
                'price' => 250000,
                'stock' => 14,
                'min_stock' => 4,
                'light_requirement' => 'Terang Sejuk',
                'watering_schedule' => '2-3 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1520763185298-1b434c919102?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga tulip impor warna pastel dengan kuncup anggun khas negeri Belanda (Migrasi dari P4 Petal & Co).',
                'is_featured' => true,
            ],
            [
                'category_id' => $floweringCategory->id,
                'name' => 'Buket Bunga Peony Romantis (Pink Peony)',
                'scientific_name' => 'Paeonia lactiflora',
                'sku' => 'P4-FLW-003',
                'price' => 320000,
                'stock' => 8,
                'min_stock' => 3,
                'light_requirement' => 'Teduh Sejuk',
                'watering_schedule' => '2 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=600&q=80',
                'description' => 'Buket peony mewah berlapis helai kelopak merah muda lembut dengan harum semerbak (Migrasi dari P4 Petal & Co).',
                'is_featured' => true,
            ],
            [
                'category_id' => $floweringCategory->id,
                'name' => 'Bunga Matahari Golden Bloom (Sunflower)',
                'scientific_name' => 'Helianthus annuus',
                'sku' => 'P4-FLW-004',
                'price' => 145000,
                'stock' => 16,
                'min_stock' => 5,
                'light_requirement' => 'Matahari Penuh Terik 8 Jam',
                'watering_schedule' => 'Setiap Hari',
                'image_url' => 'https://images.unsplash.com/photo-1597848212624-a19eb35e2651?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga matahari kuning cerah penuh semangat yang cocok untuk perayaan wisuda (Migrasi dari P4 Petal & Co).',
                'is_featured' => false,
            ],
            [
                'category_id' => $floweringCategory->id,
                'name' => 'Anggrek Ungu Formosa Eksotis',
                'scientific_name' => 'Dendrobium sp.',
                'sku' => 'P4-FLW-005',
                'price' => 275000,
                'stock' => 10,
                'min_stock' => 3,
                'light_requirement' => 'Cahaya Pagi Lembut',
                'watering_schedule' => '3 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1566993359670-349f7e8a9391?auto=format&fit=crop&w=600&q=80',
                'description' => 'Anggrek ungu elegan dengan bunga tahan mekar berbulan-bulan (Migrasi dari P4 Petal & Co).',
                'is_featured' => false,
            ],
            [
                'category_id' => $herbalCategory->id,
                'name' => 'Bunga Lavender French Provence',
                'scientific_name' => 'Lavandula angustifolia',
                'sku' => 'P4-FLW-006',
                'price' => 250000,
                'stock' => 25,
                'min_stock' => 8,
                'light_requirement' => 'Matahari Penuh',
                'watering_schedule' => '3-4 Hari Sekali',
                'image_url' => 'https://images.unsplash.com/photo-1528183429752-a97d0bf99b5a?auto=format&fit=crop&w=600&q=80',
                'description' => 'Bunga lavender beraroma wangi rileksasi alami pengusir nyamuk (Migrasi dari P4 Petal & Co).',
                'is_featured' => true,
            ],
        ];

        foreach ($p4Products as $item) {
            Product::updateOrCreate(['sku' => $item['sku']], $item);
        }

        // 2. Import All Sales Records from P4 Florist DB
        $p4Sales = [
            [
                'customer_name' => 'Alya Putri Lestari',
                'flower_name' => 'Mawar Merah',
                'quantity' => 2,
                'unit_price' => 185000,
                'sale_date' => '2026-10-15',
                'payment_method' => 'QRIS',
                'notes' => 'Kartu ucapan ulang tahun',
            ],
            [
                'customer_name' => 'Bima Pratama',
                'flower_name' => 'Tulip',
                'quantity' => 1,
                'unit_price' => 250000,
                'sale_date' => '2026-10-14',
                'payment_method' => 'Transfer',
                'notes' => 'Warna pastel',
            ],
            [
                'customer_name' => 'Citra Maharani',
                'flower_name' => 'Buket Peony',
                'quantity' => 3,
                'unit_price' => 320000,
                'sale_date' => '2026-10-13',
                'payment_method' => 'Tunai',
                'notes' => 'Untuk perayaan anniversary',
            ],
            [
                'customer_name' => 'Dinda Safitri',
                'flower_name' => 'Matahari',
                'quantity' => 2,
                'unit_price' => 145000,
                'sale_date' => '2026-10-12',
                'payment_method' => 'Kartu',
                'notes' => 'Untuk buket wisuda kelulusan',
            ],
            [
                'customer_name' => 'Farhan Akbar',
                'flower_name' => 'Anggrek',
                'quantity' => 1,
                'unit_price' => 275000,
                'sale_date' => '2026-10-11',
                'payment_method' => 'Transfer',
                'notes' => 'Pot keramik putih',
            ],
            [
                'customer_name' => 'Bunga Lavender Lover',
                'flower_name' => 'Lavender',
                'quantity' => 10,
                'unit_price' => 250000,
                'sale_date' => '2026-10-14',
                'payment_method' => 'Tunai',
                'notes' => 'Happy Valentine gift',
            ],
        ];

        foreach ($p4Sales as $sale) {
            Sale::updateOrCreate(
                [
                    'customer_name' => $sale['customer_name'],
                    'flower_name' => $sale['flower_name'],
                    'sale_date' => $sale['sale_date'],
                ],
                $sale
            );
        }
    }
}
