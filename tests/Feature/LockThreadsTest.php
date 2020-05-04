<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_may_lock_any_thread()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $thread->lock();

        $this->postJson($thread->path() . '/replies', [
            'body'    => 'Some reply',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }

}
