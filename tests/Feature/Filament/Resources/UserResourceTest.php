<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserResourceTest extends TestCase
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

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_users(): void
    {
        $user = User::factory()->admin()->create();
        User::factory()->count(2)->create();

        $this->actingAs($user)
            ->get(UserResource::getUrl('index'))
            ->assertOk();
    }

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_user(): void
    {
        $user = User::factory()->admin()->create();
        Order::factory()->paid()->for($user)->create();
        Order::factory()->for($user)->create();
        Donation::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $user]))
            ->assertOk();

        // Paid Orders
        $this->actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $user, 'activeRelationManager' => 0]))
            ->assertOk();

        // Reservations
        $this->actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $user, 'activeRelationManager' => 1]))
            ->assertOk();

        // Tickets
        $this->actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $user, 'activeRelationManager' => 2]))
            ->assertOk();

        // Donations
        $this->actingAs($user)
            ->get(UserResource::getUrl('view', ['record' => $user, 'activeRelationManager' => 3]))
            ->assertOk();
    }

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_user_create(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(UserResource::getUrl('create'))
            ->assertOk();
    }

    #[Test]
    public function can_edit_user_information()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'name' => 'Will Byers',
            'pronouns' => 'he/him',
            'email' => 'wbyers@hawkins.edu',
            'phone' => '5551231234',
        ]);

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('edit_information', data: [
                'name' => 'Willa Byers',
                'pronouns' => 'they/them',
                'email' => 'wbyers@hawkins.edu',
                'phone' => '5551231234',
            ])
            ->assertHasNoActionErrors();

        $this->assertSame('Willa Byers', $user->fresh()->name);
        $this->assertSame('they/them', $user->fresh()->pronouns);
    }

    #[Test]
    public function changing_email_invalidates_email()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'name' => 'Will Byers',
            'pronouns' => 'he/him',
            'email' => 'wbyers@hawkins.edu',
            'phone' => '5551231234',
        ]);

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('edit_information', data: [
                'name' => 'Will Byers',
                'pronouns' => 'he/him',
                'email' => 'wbyers@hawkinshigh.edu',
                'phone' => '5551231234',
            ])
            ->assertHasNoActionErrors();

        $this->assertSame('wbyers@hawkinshigh.edu', $user->fresh()->email);
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    #[Test]
    public function can_change_user_password()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('change_password', data: [
                'password' => 'Password1',
                'password_confirmation' => 'Password1',
            ])
            ->assertHasNoActionErrors();

        $this->assertTrue(Hash::check('Password1', $user->fresh()->password));
    }

    #[Test]
    public function can_edit_user_address()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create([
            'address' => [
                'line1' => '1456 Murkwood Ln',
                'line2' => '',
                'city' => 'Hawkins',
                'state' => 'IN',
                'zip' => '46041',
                'country' => 'United States',
            ],
        ]);

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('edit_address', data: [
                'address' => [
                    'line1' => '1456 Murkwood Ln',
                    'line2' => '',
                    'city' => 'Lenora Hills',
                    'state' => 'CA',
                    'zip' => '92346',
                    'country' => 'United States',
                ],
            ])
            ->assertHasNoActionErrors();

        $this->assertSame('Lenora Hills', $user->fresh()->address['city']);
        $this->assertSame('CA', $user->fresh()->address['state']);
        $this->assertSame('92346', $user->fresh()->address['zip']);
    }

    #[Test]
    public function can_impersonate_user()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('impersonate')
            ->assertHasNoActionErrors();

        $this->assertEquals($user->id, auth()->id());
    }

    #[Test]
    public function can_send_password_reset()
    {
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('send_password_reset')
            ->assertHasNoActionErrors()
            ->assertNotified();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    #[Test]
    public function can_manually_verify_email()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->unverified()->create();

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->callAction('manually_verify_user')
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    #[Test]
    public function manually_verify_user_is_hidden_when_already_verified()
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create();

        Livewire::actingAs($admin)
            ->test(ViewUser::class, ['record' => $user->getRouteKey()])
            ->assertActionHidden('manually_verify_user');
    }
}
