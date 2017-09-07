<?php

namespace Tests\Unit;

use App\User;
use App\UserToken;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_user_token_by_token()
    {
        $user = factory(User::class)->create();
        $user->createToken();

        $userToken =  (new UserToken)->resolveRouteBinding($user->token->token);

        $this->assertNotNull($userToken);
        $this->assertEquals($user->token->token, $userToken->token);
    }
}
