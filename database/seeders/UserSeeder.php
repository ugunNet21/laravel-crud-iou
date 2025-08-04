<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('Admin');

        // Operator
        $operator = User::firstOrCreate(
            ['email' => 'operator@example.com'],
            [
                'name' => 'Operator',
                'password' => Hash::make('password'),
            ]
        );
        $operator->assignRole('Operator');

        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('User');

        // Member
        $member = User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member User',
                'password' => Hash::make('password'),
            ]
        );
        $member->assignRole('Member');

        // PIC
        $pic = User::firstOrCreate(
            ['email' => 'pic@example.com'],
            [
                'name' => 'PIC User',
                'password' => Hash::make('password'),
            ]
        );
        $pic->assignRole('PIC');

        $this->command->info('Seeded users.');
    }
}
