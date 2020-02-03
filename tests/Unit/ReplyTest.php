<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function a_reply_has_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
