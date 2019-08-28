<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title', 'body','category_id', 'excerpt', 'slug'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 本地作用域 使用scope开头，调用时 withOrder()即可
     * @param $query [查询构造器(默认传参)]
     * @param $order [排序方式]
     */
    public function scopeWithOrder($query, $order)
    {
        switch ($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        //预防 N+1 问题
        $query->with('user','category');
    }

    /**
     * 更新时间倒序
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at','desc');
    }

    /**
     * 创建时间倒序
     * @param $query
     * @return mixed
     */
    public function scopeRecentReplied($query)
    {
        //按照创建时间排序
        return $query->orderBy('created_at','desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id,$this->slug]), $params);
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
