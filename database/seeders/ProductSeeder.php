<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = Category::all();
        
        $products = [
            // Makanan & Minuman
            [
                'name' => 'Kopi Arabica Gayo',
                'description' => 'Kopi arabica premium dari dataran tinggi Gayo, Aceh. Memiliki cita rasa yang khas dan aroma yang harum.',
                'price' => 75000,
                'stock' => 50,
                'category_name' => 'Makanan & Minuman',
                'is_active' => true
            ],
            [
                'name' => 'Keripik Pisang Lampung',
                'description' => 'Keripik pisang renyah khas Lampung dengan berbagai varian rasa. Cocok untuk camilan sehari-hari.',
                'price' => 25000,
                'stock' => 100,
                'category_name' => 'Makanan & Minuman',
                'is_active' => true
            ],
            [
                'name' => 'Madu Hutan Asli',
                'description' => 'Madu murni dari hutan Indonesia yang dipanen langsung dari peternak lokal. Kaya akan nutrisi alami.',
                'price' => 150000,
                'stock' => 30,
                'category_name' => 'Makanan & Minuman',
                'is_active' => true
            ],
            [
                'name' => 'Teh Hijau Organik',
                'description' => 'Teh hijau organik berkualitas tinggi tanpa pestisida. Baik untuk kesehatan dan diet.',
                'price' => 45000,
                'stock' => 75,
                'category_name' => 'Makanan & Minuman',
                'is_active' => true
            ],

            // Fashion & Pakaian
            [
                'name' => 'Batik Tulis Solo',
                'description' => 'Kemeja batik tulis asli Solo dengan motif tradisional. Cocok untuk acara formal maupun kasual.',
                'price' => 350000,
                'stock' => 15,
                'category_name' => 'Fashion & Pakaian',
                'is_active' => true
            ],
            [
                'name' => 'Kaos Katun Lokal',
                'description' => 'Kaos berbahan katun combed 30s yang nyaman dan berkualitas. Tersedia berbagai warna dan ukuran.',
                'price' => 85000,
                'stock' => 200,
                'category_name' => 'Fashion & Pakaian',
                'is_active' => true
            ],
            [
                'name' => 'Tas Kulit Asli',
                'description' => 'Tas kulit sapi asli buatan pengrajin lokal. Desain elegan dan tahan lama.',
                'price' => 450000,
                'stock' => 25,
                'category_name' => 'Fashion & Pakaian',
                'is_active' => true
            ],

            // Kerajinan Tangan
            [
                'name' => 'Wayang Kulit Jawa',
                'description' => 'Wayang kulit tradisional Jawa buatan pengrajin ahli. Cocok untuk koleksi atau hadiah.',
                'price' => 750000,
                'stock' => 8,
                'category_name' => 'Kerajinan Tangan',
                'is_active' => true
            ],
            [
                'name' => 'Anyaman Bambu Dekoratif',
                'description' => 'Kerajinan anyaman bambu untuk dekorasi rumah. Ramah lingkungan dan artistik.',
                'price' => 125000,
                'stock' => 40,
                'category_name' => 'Kerajinan Tangan',
                'is_active' => true
            ],
            [
                'name' => 'Patung Kayu Jepara',
                'description' => 'Patung kayu ukiran khas Jepara dengan detail yang halus. Karya seni yang bernilai tinggi.',
                'price' => 950000,
                'stock' => 5,
                'category_name' => 'Kerajinan Tangan',
                'is_active' => true
            ],

            // Kecantikan & Kesehatan
            [
                'name' => 'Sabun Herbal Alami',
                'description' => 'Sabun berbahan dasar herbal alami tanpa bahan kimia berbahaya. Aman untuk semua jenis kulit.',
                'price' => 35000,
                'stock' => 150,
                'category_name' => 'Kecantikan & Kesehatan',
                'is_active' => true
            ],
            [
                'name' => 'Minyak Kelapa Virgin',
                'description' => 'Minyak kelapa murni untuk perawatan rambut dan kulit. Diproduksi dengan metode tradisional.',
                'price' => 65000,
                'stock' => 80,
                'category_name' => 'Kecantikan & Kesehatan',
                'is_active' => true
            ],
            [
                'name' => 'Lulur Tradisional',
                'description' => 'Lulur tradisional dengan campuran rempah-rempah alami untuk perawatan kulit.',
                'price' => 55000,
                'stock' => 60,
                'category_name' => 'Kecantikan & Kesehatan',
                'is_active' => true
            ],

            // Elektronik
            [
                'name' => 'Power Bank Lokal 10000mAh',
                'description' => 'Power bank buatan lokal dengan kapasitas 10000mAh. Dilengkapi dengan fast charging.',
                'price' => 125000,
                'stock' => 45,
                'category_name' => 'Elektronik',
                'is_active' => true
            ],
            [
                'name' => 'Headphone Bluetooth',
                'description' => 'Headphone bluetooth dengan kualitas suara jernih dan battery life yang tahan lama.',
                'price' => 275000,
                'stock' => 30,
                'category_name' => 'Elektronik',
                'is_active' => true
            ],

            // Rumah Tangga
            [
                'name' => 'Set Peralatan Dapur Kayu',
                'description' => 'Set peralatan dapur dari kayu jati berkualitas. Ramah lingkungan dan tahan lama.',
                'price' => 185000,
                'stock' => 35,
                'category_name' => 'Rumah Tangga',
                'is_active' => true
            ],
            [
                'name' => 'Tempat Sampah Organizer',
                'description' => 'Tempat sampah dengan sistem organizer untuk memudahkan pemilahan sampah.',
                'price' => 95000,
                'stock' => 50,
                'category_name' => 'Rumah Tangga',
                'is_active' => true
            ],

            // Sample produk yang stoknya habis
            [
                'name' => 'Limited Edition Batik',
                'description' => 'Batik edisi terbatas dengan motif eksklusif.',
                'price' => 1200000,
                'stock' => 0,
                'category_name' => 'Fashion & Pakaian',
                'is_active' => true
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->where('name', $productData['category_name'])->first();
            
            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'category_id' => $category->id,
                    'is_active' => $productData['is_active'],
                    // 'image' => null, // Will be set later if needed
                ]);
            }
        }
    }
}