<?php

namespace App\Traits;


use Illuminate\Support\Facades\Redis;

trait RecordVisits
{
    public function recordVisits()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey()
    {
        $className = strtolower(class_basename($this));
//        return "{$className}.{$this->id}.visits";
    }
}