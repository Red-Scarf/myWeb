<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Support\Facades\Auth;

/**
 * 专题
 * Class TopicController
 * @package App\Http\Controllers
 */
class TopicController extends Controller
{
    /**
     * 显示专题详情页
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Topic $topic)
    {
        // 带文章数的专题
        // 在withCount上依据topic_id查找模型
        $topic = Topic::withCount('postTopics')->find($topic->id);

        // 专题文章列表，按创建时间倒序排列前十
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        // 属于用户的文章但未投稿
        $myposts = \App\Post::authorBy(Auth::id())->topicNotBy($topic->id)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }

    /**
     * 投稿
     * @param Topic $topic
     */
    public function submit(Topic $topic)
    {
        $this->validate(request(), [
            'post_ids' => 'required|array',
        ]);

        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id){
            \App\PostTopic::firstOrCreate(compact('topic_id', 'post_id'));
        }

        return back();
    }
}
