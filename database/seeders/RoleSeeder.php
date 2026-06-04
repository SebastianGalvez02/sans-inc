<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
/**
 * RoleSeeder
 *
 * This seeder populates the 'roles' table with the system's
 * default roles. Run with 'php artisan db:seed'.
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     * Inserts the three default roles into the 'roles' table.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'admin',   'description' => 'Full system access'],
            ['role_name' => 'user',    'description' => 'Standard user access'],
            ['role_name' => 'client',  'description' => 'Client access'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
