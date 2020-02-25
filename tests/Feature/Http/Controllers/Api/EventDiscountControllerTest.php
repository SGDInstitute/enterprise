<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Activity;
use App\ActivityType;
use App\Event;
use App\Schedule;
use App\TicketType;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Api\EventDiscountController
 */
class EventDiscountControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_one_shift_gets_one_shift_discount()
    {
        $event = factory(Event::class)->create();
        $oneShift = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '1 Shift',
            'cost' => 6000,
            'type' => 'discount',
        ]);
        $twoShifts = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '2 Shifts',
            'cost' => 3500,
            'type' => 'discount',
        ]);
        $threeShifts = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '3 Shifts',
            'cost' => 0,
            'type' => 'discount',
        ]);

        $schedule = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Volunteer Track']);
        $activityType = factory(ActivityType::class)->create(['title' => 'General']);
        $activity1 = factory(Activity::class)->create(['title' => 'Campus Wanderers 1', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);
        $activity2 = factory(Activity::class)->create(['title' => 'Campus Wanderers 2', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);
        $activity3 = factory(Activity::class)->create(['title' => 'Campus Wanderers 3', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);

        $user = factory(User::class)->create();
        $user->schedule()->toggle($activity1->id);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->json('post', "api/events/{$event->id}/discounts");

        $response->assertOk();

        $this->assertLessThanOrEqual(7, count(DB::getQueryLog()));
        $this->assertCount(1, $user->discounts()->where('event_id', $event->id)->get());
        $this->assertEquals($oneShift->id, $user->discounts->firstWhere('event_id', $event->id)->id);
    }

    /** @test */
    public function user_with_two_shift_gets_two_shift_discount()
    {
        $event = factory(Event::class)->create();
        $oneShift = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '1 Shift',
            'cost' => 6000,
            'type' => 'discount',
        ]);
        $twoShifts = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '2 Shifts',
            'cost' => 3500,
            'type' => 'discount',
        ]);
        $threeShifts = factory(TicketType::class)->create([
            'event_id' => $event->id,
            'name' => '3 Shifts',
            'cost' => 0,
            'type' => 'discount',
        ]);

        $schedule = factory(Schedule::class)->create(['event_id' => $event->id, 'title' => 'Volunteer Track']);
        $activityType = factory(ActivityType::class)->create(['title' => 'General']);
        $activity1 = factory(Activity::class)->create(['title' => 'Campus Wanderers 1', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);
        $activity2 = factory(Activity::class)->create(['title' => 'Campus Wanderers 2', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);
        $activity3 = factory(Activity::class)->create(['title' => 'Campus Wanderers 3', 'activity_type_id' => $activityType->id, 'schedule_id' => $schedule->id]);

        $user = factory(User::class)->create();
        $user->schedule()->toggle($activity1->id);
        $user->schedule()->toggle($activity2->id);

        Passport::actingAs($user);

        DB::enableQueryLog();
        $response = $this->withoutExceptionHandling()->json('post', "api/events/{$event->id}/discounts");

        $response->assertOk();

        $this->assertLessThanOrEqual(7, count(DB::getQueryLog()));
        $this->assertCount(1, $user->discounts()->where('event_id', $event->id)->get());
        $this->assertEquals($twoShifts->id, $user->discounts->firstWhere('event_id', $event->id)->id);
    }
}
