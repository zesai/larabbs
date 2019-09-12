<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Traits\ActiveUserHelper;
    use Traits\LastActivedAtHelper;
    use HasRoles;
    use MustVerifyEmailTrait;
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return ;
        }

        //只有是数据库类型通知才需要提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 是否有操作权限
     * @param $model
     * @return bool
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    /**
     * 标记消息通知为已读
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();

        //标记通知为已读 (循环)
        $this->unreadNotifications->markAsRead();
    }

    /**
     * 后台保存修改密码时加密
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况(自带前台注册)
        if (strlen($value) != 60){
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        //如果不是 http 开头，就是从后台传过来的
        if ( !starts_with($path, 'http') ){

            $path = config('app.url') . '/uploads/images/avatars/' . $path;

        }

        $this->attributes['avatar'] = $path;
    }
}
