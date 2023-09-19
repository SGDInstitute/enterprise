<?php

namespace Tests\Feature\Filament\Resources;

use PHPUnit\Framework\Attributes\Test;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_bulk_delete_users(): void
    {
        $users = User::factory()->count(5)->create();

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users)
            ->callTableBulkAction(DeleteBulkAction::class, $users);

        foreach ($users as $user) {
            $this->assertModelMissing($user);
        }
    }

    #[Test]
    public function can_delete_all_unverified_users_without_other_data(): void
    {
        $deletableUsers = User::factory()->times(5)->unverified()->create();
        $verifiedUser = User::factory()->create();
        $ticketUser = User::factory()->unverified()->has(Ticket::factory()->count(1))->create();
        $orderUser = User::factory()->unverified()->has(Order::factory()->count(1))->create();
        $donationUser = User::factory()->unverified()->has(Donation::factory()->count(1))->create();

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords([...$deletableUsers, $verifiedUser, $ticketUser, $orderUser, $donationUser])
            ->callAction('mass-delete-junk');

        foreach ($deletableUsers as $user) {
            $this->assertModelMissing($user);
        }
        $this->assertModelExists($verifiedUser);
        $this->assertModelExists($ticketUser);
        $this->assertModelExists($orderUser);
        $this->assertModelExists($donationUser);
    }
}
