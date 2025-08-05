<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    private array $users = [
        [
            'email' => 'admin@example.com',
            'name' => 'Admin',
            'role' => 'Admin'
        ],
        [
            'email' => 'operator@example.com',
            'name' => 'Operator',
            'role' => 'Operator'
        ],
        [
            'email' => 'user@example.com',
            'name' => 'User',
            'role' => 'User'
        ],
        [
            'email' => 'member@example.com',
            'name' => 'Member User',
            'role' => 'Member'
        ],
        [
            'email' => 'pic@example.com',
            'name' => 'PIC User',
            'role' => 'PIC'
        ],
        [
            'email' => 'pic2@example.com',
            'name' => 'PIC User2',
            'role' => 'PIC'
        ],
        [
            'email' => 'front.kelurahan@example.com',
            'name' => 'Front Office Kelurahan',
            'role' => 'Front Office Kelurahan'
        ],
        [
            'email' => 'front.kecamatan@example.com',
            'name' => 'Front Office Kecamatan',
            'role' => 'Front Office Kecamatan'
        ],
        [
            'email' => 'back.kota@example.com',
            'name' => 'Back Office Kota',
            'role' => 'Back Office Kota'
        ],
        [
            'email' => 'pemerlu.kesejahteraan@example.com',
            'name' => 'Pemerlu Kesejahteraan',
            'role' => 'Pemerlu Pelayanan Kesejahteraan Sosial'
        ],
        [
            'email' => 'sumber.kesejahteraan@example.com',
            'name' => 'Sumber Kesejahteraan',
            'role' => 'Potensi dan Sumber Kesejahteraan Sosial'
        ]
    ];

    public function run(): void
    {
        foreach ($this->users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password')
                ]
            );
            $user->assignRole($userData['role']);
        }

        $this->command->info('Seeded users.');
    }
}
