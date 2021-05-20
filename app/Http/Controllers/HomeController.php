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

        return view('home');
    }

    public function product()
    {
        return view('product');
    }

    public function setting()
    {

        $roles_all = Role::all();
        $users = User::all();
        $roles = Auth::user()->getRoleNames();
        return view('setting', compact("users", "roles", "roles_all"));
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $roles_name = $user->getRoleNames();
        if ($request->isMethod('post')) {

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
                $role->givePermissionTo('panitia_ujian');
                $role->givePermissionTo('korkon');
            }

            return redirect()->route('setting')->with('success', 'Role user berhasil di update');
        }
    }
}
