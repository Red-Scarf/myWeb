<?php

namespace App\Admin\Controllers;

use \App\Post;

class PostController extends Controller
{
    // 首页
    public function index()
    {
        // 不使用scope且status为0，按时间倒序排列
        $posts = Post::withoutGlobalScope('available')->where('status', 0)->orderBy('created_at', 'desc')->with('user')->paginate(10);

        // $posts->load('user'); // 与上一行中的with功能相同

        return view('admin.post.index', compact('posts'));
    }

    // 操作
    public function status(Post $post)
    {
        // 验证
        $this->validate(request(), [
            'status' => 'required|in:-1,1',
        ]);

        // 保存
        $post->status = request('status');
        $post->save();

        // 传给ajax
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}