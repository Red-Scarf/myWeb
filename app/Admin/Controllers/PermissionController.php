<?php

namespace App\Admin\Controllers;

class PermissionController extends Controller
{
    // 权限列表页面
    public function index()
    {
        $permissions = \App\AdminPermission::paginate(10);
        return view('admin.permission.index', compact('permissions'));
    }

    // 创建权限页面
    public function create()
    {
        return view('admin.permission.add');
    }

    // 创建权限操作
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        \App\AdminPermission::create(request(['name', 'description']));

        return redirect('/admin/permissions');
    }
}