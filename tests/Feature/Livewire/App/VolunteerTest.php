<?php

namespace Tests\Feature\Livewire\App;

use App\Livewire\App\Volunteer;
use App\Models\Event;
use App\Models\Shift;
use App\Models\User;
use App\Notifications\SignedUpForShift;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
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
        Notification::fake();

        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $shift = Shift::factory()->for($event)->create(['name' => 'Hello world']);

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->fillForm([
                'shifts' => [
                    $shift->id,
                ],
            ])
            ->call('signup')
            ->assertHasNoFormErrors();

        $this->assertContains($shift->id, $user->fresh()->shifts->pluck('id'));

        Notification::assertSentTo($user, SignedUpForShift::class);
    }

    #[Test]
    public function can_change_volunteer_signup()
    {
        Notification::fake();

        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $shiftA = Shift::factory()->for($event)->create();
        $shiftB = Shift::factory()->for($event)->create();
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

        $this->assertNotContains($shiftA->id, $user->fresh()->shifts->fresh()->pluck('id'));
        $this->assertContains($shiftB->id, $user->fresh()->shifts->fresh()->pluck('id'));
    }

    #[Test]
    public function can_remove_volunteer_signup()
    {
        Notification::fake();

        $event = Event::factory()->create();
        $user = User::factory()->create(['terms' => [$event->slug => now()]]);
        $shift = Shift::factory()->for($event)->create(['name' => 'Hello world']);
        $shift->users()->attach($user);

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->assertFormSet([
                'shifts' => [
                    $shift->id,
                ],
            ])
            ->fillForm([
                'shifts' => [],
            ])
            ->call('signup')
            ->assertHasNoFormErrors();

        $this->assertNotContains($shift->id, $user->fresh()->shifts->fresh()->pluck('id'));
        $this->assertEmpty($shift->users);
    }

    #[Test]
    public function can_signup_for_additional_shifts()
    {
        Notification::fake();

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
                    $shiftA->id,
                    $shiftB->id,
                ],
            ])
            ->call('signup')
            ->assertHasNoFormErrors();

        $this->assertContains($shiftA->id, $user->fresh()->shifts->fresh()->pluck('id'));
        $this->assertContains($shiftB->id, $user->fresh()->shifts->fresh()->pluck('id'));
    }

    #[Test]
    public function changing_shifts_does_not_affect_others_assigned_to_that_shift()
    {
        Notification::fake();

        $event = Event::factory()->create();
        [$userA, $userB] = User::factory()->count(2)->create();
        [$shiftA, $shiftB] = Shift::factory()->for($event)->count(2)->create(['name' => 'Hello world']);
        $shiftA->users()->attach($userA);
        $shiftA->users()->attach($userB);

        Livewire::actingAs($userA)
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

        $this->assertNotContains($shiftA->id, $userA->fresh()->shifts->fresh()->pluck('id'));
        $this->assertContains($shiftB->id, $userA->fresh()->shifts->fresh()->pluck('id'));
        $this->assertContains($shiftA->id, $userB->fresh()->shifts->fresh()->pluck('id'));
        $this->assertNotContains($shiftB->id, $userB->fresh()->shifts->fresh()->pluck('id'));
    }

    #[Test]
    public function cannot_sign_up_for_filled_shifts()
    {
        Notification::fake();

        $event = Event::factory()->create();
        $user = User::factory()->create();
        $shift = Shift::factory()->for($event)->create(['slots' => 2]);
        $shift->users()->attach(User::factory()->count(2)->create()->pluck('id'));

        Livewire::actingAs($user)
            ->test(Volunteer::class, ['event' => $event])
            ->assertFormFieldExists('shifts', function (CheckboxList $field) use ($shift) {
                return $field->isOptionDisabled($shift->id, 'shifts');
            });
    }
}
