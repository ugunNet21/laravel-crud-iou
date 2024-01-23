<?php

namespace Database\Seeders;

use App\Models\Alamat\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Kecamatan::create(['name' => 'Kecamatan A']);
        Kecamatan::create(['name' => 'Kecamatan B']);
    }
}
