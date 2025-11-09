<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Role Seeder first to create roles and permissions
        $this->call(RoleSeeder::class);
        
        // Run User Seeder to create admin, operator, and warga users
        $this->call(UserSeeder::class);

        // Seed application data for testing UI and system features
        $this->call([
            ApbdesSeeder::class,
            BeritaSeeder::class,
            ProdukUmkmSeeder::class,
            LokasiDesaSeeder::class,
            ForumSeeder::class,
            KomentarForumSeeder::class,
            PermohonanSuratSeeder::class,
            ChatSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
