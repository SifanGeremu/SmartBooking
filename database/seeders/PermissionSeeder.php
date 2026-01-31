<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            'create appointment',
            'view appointment',
            'update appointment',
            'delete appointment',
        ];
        foreach ($permissions as $permission) { Permission::firstOrCreate(['name' => $permission]); }
        //Attach permissions to existing roles
         $adminRole = Role::where('name', 'admin')->first(); $adminRole->givePermissionTo(Permission::all()); $userRole = Role::where('name', 'user')->first(); $userRole->givePermissionTo(['create appointments', 'view appointments']); 
    }

}