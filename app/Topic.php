<?php

namespace App;

use App\Model;

class Topic extends Model
{

    /**
     * 属于此专题的所有文章
     */
    public function posts()
    {
        // 参数1:要获取的关系的模型,参数2:关系表,参数3:表与当前模型关联的外键,参数4：表与这个模型关联的属性
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }

    /**
     * 属于专题的文章数,用于withCount
     */
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'topic_id', 'id');
    }
}
