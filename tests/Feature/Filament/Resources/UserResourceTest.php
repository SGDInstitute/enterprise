<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_bulk_delete_users()
    {
        $users = User::factory()->count(5)->create();

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->callTableBulkAction(DeleteBulkAction::class, $users);

        foreach ($users as $user) {
            $this->assertModelMissing($user);
        }
    }
}
