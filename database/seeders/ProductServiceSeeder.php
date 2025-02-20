<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Str;

class ProductServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_services')->insert([
            [
               'id' => (string) \Illuminate\Support\Str::uuid(),
                'name' => 'Product 1',
                'description' => 'Description for product 1',
                'price' => 199.99,
                'image' => 'https://example.com/images/product1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
            // Tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
