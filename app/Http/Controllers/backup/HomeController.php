<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        // $role = Role::create(['name' => 'kasir']);
        // $permission = Permission::create(['name' => 'product']);
        // $role = Role::create(['name' => 'user']);
        // $permission = Permission::create(['name' => 'home']);

        // Coba ini nanti dicek lagi
        // auth()->user()->givePermissionTo('setting', 'product');
        // auth()->user()->assignRole('admin');
        // $role = Role::findById(1);
        // $role->givePermissionTo('setting', 'product');

        // Ini untuk mengecek permission apa aja yang dimiliki user
        // $permission = Auth::user()->permissions;
        // dd($permission);

        // $roles = Auth::user()->getRoleNames();
        // dd($roles);


        // auth()->user()->removeRole('admin');
        $user = Auth::user();
        $role = $user->getRoleNames();
        $permission = $user->getPermissionNames();
        // dd($role);
        // if ($role[0] == null) {
        //     $user->assignRole('admin');
        // }

        // if ($roleNames->isEmpty() || $permissionNames->isEmpty()) {
        if (Role::all()->isEmpty() || Permission::all()->isEmpty()) {
            $role_list = [
                'mahasiswa',
                'dosen',
                'adminTU',
            ];
            $permission_list = [
                'mahasiswa',
                'dosen',
                'adminTU',
                'korkon',
                'panitia_ujian',
            ];

            if (Role::all()->isEmpty()) {

                foreach ($role_list as $roless) {
                    Role::create(['name' => $roless]);
                }
            }
            if (Permission::all()->isEmpty()) {

                foreach ($permission_list as $permit) {
                    Permission::create(['name' => $permit]);
                }
            }

            if ($role[0] == null) {
                $user->assignRole('adminTU');
            }

            // Bagian ini perlu penyederhanaan, masih mencari penyederhanaannya~

            foreach ($role_list as $role) {
                if ($role === 'adminTU') {
                    $nama_role = Role::findByName($role);
                    $nama_role->givePermissionTo('dosen');
                    $nama_role->givePermissionTo('adminTU');
                } else {
                    $nama_role = Role::findByName($role);
                    $nama_role->givePermissionTo($role);
                }
            }

            // $nama_role = Role::findByName('mahasiswa');
            // $nama_role->givePermissionTo('mahasiswa');

            // $nama_role = Role::findByName('dosen');
            // $nama_role->givePermissionTo('dosen');

            // $nama_role = Role::findByName('adminTU');
            // // foreach ($permission_list as $permit) {
            // //     $nama_role->givePermissionTo($permit);
            // // }
            // $nama_role->givePermissionTo('dosen');
            // $nama_role->givePermissionTo('adminTU');
        } else {
            if ($role[0] == null) {
                $user->assignRole('mahasiswa');
            }
        }
        return view('home');
    }

    public function product()
    {
        return view('product');
    }
    public function setting()
    {
        $permissions = Permission::all();

        $roles_all = Role::all();
        $users = User::all();
        $roles = Auth::user()->getRoleNames();
        return view('setting', compact("users", "roles", "roles_all", "permissions"));
    }
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        // $roles = Role::all();
        // $permissions = Permission::all();
        $roles_name = $user->getRoleNames();
        // $permission_name = $user->permissions;

        if ($request->isMethod('post')) {
            # code...
            $data = $request->all();

            $role = Role::findById($data['role']);

            if ($roles_name == true) {
                $user->removeRole($roles_name[0]);
            }

            if ($data['role'] == 1) {
                $user->assignRole($role);
                $role->givePermissionTo('mahasiswa');
            } elseif ($data['role'] == 2) {
                $user->assignRole($role);

                $role->givePermissionTo('dosen');
            } else {
                $user->assignRole($role);
                $role->givePermissionTo('dosen');
                $role->givePermissionTo('adminTU');
            }

            return redirect()->route('setting')->with('status', 'Role user berhasil di update');
        }

        // return view('edit_setting', compact('user', 'roles', 'permissions'));
    }
}
