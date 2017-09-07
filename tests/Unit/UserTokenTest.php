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
        $notExpiredToken = $user1->tokens()->save(factory(UserToken::class)->make());
        $user2 = factory(User::class)->create();
        $expiredToken = $user2->tokens()->save(factory(UserToken::class)->states('expired')->make());

        $this->assertFalse($notExpiredToken->isExpired());
        $this->assertTrue($expiredToken->isExpired());
    }

    /** @test */
    function can_see_if_token_belongs_to_user()
    {
        $user1 = factory(User::class)->create(['email' => 'jo@example.com']);
        $token = $user1->tokens()->save(factory(UserToken::class)->make());
        $user2 = factory(User::class)->create(['email' => 'phoenix@example.com']);

        $this->assertTrue($token->belongsToUser('jo@example.com'));
        $this->assertFalse($token->belongsToUser('phoenix@example.com'));
    }

    /** @test */
    function can_get_token_by_type()
    {
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $emailToken = $user->tokens()->save(factory(UserToken::class)->make(['type' => 'email']));
        $magicToken = $user->tokens()->save(factory(UserToken::class)->make(['type' => 'magic']));

        $this->assertEquals($emailToken->token, $user->emailToken->token);
        $this->assertEquals($magicToken->token, $user->magicToken->token);
    }

    /** @test */
    function clear_out_old_tokens_of_type_before_creating_new_one()
    {
        $user = factory(User::class)->create(['email' => 'jo@example.com']);
        $emailToken = $user->tokens()->save(factory(UserToken::class)->make(['type' => 'email']));
        $magicToken = $user->tokens()->save(factory(UserToken::class)->make(['type' => 'magic']));
        $magicToken = $user->tokens()->save(factory(UserToken::class)->make(['type' => 'magic']));

        $newToken = $user->createToken('magic');

        $this->assertCount(2, $user->tokens);
        $this->assertEquals($newToken->token, $user->magicToken->token);
        $this->assertEquals($emailToken->token, $user->emailToken->token);
    }
}
