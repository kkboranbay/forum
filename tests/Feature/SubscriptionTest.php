<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscription');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Just comment'
        ]);

        $this->assertCount(1, auth()->user()->notifications);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete($thread->path() . '/subscription');

        $this->assertCount(0, $thread->subscriptions);
    }
}
