<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        event(new Registered(create(User::class)));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function user_can_fully_confirm_their_email_address()
    {
        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $user = User::whereName('John')->firstOrFail();

        $this->assertFalse($user->confirmed);

        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token='. $user->confirmation_token);

        $this->assertTrue($user->fresh()->confirmed);

        $response->assertRedirect('/threads');
    }
}
