<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     // 'id' => 1,
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('123123123'),
        // ]);
        // $admin = DB::table('users')->get();

        // foreach ($admin as $key) {
        //     $key->assignRole('adminTU');
        // }
        $admin = User::factory()->count(1)->create();
        // foreach (Role::all() as $role) {
        //     $admin->assignRole($role);
        // }
        // $admin = User::factory()->count(1)->create(); // Ini bisa buat usernya
        // $admin->assignRole('adminTU');





        // $admin = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('123123123'),
        // ]);


        // foreach (Role::all() as $role) {
        //     if ($role === 'adminTU') {
        //         $users = User::factory()->make();
        //         foreach ($users as $user) {
        //             $user->assignRole($role);
        //         }
        //     }
        // }
    }
}
