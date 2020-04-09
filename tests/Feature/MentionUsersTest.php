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

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create(User::class, ['name' => 'John']);
        create(User::class, ['name' => 'John2']);
        create(User::class, ['name' => 'jane']);

        $result = $this->json('GET', '/api/users', [
            'name' => 'john'
        ]);

        $this->assertCount(2, $result->json());
    }
}
