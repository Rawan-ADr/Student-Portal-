<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;


class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole= Role::create(['name'=>'admin']);

        $permissions=[
           'doc.create' 
        ];

       foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        $adminRole->syncPermissions($permissions);
        


        $adminUser=User::factory()->create([
            'name' =>'Admin',
            'email' =>'admin@gmail.com',
            'password' =>bcrypt('12345678'),
        ]);

        $adminUser->assignRole($adminRole);
        $permissions=$adminRole->permissions()->pluck('name')->toArray();
         $adminUser->givePermissionTo($permissions);






    }



}
