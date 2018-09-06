<?php

namespace App;

use App\Model;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

/**
 * 表 => posts
 * Class Post
 * @package App
 */
class Post extends Model
{
    use Searchable;

    /**
     * 定义索引里面的type值
     * @return string
     */
    public function searchableAs()
    {
        return "post";
    }

    /**
     * 定义哪些字段需要搜索
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 评论模型
     * @return $this
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    /**
     * 关联赞
     * 判断文章user_id在该文章是否有赞
     * @param $user_id
     * @return $this
     */
    public function zan($user_id)
    {
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    /**
     * 文章的所有赞
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function zans()
    {
        return $this->hasMany(\App\Zan::class);
    }

    /**
     * 属于某一作者的文章
     * @param Builder $query
     * @param $user_id
     * @return mixed
     */
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * 定义模型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }

    /**
     * 不属于某一专题的文章
     * @param Builder $query
     * @param $topic_id
     * @return mixed
     */
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id){
            $q->where('topic_id', $topic_id);
        });
    }

    /**
     * 使用全局scope的方式
     */
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        // 参数1为scope名字
        static::addGlobalScope("available", function (Builder $builder){
            $builder->whereIn('status', [0,1]);
        });
    }
}