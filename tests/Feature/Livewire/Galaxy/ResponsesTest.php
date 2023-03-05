<?php

namespace Tests\Feature\Livewire\Galaxy;

use App\Http\Livewire\Galaxy\Responses;
use App\Models\Event;
use App\Models\Form;
use App\Models\Response;
use App\Models\User;
use App\Notifications\FinalizeWorkshop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class ResponsesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_send_notification_status(): void
    {
        Notification::fake();
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();
        $form = Form::factory()->for($event)->create();
        Form::factory()->for($event)->create(['name' => 'Finalize Form', 'type' => 'finalize', 'parent_id' => $form->id]);
        Response::factory(5)->for($form)->create(['status' => 'confirmed']);

        Livewire::actingAs($user)
            ->test(Responses::class, ['form' => $form, 'event' => $form->event])
            ->set('notification.type', 'finalize')
            ->set('notification.status', 'confirmed')
            ->call('sendNotifications')
            ->assertEmitted('notify');

        Notification::assertSentTimes(FinalizeWorkshop::class, 5);
    }
}
