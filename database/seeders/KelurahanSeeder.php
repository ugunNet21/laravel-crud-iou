<?php

namespace Database\Seeders;

use App\Models\Alamat\Kecamatan;
use App\Models\Alamat\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kecamatan A
        $kecamatanA = Kecamatan::create(['name' => 'Kecamatan A']);

        Kelurahan::create(['name' => 'Kelurahan A1', 'kecamatan_id' => $kecamatanA->id]);
        Kelurahan::create(['name' => 'Kelurahan A2', 'kecamatan_id' => $kecamatanA->id]);
        Kelurahan::create(['name' => 'Kelurahan A3', 'kecamatan_id' => $kecamatanA->id]);

        // Kecamatan B
        $kecamatanB = Kecamatan::create(['name' => 'Kecamatan B']);

        Kelurahan::create(['name' => 'Kelurahan B1', 'kecamatan_id' => $kecamatanB->id]);
        Kelurahan::create(['name' => 'Kelurahan B2', 'kecamatan_id' => $kecamatanB->id]);
        Kelurahan::create(['name' => 'Kelurahan B3', 'kecamatan_id' => $kecamatanB->id]);
    }
}
