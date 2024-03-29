<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = create(User::class);

        $this->assertEquals(asset(Storage::url('avatars/default.png')), $user->avatar_path);

        $user->avatar_path = 'avatars/me.png';

        $this->assertEquals(asset(Storage::url('avatars/me.png')), $user->avatar_path);
    }
}
