<?php

use Illuminate\Database\Seeder;

class MBLGTACC2017ResposesSeeder extends Seeder
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
        $survey = \App\Form::where('name', 'MBLGTACC 2017 Converence Evaluation')->first();

        foreach (range(1, 100) as $item) {
            $survey->responses()->create([
                'responses' => $this->getResponses($survey),
                'request'   => $this->getRequest(),
                'location'  => $this->getLocation(),
            ]);
        }
    }

    private function getResponses($survey)
    {
        $responses = [];
        foreach ($survey->form as $index => $field) {
            if ($field['type'] === 'list' || $field['type'] === 'select') {
                $responses[$field['id']] = $field['choices'][array_rand($field['choices'], 1)];
            } elseif ($field['type'] === 'text') {
                $responses[$field['id']] = $this->faker->word;
            } elseif ($field['type'] === 'textarea') {
                $responses[$field['id']] = $this->faker->paragraph();
            } elseif ($field['type'] === 'opinion-scale') {
                $starting = ($field['startAtOne']) ? 1 : 0;
                $responses[$field['id']] = rand($starting, $field['maxValue']);
            }
        }

        return $responses;
    }

    private function getRequest()
    {
        return ["USER" => $this->faker->userName, "HTTP_USER_AGENT" => $this->faker->userAgent];
    }

    private function getLocation()
    {
        return geoip($this->faker->ipv4)->toArray();
    }
}
