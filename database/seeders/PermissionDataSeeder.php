<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions List as Array

        $permissions = [
            [
                'name' => 'test.create',
                'slug' => 'test.create'
            ]
        ];

        for ($i = 0; $i < count($permissions); $i++) {
            $permissionName = $permissions[$i]['name'];
            $permissionSlug = $permissions[$i]['slug'];
            Permission::create([
                'name' => $permissionName,
                'slug' => $permissionSlug
            ]);
        }
    }
}
