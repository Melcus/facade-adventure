<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\WelcomeMail;
use App\Services\Galactus\Facades\Galactus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    const KID = 'mocked kid';

    protected function setUp(): void
    {
        parent::setUp();

        Galactus::shouldReceive('getKid')
            ->once()
            ->andReturn(self::KID);
    }

    public function testItStoresUserSuccessfully(): void
    {
        $this->post(route('api.user.create'), [
            'email' => $email = fake()->email(),
            'name' => $name = fake()->name(),
            'password' => fake()->password(),
        ])->assertCreated()->assertJsonFragment([
            'email' => $email,
            'name' => $name,
            'kid' => self::KID,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name,
            'kid' => self::KID,
        ]);
    }

    public function testWelcomeLetterWasQueued(): void
    {
        $this->post(route('api.user.create'), [
            'email' => $email = fake()->email(),
            'name' => fake()->name(),
            'password' => fake()->password(),
        ])->assertCreated();

        Mail::assertQueued(WelcomeMail::class, function (Mailable $mail) use ($email) {
            return $mail->hasTo($email);
        });
    }
}
