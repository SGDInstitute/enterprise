<?php

namespace Tests\Feature\Admin;

use App\Event;
use App\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function view_all_events()
    {
        Permission::create(['name' => 'view dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view dashboard');
        factory(Event::class, 2)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get('/admin/events');

        $response->assertStatus(200)
            ->assertViewHas('events', Event::all());
    }

    /** @test */
    function view_event()
    {
        Permission::create(['name' => 'view dashboard']);
        $user = factory(User::class)->create();
        $user->givePermissionTo('view dashboard');
        $event = factory(Event::class)->create();

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get("/admin/events/{$event->slug}");

        $response->assertStatus(200)
            ->assertViewHas('event', Event::find($event->id));
    }
}
