<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->get('threads/create')
            ->assertRedirect('login');

        $this->post('threads')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_new_create_forum_thread()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $this->post('threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
