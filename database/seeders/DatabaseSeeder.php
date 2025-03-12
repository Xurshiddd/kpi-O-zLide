<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use App\Models\Region;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $regions = [
            'Toshkent', 'Toshkent viloyati', 'Samarqand viloyati', 'Jizzax viloyati', 'Sirdaryo viloyati', 'Farg\'ona viloyati',
            'Andijon viloyati', 'Namangan viloyati', 'Sirdaryo viloyati', 'Qashqadaryo viloyati', 'Surxandaryo viloyati', 'Buxoro viloyati',
            'Navoiy viloyati', 'Qoraqalpog\'iston Respublikasi', 'Xorazm viloyati'
        ];
        $categories = ['CK', 'Tuman'];
        $departments = ['1-bo\'lim', '2-bo\'lim', '3-bo\'lim', '4-bo\'lim', '5-bo\'lim',];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
        foreach ($regions as $region) {
            Region::create([
                'name' => $region,
            ]);
        }
        foreach ($departments as $department) {
            Department::create([
                'name' => $department,
                'category_id' => 1
            ]);
        }
        $permissons = ['create', 'read', 'update', 'delete'];
        foreach ($permissons as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->syncPermissions(Permission::all());
        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '+998975413303',
            'region_id' => 1,
            'department_id' => 1,
            'address' => 'Chinoz',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $user->assignRole('Admin');
    }
}
