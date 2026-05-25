<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('permissions.roles');

        foreach ($roles as $slug => $config) {
            Role::create([
                'name' => $config['name'],
                'slug' => $slug,
                'description' => $config['description'] ?? '',
                'permissions' => $config['permissions'],
            ]);
        }
    }
}
