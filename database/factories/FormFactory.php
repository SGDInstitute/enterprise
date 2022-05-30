<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Test form',
            'slug' => 'test-form',
            'type' => 'workshop',
        ];
    }

    public function preset($type)
    {
        if ($type === 'workshop') {
            return $this->state(function (array $attributes) {
                return [
                    'name' => $name = 'MBLGTACC ' . now()->format('Y') . ' Workshop Proposal',
                    'slug' => str($name)->slug(),
                    'type' => 'workshop',
                    'auth_required' => 0,
                    'form' =>  [
                        ['id' => 'question-name','type' => 'text','rules' => '','style' => 'question','question' => 'Name of Workshop (this can be updated/edited anytime)', ],
                        ['id' => 'question-attendance','type' => 'list','rules' => '','style' => 'question','options' => ['Virtually','In-person','Unsure at this time', ],'question' => 'How do you plan to attend the conference','list-style' => 'radio', ],
                        ['id' => 'question-presenting','type' => 'list','rules' => '','style' => 'question','options' => ['Virtually','In-person','This workshop could be done virtually or in-person', ],'question' => 'How do you plan to present you workshop?','list-style' => 'radio', ],
                        ['id' => 'question-virtual-experience','type' => 'textarea','rules' => '','style' => 'question','question' => 'What skills or experience do you have teaching, facilitating or training in a virtual format? ','conditions' => [ ['field' => 'question-presenting','value' => 'Virtually','method' => 'equals', ], ],'visibility' => 'conditional', ],
                        ['id' => 'question-virtual-approach','type' => 'textarea','rules' => '','style' => 'question','question' => 'How would you approach providing this workshop to a virtual-only audience in a way that differs from an in-person experience?','conditions' => [ ['field' => 'question-presenting','value' => 'Virtually','method' => 'equals', ], ],'visibility' => 'conditional', ],
                        ['id' => 'collaborators','style' => 'collaborators', ],
                        ['id' => 'question-description','help' => 'Be sure to mention your core topic, format of the session, intended audience, and what attendees will gain from the workshop. This is your opportunity to explain how you will use your workshop time and your approach to teaching on this topic. You may provide a written response or provide a link to a 3 minute video or audio file (we recommend an unlisted YouTube video).','type' => 'textarea','rules' => '','style' => 'question','question' => 'Describe your workshop.', ],
                        ['id' => 'question-tracks','help' => 'Please review the [full workshop track descriptions](https://mblgtacc.org/speakers-events/workshop-tracks) before making selections. Workshops are not required to align with a track and not all accepted workshops will be placed into a track.','type' => 'list','rules' => '','style' => 'question','options' => ['Doing the Work in Rural and Small Communities','Taking Care of Ourselves to Take Care of Others','Designing a Queer Future Through Media','Activism and Protest as Tools for Justice','Creating Change on College Campuses','Advisor Track','Virtual Track', ],'question' => 'Would your workshop fall under any of the following tracks?','list-style' => 'checkbox', ],
                        ['id' => 'question-experience','type' => 'text','rules' => '','style' => 'question','question' => 'What personal, academic, or advocacy experiences prepare you/your group to give this presentation?', ], ['id' => 'question-extra','type' => 'text','rules' => '','style' => 'question','question' => 'Is there anything else we should know about you and your presentation?', ],
                    ],
                    'settings' => ['searchable' => ['question-attendance', 'question-presenting', 'question-name', 'question-tracks'],]
                ];
            });
        }
    }
}
