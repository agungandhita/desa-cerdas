<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $operatorRole = Role::create(['name' => 'operator']);
        $wargaRole = Role::create(['name' => 'warga']);

        // Create permissions
        $permissions = [
            // User management
            'manage-users',
            'view-users',
            
            // Surat permissions
            'manage-surat',
            'view-surat',
            'create-surat',
            'approve-surat',
            
            // APBDes permissions
            'manage-apbdes',
            'view-apbdes',
            
            // Berita permissions
            'manage-berita',
            'create-berita',
            'edit-berita',
            'delete-berita',
            'view-berita',
            
            // UMKM permissions
            'manage-umkm',
            'create-umkm',
            'edit-umkm',
            'delete-umkm',
            'view-umkm',
            
            // Forum permissions
            'manage-forum',
            'create-forum',
            'edit-forum',
            'delete-forum',
            'view-forum',
            'comment-forum',
            
            // Lokasi permissions
            'manage-lokasi',
            'view-lokasi',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        // Admin has all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Operator permissions
        $operatorRole->givePermissionTo([
            'view-users',
            'manage-surat',
            'view-surat',
            'approve-surat',
            'manage-apbdes',
            'view-apbdes',
            'manage-berita',
            'create-berita',
            'edit-berita',
            'delete-berita',
            'view-berita',
            'view-umkm',
            'manage-forum',
            'view-forum',
            'comment-forum',
            'manage-lokasi',
            'view-lokasi',
        ]);

        // Warga permissions
        $wargaRole->givePermissionTo([
            'view-surat',
            'create-surat',
            'view-apbdes',
            'view-berita',
            'create-umkm',
            'edit-umkm',
            'view-umkm',
            'create-forum',
            'edit-forum',
            'view-forum',
            'comment-forum',
            'view-lokasi',
        ]);
    }
}
