<?php

namespace Tests\Feature\Livewire\App\Donations;

use App\Livewire\App\Donations\Create;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('http_happy_path')]
    public function can_view_create_donation_page()
    {
        $this->get(route('app.donations.create'))
            ->assertOk()
            ->assertSeeLivewire(Create::class);
    }

    #[Test]
    public function alert_is_visible_when_not_authenticated()
    {
        Livewire::test(Create::class)
            ->assertSee('authentication-alert');
    }

    #[Test]
    public function alert_is_visible_when_not_verified()
    {
        $user = User::factory()->unverified()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->assertSee('verification-alert');
    }

    #[Test]
    public function fields_are_disabled_when_not_authenticated()
    {
        Livewire::test(Create::class)
            ->assertFormFieldIsDisabled('type')
            ->assertFormFieldIsDisabled('amount')
            ->assertFormFieldIsDisabled('other_amount')
            ->assertFormFieldIsDisabled('search')
            ->assertFormFieldIsDisabled('address.line1')
            ->assertFormFieldIsDisabled('address.line2')
            ->assertFormFieldIsDisabled('address.city')
            ->assertFormFieldIsDisabled('address.state')
            ->assertFormFieldIsDisabled('address.zip')
            ->assertFormFieldIsHidden('payment');
    }

    #[Test]
    public function fields_are_disabled_when_not_verified()
    {
        $user = User::factory()->unverified()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->assertFormFieldIsDisabled('type')
            ->assertFormFieldIsDisabled('amount')
            ->assertFormFieldIsDisabled('other_amount')
            ->assertFormFieldIsDisabled('search')
            ->assertFormFieldIsDisabled('address.line1')
            ->assertFormFieldIsDisabled('address.line2')
            ->assertFormFieldIsDisabled('address.city')
            ->assertFormFieldIsDisabled('address.state')
            ->assertFormFieldIsDisabled('address.zip')
            ->assertFormFieldIsHidden('payment');
    }

    #[Test]
    public function other_amount_is_visible_when_amount_is_set_to_other()
    {
        $user = User::factory()->withAddress()->create();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->assertFormFieldIsHidden('other_amount')
            ->fillForm([
                'amount' => 'other',
            ])
            ->assertFormFieldIsVisible('other_amount');
    }

    #[Test]
    public function address_is_set_if_user_has_existing_one_saved()
    {
        $user = User::factory()->create([
            'address' => [
                'line1' => '123 Main',
                'line2' => 'Suite 2',
                'city' => 'Downers Grove',
                'state' => 'Illinois',
                'zip' => '60516',
            ],
        ]);

        Livewire::actingAs($user)
            ->test(Create::class)
            ->assertFormSet([
                'address.line1' => '123 Main',
                'address.line2' => 'Suite 2',
                'address.city' => 'Downers Grove',
                'address.state' => 'Illinois',
                'address.zip' => '60516',
            ]);;
    }
}
