<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define base roles
        $roles = ['admin', 'user'];

        foreach ($roles as $roleName) {
            // Create role if it doesn't exist
            Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'sanctum'] // Important for SPA API
            );
        }
    }
}
