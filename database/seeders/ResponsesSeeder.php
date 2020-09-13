<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ResponsesSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = \App\Form::all();

        $forms->each(function ($form) {
            foreach (range(1, 100) as $item) {
                $form->responses()->create([
                    'responses' => $this->getResponses($form),
                    'request' => $this->getRequest(),
//                    'location'  => $this->getLocation(),
                ]);
            }
        });
    }

    private function getResponses($form)
    {
        $responses = [];
        foreach ($form->form as $index => $field) {
            if (! isset($field['type'])) {
                dd($form, $field);
            }
            if ($field['type'] === 'list' || $field['type'] === 'select') {
                $responses[$field['id']] = $field['choices'][array_rand($field['choices'], 1)];
            } elseif ($field['type'] === 'text') {
                $responses[$field['id']] = $this->faker->word;
            } elseif ($field['type'] === 'textarea') {
                $responses[$field['id']] = $this->faker->paragraph();
            } elseif ($field['type'] === 'opinion-scale') {
                $starting = ($field['start_at_one']) ? 1 : 0;
                $responses[$field['id']] = rand($starting, $field['max_value']);
            }
        }

        return $responses;
    }

    private function getRequest()
    {
        return ['USER' => $this->faker->userName, 'HTTP_USER_AGENT' => $this->faker->userAgent];
    }

    private function getLocation()
    {
        return geoip($this->faker->ipv4)->toArray();
    }
}
