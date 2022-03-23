<?php

namespace Tests\Feature\Livewire\App\Forms;

use App\Http\Livewire\Galaxy\Donations;
use App\Models\Donation;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_livewire_component_on_page()
    {
        $user = User::factory()->create()->assignRole('institute');
        $event = Event::factory()->preset('mblgtacc')->create();

        $this->actingAs($user)
            ->get('/galaxy/events/' . $event->id . '/edit/workshops')
            ->assertSuccessful()
            ->assertSeeLivewire('galaxy.events.edit.workshop-form');
    }

    /** @test */
    public function can_view_all_donations()
    {
        Donation::factory(5)->create();
        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(Donations::class)
            ->assertCount('donations', 5);
    }

    /** @test */
    public function can_search_donations()
    {
        Donation::factory(5)->create();
        Donation::factory()->create(['transaction_id' => 'ch_123123']);

        $user = User::factory()->create()->assignRole('institute');

        Livewire::actingAs($user)
            ->test(Donations::class)
            ->assertCount('donations', 6)
            ->set('filters.search', 'ch_123')
            ->assertCount('donations', 1);
    }
}
