<?php

namespace Database\Seeders;

use App\Models\DonationPlan;
use App\Models\Event;
use App\Models\Form;
use App\Models\Price;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create(['name' => 'Andy Newhouse', 'email' => 'andy@sgdinstitute.org'])->assignRole('institute');
        User::factory()->create(['name' => 'Justin Drwencke', 'email' => 'justin@sgdinstitute.org'])->assignRole('institute');

        $mblgtacc = Event::factory()->preset('mblgtacc')->create(['name' => 'MBLGTACC 2021', 'location' => 'Madison, WI', 'timezone' => 'America/Chicago']);
        Form::factory()->create([
            'name' => 'MBLGTACC 2021 Workshop Proposal',
            'type' => 'workshop',
            'event_id' => $mblgtacc->id,
            'auth_required' => 1,
            'start' => '2021-04-01 07:25:00',
            'end' => '2021-07-15 07:25:00',
            'timezone' => 'America/Chicago',
            'form' => [
                ["id" => "content-overview", "style" => "content", "content" => "<div><strong>Overview:</strong></div>"],
                ["id" => "name", "type" => "text", "rules" => "required", "style" => "question", "question" => "What is the name of the workshop?"],
                ["id" => "question-description", "type" => "textarea", "rules" => "required", "style" => "question", "question" => "Please describe your workshop. Please explain how you will use your hour, and what you hope participants learn."],
                ["id" => "question-style", "type" => "list", "rules" => "required", "style" => "question", "options" => ["Interactive Discussion", "Panel Discussion", "Training", "Demonstration", "Performance", "Presentation"], "question" => "Workshop Style", "list-other" => true, "list-style" => "checkbox"],
                ["id" => "collaborators", "style" => "collaborators"],
                ["id" => "content-theme", "style" => "content", "content" => "<div><strong>Theme</strong>:</div><div>This year’s theme is ‘From Protest and Beyond Pride.’ It is a commemoration to foundational protests in LGBTQ+ history and its connection to our current and emerging climate. We are interested in honoring the past and co-creating better futures for us all.</div>"],
                ["id" => "question-theme", "type" => "textarea", "rules" => "required", "style" => "question", "question" => "How do you feel your workshop contributes to the theme of this year’s conference?"],
                ["id" => "question-pillars", "type" => "list", "rules" => "required", "style" => "question", "options" => ["Action / Activism ", "LGBTQ+ Health & Well Being / Communities of Care ", "Queer Enough / Authentication / Celebration", "Queer Histories", "Solidarity / Collectivity / International / inter-generational connections"], "question" => "Please check which one of this year’s pillars your workshop best connects with:", "list-style" => "radio"],
                ["id" => "content-experience", "style" => "content", "content" => "<div><strong>Experience:</strong></div>"],
                ["id" => "question-attendance", "type" => "list", "rules" => "", "style" => "question", "options" => ["Yes", "No"], "question" => "Have you attended MBLGTACC before?", "list-style" => "radio"],
                ["id" => "question-presented", "type" => "list", "rules" => "required", "style" => "question", "options" => ["Yes", "No"], "question" => "Have you presented at MBLGTACC before?", "list-style" => "radio"],
                ["id" => "question-presented-years", "type" => "textarea", "rules" => "required_if:question-presented,Yes", "style" => "question", "question" => "What year(s) did you present?", "conditions" => [["field" => "question-presented", "value" => "Yes", "method" => "equals"]], "visibility" => "conditional", "visibility-andor" => "and"],
                ["id" => "question-presented-content", "type" => "textarea", "andor" => "and", "rules" => "required_if:question-presented,Yes", "style" => "question", "question" => "What did you present on?", "conditions" => [["field" => "question-presented", "value" => "Yes", "method" => "equals"]], "visibility" => "conditional", "visibility-andor" => "and"],
                ["id" => "question-experience", "type" => "textarea", "rules" => "required", "style" => "question", "question" => "What personal, academic, or advocacy experience prepares you to give this presentation? Please describe the presenters’ previous experience with this topic."],
                ["id" => "content-tracks", "style" => "content", "content" => "<div>MBLGTACC 2021 will be available to participants who are both online and in person. Dedicated staff will assist presenters navigating online platforms.</div>"],
                ["id" => "question-modality", "type" => "list", "rules" => "required", "style" => "question", "options" => ["in-person:I want/need to present my workshop in-person", "online:I want/need to present my workshop online", "no-preference:I have no preference for how my workshop is provided "], "question" => "Workshop Modality Preference", "list-style" => "radio"],
                ["id" => "question-in-person-needs", "type" => "list", "rules" => "", "style" => "question", "options" => ["Projector and screen", "Audio/speakers", "Video (Laptop for hybrid modality?)"], "question" => "Which of the following will you need for your presentation?", "conditions" => [["field" => "question-modality", "value" => "in-person", "method" => "equals"], ["field" => "question-modality", "value" => "no-preference", "method" => "equals"]], "list-other" => true, "list-style" => "checkbox", "visibility" => "conditional", "visibility-andor" => "or"],
                ["id" => "question-streamed", "type" => "list", "rules" => "", "style" => "question", "options" => ["Yes", "No"], "question" => "Are you comfortable having your presentation streamed online for virtual conference attendees?", "list-style" => "radio"],
                ["id" => "question-recording", "type" => "list", "rules" => "", "style" => "question", "options" => ["My presentation can be streamed/hosted for the conference", "Please do not stream/host my presentation; I will provide resources"], "question" => "We will keep a recording online behind a protected link only for the duration of the conference. If you are not comfortable having it streamed/hosted, we will ask you later to provide resources for virtual attendees on your topic.", "list-style" => "radio"],
                ["id" => "question-virtually-experience", "type" => "list", "rules" => "", "style" => "question", "options" => ["Yes", "No"], "question" => "Have you presented virtually before?", "conditions" => [["field" => "question-modality", "value" => "online", "method" => "equals"]], "list-style" => "radio", "visibility" => "conditional", "visibility-andor" => "and"],
                ["id" => "question-other-info", "type" => "textarea", "rules" => "", "style" => "question", "question" => "Is there anything else we should know about you or your presentation?"]
            ]
        ]);
        $inPerson = TicketType::create(['event_id' => $mblgtacc->id, 'stripe_product_id' => 'prod_JMv3xouI9pZ6Vp', 'name' => 'In-person Attendee', 'structure' => 'flat', 'start' => '2021-04-01 22:34:00', 'end' => '2021-10-10 22:33:00', 'timezone' => 'America/Chicago']);
        $inPerson->prices()->create(['name' => 'Regular', 'stripe_price_id' => 'price_1IkBDgI7BmcylBPU2P1RSoKR', 'cost' => 8500, 'start' => '2021-04-26 00:00:00', 'end' => '2021-10-08 04:59:59', 'timezone' => 'America/Chicago']);
        $inPerson->prices()->create(['name' => 'On-site', 'stripe_price_id' => 'price_1IkBDgI7BmcylBPUqQuVAmdm', 'cost' => 10000, 'start' => '2021-10-08 05:00:00', 'end' => '2021-10-10 22:33:00', 'timezone' => 'America/Chicago']);
        $virtual = TicketType::create(['event_id' => $mblgtacc->id, 'stripe_product_id' => 'prod_JNBpBhNjaW37YD', 'name' => 'Virtual Attendee', 'description' => 'We recommend individuals purchasing virtual tickets pay $25-50 to attend and institutions sponsoring students to attend pay $35-60 per person.', 'structure' => 'scaled-range', 'start' => '2021-04-01 22:34:00', 'end' => '2021-10-10 22:33:00', 'timezone' => 'America/Chicago']);
        $virtual->prices()->createMany([
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUhBM75qvO', 'cost' => 2500, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUyZ7MGcZX', 'cost' => 3000, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUhR1jjuO6', 'cost' => 3500, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPU7vwVbKcV', 'cost' => 4000, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUkjpHFDKg', 'cost' => 4500, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUFzSZ1d1h', 'cost' => 5000, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUdZkm5sC6', 'cost' => 5500, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
            ['name' => 'Sliding Scale', 'stripe_price_id' => 'price_1IkRS0I7BmcylBPUTJQmXEzY', 'cost' => 6000, 'start' => '2021-04-01 22:34:00', 'end' => '2021-04-25 22:34:00', 'timezone' => 'America/Chicago'],
        ]);

        $tjt = Event::factory()->preset('tjt')->create();

        DonationPlan::factory()->create(['stripe_product_id' => 'prod_BVDuBxx2x4AiyF', 'stripe_price_id' => 'monthly-15', 'name' => '$15/month', 'cost' => 1500]);
    }
}
