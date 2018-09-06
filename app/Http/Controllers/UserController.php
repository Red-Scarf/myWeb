<?php

namespace App\Http\Controllers;

use App\Fan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 个人设置页面
    public function setting()
    {
        return view('user.setting');
    }

    // 设置行为行为
    public function settingStore()
    {

    }

    // 个人中心页面
    public function show(User $user)
    {
        // 个人信息,关注粉丝文章数
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        // 前十条文章列表
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();

        // 关注的用户，二级关联：包含该用户的关注粉丝文章数
        $stars = $user->stars;
        $susers = User::whereIn('id', $stars->pluck('star_id'))->withCount((['stars', 'fans', 'posts']))->get();// 模型里面的某一个字段

        // 粉丝用户，二级关联：包含该用户的关注粉丝文章数
        $fans = $user->fans;
        $fusers = User::whereIn('id', $fans->pluck('fan_id'))->withCount(['stars', 'fans', 'posts'])->get();// 模型里面的某一个字段

        return view('user.show', compact('user', 'posts', 'susers', 'fusers'));
    }

    // 关注
    public function fan(User $user)
    {
        // 获取当前用户
        $me = Auth::user();

        \App\Fan::firstOrCreate(['fan_id' => $me->id, 'star_id' => $user->id]);
//        $me->doFan($user->id);

        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    // 取消关注
    public function unfan(User $user)
    {
        // 获取当前用户
        $me = Auth::user();

        \App\Fan::where('fan_id', $me->id)->where('star_id', $user->id)->delete();
//        $me->doUnFan($user->id);

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
