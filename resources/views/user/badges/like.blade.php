@if($target_user->id != \Illuminate\Support\Facades\Auth::id())
    <div>
        {{--like-value关注状态，已关注显示1，未关注显示0，like-user想关注的用户的id--}}
        @if(\Illuminate\Support\Facades\Auth::user()->hasStar($target_user->id))
            <button class="btn btn-default like-button" like-value="1" like-user="{{$target_user->id}}" type="button">取消关注</button>
        @else
            <button class="btn btn-default like-button" like-value="0" like-user="{{$target_user->id}}" type="button">关注</button>
        @endif
    </div>
@endif