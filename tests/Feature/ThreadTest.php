<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertSee($thread->title);
    }
}
