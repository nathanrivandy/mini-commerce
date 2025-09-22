<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman tradisional Indonesia'
            ],
            [
                'name' => 'Fashion & Pakaian',
                'description' => 'Pakaian, aksesoris, dan produk fashion lokal'
            ],
            [
                'name' => 'Kerajinan Tangan',
                'description' => 'Produk kerajinan tangan dan seni tradisional'
            ],
            [
                'name' => 'Kecantikan & Kesehatan',
                'description' => 'Produk kecantikan dan kesehatan alami'
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Gadget dan perangkat elektronik'
            ],
            [
                'name' => 'Rumah Tangga',
                'description' => 'Peralatan dan perlengkapan rumah tangga'
            ],
            [
                'name' => 'Olahraga & Outdoor',
                'description' => 'Peralatan olahraga dan aktivitas outdoor'
            ],
            [
                'name' => 'Buku & Alat Tulis',
                'description' => 'Buku, alat tulis, dan perlengkapan kantor'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}