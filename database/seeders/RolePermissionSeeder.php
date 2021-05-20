<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permission_list = [
            'mahasiswa',
            'dosen',
            'adminTU',
            'korkon_elektro',
            'korkon_telkom',
            'korkon_tek_kom',
            'panitia_ujian',
            'reviewer',
            'kaprogdi_elektro',
            'kaprogdi_tekkom',
        ];

        $role_list = [
            'mahasiswa',
            'dosen',
            'adminTU',
        ];

        foreach ($permission_list as $value) {
            Permission::create(['name' => $value]);
        }

        foreach ($role_list as $value) {
            $role = Role::create(['name' => $value]);
            if ($value === 'mahasiswa') {
                $role->givePermissionTo('mahasiswa');
            } else if ($value === 'dosen') {
                $role->givePermissionTo(['dosen', 'reviewer']);
            } else if ($value === 'adminTU') {
                $role->givePermissionTo(['adminTU', 'dosen', 'korkon_elektro', 'korkon_telkom', 'korkon_tek_kom', 'panitia_ujian']);
            }
        }




        // // create permissions
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);
        // Permission::create(['name' => 'publish articles']);
        // Permission::create(['name' => 'unpublish articles']);

        // // create roles and assign created permissions

        // // this can be done as separate statements
        // $role = Role::create(['name' => 'writer']);
        // $role->givePermissionTo('edit articles');

        // // or may be done by chaining
        // $role = Role::create(['name' => 'moderator'])
        //     ->givePermissionTo(['publish articles', 'unpublish articles']);

        // $role = Role::create(['name' => 'super-admin']);
        // $role->givePermissionTo(Permission::all());
    }
}
