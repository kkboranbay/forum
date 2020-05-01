<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed'         => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf('User.%s.visited.%s', $this->id, $thread->id);
    }

    public function readThread($thread)
    {
        Cache::forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save();
    }


    public function getAvatarPathAttribute($avatar)
    {
        return asset(Storage::url($avatar ?: 'avatars/default.png'));

//        $path = $avatar ?: 'avatars/default.png';
//
//        return '/storage/' . $path;
    }
}
