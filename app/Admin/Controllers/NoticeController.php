<?php

namespace App\Admin\Controllers;

class NoticeController extends Controller
{
    // 显示
    public function index()
    {
        $notices = \App\Notice::all();
        return view('admin/notice/index', compact('notices'));
    }

    // 创建页面
    public function create()
    {
        return view('admin/notice/create');

    }

    // 创建操作
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $notice = \App\Notice::create(request(['title', 'content']));

        // 队列的实现方法
        dispatch(new \App\Jobs\SendMessage($notice));

        return redirect("/admin/notices");
    }
}