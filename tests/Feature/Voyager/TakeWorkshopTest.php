<?php

namespace Tests\Feature\Voyager;

use App\Form;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class TakeWorkshopTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function cannot_take_workshop_form_without_being_logged_in()
    {
        $form = factory(Form::class)->create([
            'type' => 'workshop',
            'form' => [
                [
                    "id" => "hello-world",
                    "question" => "Hello world.",
                    "type" => "textarea",
                    "rules" => "required",
                ]
            ],
        ]);

        $response = $this->withoutExceptionHandling()
            ->json("POST", "/forms/{$form->id}/responses", [
                "hello-world" => "Foo Bar",
            ]);

        $response->assertStatus(401);
    }

    /** @test */
    function workshop_is_attached_to_user()
    {
        $user = factory(User::class)->create();
        $form = factory(Form::class)->create([
            'type' => 'workshop',
            'form' => [
                [
                    "id" => "hello-world",
                    "question" => "Hello world.",
                    "type" => "textarea",
                    "rules" => "required",
                ]
            ],
        ]);
        Passport::actingAs($user);

        $response = $this->actingAs($user)->withoutExceptionHandling()
            ->json("POST", "/forms/{$form->id}/responses", [
                "hello-world" => "Foo Bar",
            ]);

        $response->assertStatus(200);

        $this->assertNotNull($user->responses->where('form_id', $form->id)->first());
    }
}
