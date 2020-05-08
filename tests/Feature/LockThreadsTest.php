<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_admin_may_not_lock_threads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('locked_thread.store', $thread))
            ->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    public function admin_may_lock_threads()
    {
        $this->signIn(factory(User::class)->state('admin')->create());

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->post(route('locked_thread.store', $thread))
            ->assertStatus(200);

        $this->assertTrue(!! $thread->fresh()->locked);

    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
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
