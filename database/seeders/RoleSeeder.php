<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Operator',
            'User',
            'Member',
            'PIC',
            'Front Office Kelurahan',
            'Front Office Kecamatan',
            'Back Office Kota',
            'Pemerlu Pelayanan Kesejahteraan Sosial',
            'Potensi dan Sumber Kesejahteraan Sosial'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $this->command->info('Seeded roles.');
    }
}
