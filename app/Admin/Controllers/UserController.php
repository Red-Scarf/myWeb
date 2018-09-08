<?php

namespace App\Admin\Controllers;

use \App\AdminUser;

class UserController extends Controller
{
    // 管理员列表页面
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('/admin/user/index', compact('users'));
    }

    // 管理员创建页面
    public function create()
    {
        return view('/admin/user/add');
    }

    // 创建操作
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'password' => 'required'
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name', 'password'));

        return redirect("/admin/users");
    }

    /**
     * 用户角色页面
     * @param AdminUser $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role(\App\AdminUser $user)
    {
        $roles = \App\AdminRole::all(); // 所有角色
        $myRoles = $user->roles; // 该用户的角色

        return view('/admin/user/role', compact('roles', 'myRoles', 'user'));
    }

    // 储存用户角色
    public function storeRole(\App\AdminUser $user)
    {
        $this->validate(request(), [
            'roles' => 'required|array'
        ]);

        $roles = \App\AdminRole::findMany(request('roles')); // 传上来的角色
        $myRoles = $user->roles; // 该用户的角色

        // 要增加
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role)
        {
            $user->assignRole($role);
        }

        // 要删除
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role)
        {
            $user->deleteRole($role);
        }

        return back();
    }
}
