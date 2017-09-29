<?php

namespace Tests\Feature;

use App\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanViewDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_view_dashboard()
    {
        Permission::create(['name' => 'view dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view dashboard');

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    /** @test */
    function normal_users_cannot_view_dashboard()
    {
        Permission::create(['name' => 'view dashboard']);
        $user = factory(User::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)->get('/admin');

        $response->assertRedirect('/home');
    }
}
