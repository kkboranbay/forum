<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->get('threads/create')
            ->assertRedirect(route('login'));

        $this->post('threads')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $response = $this->publishThreads(['title' => 'Title', 'body' => 'Body']);

        $this->get($response->headers->get('Location'))
            ->assertSee('Title')
            ->assertSee('Body');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThreads(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThreads(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_required_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThreads(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        create(Thread::class, [], 2);

        $thread = create(Thread::class, [
            'title' => 'Test',
        ]);

        $this->assertEquals($thread->slug, 'test');

        $thread2 = $this->postJson(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals($thread2["slug"], "test-{$thread2['id']}");

        $thread3 = $this->postJson(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response' => 'token']
        )->json();

        $this->assertEquals($thread3["slug"], "test-{$thread3['id']}");
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, [
            'title' => 'Test 2',
        ]);

        $this->assertEquals($thread->slug, 'test-2');

        $thread2 = $this->postJson(
            route('threads'),
            $thread->toArray() + ['g-recaptcha-response'=>'token']
        )->json();

        $this->assertEquals("test-2-{$thread2['id']}", $thread2['slug']);
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThreads(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThreads(['channel_id' => 99])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect('login');

        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply  = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function authenticated_user_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory(User::class)->state('unconfirmed')->create();

        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    public function publishThreads($overrides = [])
    {
        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }

}