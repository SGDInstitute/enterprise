<?php

namespace Tests\Unit;

use App\User;
use App\UserToken;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_user_token_by_token()
    {
        $user = User::factory()->create();
        $magicToken = $user->createToken('magic');

        $userToken = (new UserToken)->resolveRouteBinding($magicToken->token);

        $this->assertNotNull($userToken);
        $this->assertEquals($magicToken->token, $userToken->token);
    }

    /** @test */
    public function can_see_if_token_is_expired()
    {
        $user1 = User::factory()->create();
        $notExpiredToken = $user1->tokens()->save(UserToken::factory()->make());
        $user2 = User::factory()->create();
        $expiredToken = $user2->tokens()->save(UserToken::factory()->expired()->make());

        $this->assertFalse($notExpiredToken->isExpired());
        $this->assertTrue($expiredToken->isExpired());
    }

    /** @test */
    public function can_see_if_token_belongs_to_user()
    {
        $user1 = User::factory()->create(['email' => 'jo@example.com']);
        $token = $user1->tokens()->save(UserToken::factory()->make());
        $user2 = User::factory()->create(['email' => 'phoenix@example.com']);

        $this->assertTrue($token->belongsToUser('jo@example.com'));
        $this->assertFalse($token->belongsToUser('phoenix@example.com'));
    }

    /** @test */
    public function can_get_token_by_type()
    {
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $emailToken = $user->tokens()->save(UserToken::factory()->make(['type' => 'email']));
        $magicToken = $user->tokens()->save(UserToken::factory()->make(['type' => 'magic']));

        $this->assertEquals($emailToken->token, $user->emailToken->token);
        $this->assertEquals($magicToken->token, $user->magicToken->token);
    }

    /** @test */
    public function clear_out_old_tokens_of_type_before_creating_new_one()
    {
        $user = User::factory()->create(['email' => 'jo@example.com']);
        $emailToken = $user->tokens()->save(UserToken::factory()->make(['type' => 'email']));
        $magicToken = $user->tokens()->save(UserToken::factory()->make(['type' => 'magic']));
        $magicToken = $user->tokens()->save(UserToken::factory()->make(['type' => 'magic']));

        $newToken = $user->createToken('magic');

        $this->assertCount(2, $user->tokens);
        $this->assertEquals($newToken->token, $user->magicToken->token);
        $this->assertEquals($emailToken->token, $user->emailToken->token);
    }
}
