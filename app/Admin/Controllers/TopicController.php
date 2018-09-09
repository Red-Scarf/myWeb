<?php

namespace App\Admin\Controllers;

class TopicController extends Controller
{
    // 显示
    public function index()
    {
        $topics = \App\Topic::all();
        return view('admin/topic/index', compact('topics'));
    }

    // 创建页面
    public function create()
    {
        return view('admin/topic/create');

    }

    // 创建操作
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|string'
        ]);

        \App\Topic::create(['name' => request('name')]);

        return redirect("/admin/topics");
    }

    // 删除操作
    public function destroy(\App\Topic $topic)
    {
        $topic->delete();

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}