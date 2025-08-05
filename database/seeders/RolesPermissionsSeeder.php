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
           $permissions = [
            'view requests',
            'approve requests',
            'reject requests',
            'view requests data',
            'import marks',
            'add student',
            'add student record',
            'add notes',
            'get student records',
            'get student',
            'index notes',
            'index all records',
            'index students',
            'confirm review',
            'request modification',
            'add announcement',
            'update announcement',
            'delete announcement',

            
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm,'guard_name' => 'web']);
        }

        $roles = ['admin', 'professor', 'affairs_officer', 'exam_officer','committee',
    'student office','deanship office'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        


        $adminUser=User::factory()->create([
            'name' =>'Admin',
            'email' =>'admin@gmail.com',
            'password' =>bcrypt('12345678'),
        ]);

        $adminUser->assignRole('admin');
        





    }



}
