<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@desacerdas.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'nik' => '1234567890123456',
            'alamat' => 'Kantor Desa',
            'no_hp' => '081234567890',
            'tanggal_lahir' => '1980-01-01',
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        // Create Operator User
        $operator = User::create([
            'name' => 'Operator Desa',
            'email' => 'operator@desacerdas.com',
            'password' => Hash::make('operator123'),
            'email_verified_at' => now(),
            'nik' => '1234567890123457',
            'alamat' => 'Kantor Desa',
            'no_hp' => '081234567891',
            'tanggal_lahir' => '1985-01-01',
        ]);

        // Assign operator role
        $operator->assignRole('operator');

        // Create Sample Warga User
        $warga = User::create([
            'name' => 'Warga Contoh',
            'email' => 'warga@desacerdas.com',
            'password' => Hash::make('warga123'),
            'email_verified_at' => now(),
            'nik' => '1234567890123458',
            'alamat' => 'Desa Cerdas RT 01 RW 01',
            'no_hp' => '081234567892',
            'tanggal_lahir' => '1990-01-01',
        ]);

        // Assign warga role
        $warga->assignRole('warga');

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@desacerdas.com / admin123');
        $this->command->info('Operator: operator@desacerdas.com / operator123');
        $this->command->info('Warga: warga@desacerdas.com / warga123');
    }
}
