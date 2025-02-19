<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_services')->insert([
            [
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'price' => 199.99,
                'image' => 'https://example.com/images/product1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description for product 2',
                'price' => 299.99,
                'image' => 'https://example.com/images/product2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 3',
                'description' => 'Description for product 3',
                'price' => 99.99,
                'image' => 'https://example.com/images/product3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
