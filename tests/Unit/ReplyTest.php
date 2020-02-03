<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_reply_has_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
