<?php

namespace Tests\Feature\Livewire\App\Dashboard;

use App\Livewire\App\Dashboard\Donations;
use App\Livewire\App\Dashboard\Settings;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SettingsTest extends TestCase
{
    use RefreshDatabase;


    #[Test]
    public function can_see_profile_form()
    {
        $user = User::factory()->create([
            'name' => 'Monkey D. Luffy',
            'email' => 'luffy@strawhats.pirate',
            'pronouns' => 'he/him',
        ]);

        Livewire::actingAs($user)
            ->test(Settings::class)
            ->assertFormSet([
                'name' => 'Monkey D. Luffy',
                'email' => 'luffy@strawhats.pirate',
                'pronouns' => 'he/him',
            ], 'profileForm');
    }

    #[Test]
    public function can_update_profile_information()
    {
        $user = User::factory()->create([
            'name' => 'Monkey D. Luffy',
            'email' => 'luffy@strawhats.pirate',
            'pronouns' => 'he/him',
        ]);

        Livewire::actingAs($user)
            ->test(Settings::class)
            ->fillForm([
                'name' => 'Capitan Monkey D. Luffy',
                'email' => 'luffy@straw-hat.pirate',
                'pronouns' => 'he/him',
            ], 'profileForm')
            ->call('saveProfile');

        $user->refresh();
        $this->assertSame('Capitan Monkey D. Luffy', $user->name);
        $this->assertSame('luffy@straw-hat.pirate', $user->email);
        $this->assertSame('he/him', $user->pronouns);
    }

    #[Test]
    public function updating_email_invalidates_email()
    {
        $user = User::factory()->create([
            'email' => 'luffy@strawhats.pirate',
            'pronouns' => 'he/him',
        ]);

        $this->assertNotNull($user->email_verified_at);

        Livewire::actingAs($user)
            ->test(Settings::class)
            ->fillForm([
                'email' => 'luffy@straw-hat.pirate',
            ], 'profileForm')
            ->call('saveProfile');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    #[Test]
    public function can_update_password()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Settings::class)
            ->fillForm([
                'current_password' => 'password',
                'password' => 'Password1',
                'password_confirmation' => 'Password1',
            ], 'passwordForm')
            ->call('savePassword');

        $this->assertTrue(Hash::check('Password1', $user->fresh()->password));
    }
}
