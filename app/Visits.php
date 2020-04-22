<?php

namespace App;


use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $relation;

    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    protected function cacheKey()
    {
        $className = strtolower(class_basename($this->relation));
        return "{$className}.{$this->relation->id}.visits";
    }
}
