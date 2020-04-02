<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $johnDoe = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($johnDoe);

        $janeDoe = create(User::class, ['name' => 'JaneDoe']);

        $thread = create(Thread::class);
        $reply  = make(Reply::class, [
            'body'      => '@JaneDoe look at this'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $janeDoe->notifications);
    }
}
