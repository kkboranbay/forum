<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favorites_count', 'is_favorited'];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        self::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = preg_replace('/\@([\w\-]+)/', "<a href='/profiles/$1'>$0</a>", $value);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([\w\-]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }
}
