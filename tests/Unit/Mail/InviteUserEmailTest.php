<?php

namespace Tests\Unit\Mail;

use App\Mail\InviteUserEmail;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteUserEmailTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $invitee = factory(User::class)->create();
        $coordinator = factory(User::class)->create(['name' => 'Harry Potter']);

        $this->email = (new InviteUserEmail($invitee, $coordinator))->render();
    }

    /** @test */
    function email_contains_link_to_set_password()
    {
        $this->assertContains(url('/password/reset/'), $this->email);
    }

    /** @test */
    function email_contains_user_who_invited_them()
    {
        $this->assertContains('Harry Potter', $this->email);
    }
}
