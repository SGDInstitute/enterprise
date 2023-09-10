<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use App\Livewire\App\Dashboard\Workshops;
use App\Models\Response;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class WorkshopsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_workshops(): void
    {
        $user = User::factory()->create();
        Response::factory()->count(5)->for($user)->create(['type' => 'workshop']);

        Livewire::actingAs($user)
            ->test(Workshops::class)
            ->assertCount('workshops', 5);
    }

    /** @test */
    public function collaborator_can_view_workshop(): void
    {
        $collaborator = User::factory()->create();
        $workshop = Response::factory()->create(['type' => 'workshop']);
        $workshop->collaborators()->attach($collaborator);

        Livewire::actingAs($collaborator)
            ->test(Workshops::class)
            ->assertCount('workshops', 1);
    }
}
