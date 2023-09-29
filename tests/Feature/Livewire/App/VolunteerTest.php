<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Volunteer;
use App\Models\Event;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VolunteerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function happy_path_http_check(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->has(Shift::factory()->count(5))->create();

        $this->actingAs($user)
            ->get(route('app.volunteer', $event))
            ->assertSuccessful();
    }

    #[Test]
    public function forbidden_if_not_authenticated(): void
    {
        $event = Event::factory()->has(Shift::factory()->count(5))->create();

        $this->get(route('app.volunteer', $event))
            ->assertRedirectToRoute('login');
    }

    #[Test]
    public function forbidden_if_not_verified(): void
    {
        $user = User::factory()->unverified()->create();
        $event = Event::factory()->has(Shift::factory()->count(5))->create();

        $this->actingAs($user)->get(route('app.volunteer', $event))
            ->assertRedirectToRoute('verification.notice');
    }

    #[Test]
    public function can_view_shifts(): void
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        Shift::factory()->for($event)->create(['name' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->assertSee('Hello world');
    }

    #[Test]
    public function can_sign_up_to_volunteer()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $shift = Shift::factory()->for($event)->create(['name' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->fillForm([
                'shifts' => [
                    $shift->id
                ],
            ])
            ->call('signup')
            ->assertHasNoFormErrors();

        $this->assertContains($shift->id, $user->shifts->pluck('id'));
    }

    #[Test]
    public function can_update_volunteer_signup()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $shiftA = Shift::factory()->for($event)->create(['name' => 'Hello world']);
        $shiftB = Shift::factory()->for($event)->create(['name' => 'Foo Bar']);
        $shiftA->users()->attach($user);

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->assertFormSet([
                'shifts' => [
                    $shiftA->id,
                ],
            ])
            ->fillForm([
                'shifts' => [
                    $shiftB->id,
                ],
            ])
            ->call('signup')
            ->assertHasNoFormErrors();

        $this->assertNotContains($shiftA->id, $user->shifts->fresh()->pluck('id'));
        $this->assertContains($shiftB->id, $user->shifts->fresh()->pluck('id'));
    }
}
