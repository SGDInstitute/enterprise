<?php

namespace Tests\Unit;

use App\User;
use App\UserToken;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_user_token_by_token()
    {
        $user = factory(User::class)->create();
        $magicToken = $user->createToken('magic');

        $userToken =  (new UserToken)->resolveRouteBinding($magicToken->token);

        $this->assertNotNull($userToken);
        $this->assertEquals($magicToken->token, $userToken->token);
    }

    /** @test */
    function can_see_if_token_is_expired()
    {
        $user1 = factory(User::class)->create();
        $notExpiredToken = $user1->token()->save(factory(UserToken::class)->make(['created_at' => Carbon::now()]));
        $user2 = factory(User::class)->create();
        $expiredToken = $user2->token()->save(factory(UserToken::class)->make(['created_at' => Carbon::now()->subMinutes(11)]));

        $this->assertFalse($notExpiredToken->isExpired());
        $this->assertTrue($expiredToken->isExpired());
    }

    /** @test */
    function can_see_if_token_belongs_to_user()
    {
        $user1 = factory(User::class)->create(['email' => 'jo@example.com']);
        $token = $user1->token()->save(factory(UserToken::class)->make());
        $user2 = factory(User::class)->create(['email' => 'phoenix@example.com']);

        $this->assertTrue($token->belongsToUser('jo@example.com'));
        $this->assertFalse($token->belongsToUser('phoenix@example.com'));
    }

    /** @test */
    function can_get_type_of_token()
    {
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $emailToken = $user->token()->save(factory(UserToken::class)->make(['type' => 'email']));
        $magicToken = $user->token()->save(factory(UserToken::class)->make(['type' => 'magic']));

        $this->assertEquals($emailToken->token, $user->emailToken->token);
        $this->assertEquals($magicToken->token, $user->magicToken->token);
    }
}
