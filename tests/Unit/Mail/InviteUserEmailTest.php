<?php

namespace Tests\Unit\Mail;

use App\Mail\InviteUserEmail;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteUserEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function email_contains_link_to_set_password()
    {
        $user = factory(User::class)->create();

        $email = (new InviteUserEmail($user))->render();

        $this->assertContains(url('/password/reset/'), $email);
    }
}
