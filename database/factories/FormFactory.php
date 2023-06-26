<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => 'Test form',
            'slug' => 'test-form',
            'type' => 'workshop',
            'start' => now()->subDay(),
            'end' => now()->addDay(),
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
                    'form' => [
                        ['id' => 'question-name', 'type' => 'text', 'rules' => '', 'style' => 'question', 'question' => 'Name of Workshop (this can be updated/edited anytime)'],
                        ['id' => 'question-attendance', 'type' => 'list', 'rules' => '', 'style' => 'question', 'options' => ['Virtually', 'In-person', 'Unsure at this time'], 'question' => 'How do you plan to attend the conference', 'list-style' => 'radio'],
                        ['id' => 'question-presenting', 'type' => 'list', 'rules' => '', 'style' => 'question', 'options' => ['Virtually', 'In-person', 'This workshop could be done virtually or in-person'], 'question' => 'How do you plan to present you workshop?', 'list-style' => 'radio'],
                        ['id' => 'question-virtual-experience', 'type' => 'textarea', 'rules' => '', 'style' => 'question', 'question' => 'What skills or experience do you have teaching, facilitating or training in a virtual format? ', 'conditions' => [['field' => 'question-presenting', 'value' => 'Virtually', 'method' => 'equals']], 'visibility' => 'conditional'],
                        ['id' => 'question-virtual-approach', 'type' => 'textarea', 'rules' => '', 'style' => 'question', 'question' => 'How would you approach providing this workshop to a virtual-only audience in a way that differs from an in-person experience?', 'conditions' => [['field' => 'question-presenting', 'value' => 'Virtually', 'method' => 'equals']], 'visibility' => 'conditional'],
                        ['id' => 'collaborators', 'style' => 'collaborators'],
                        ['id' => 'question-description', 'help' => 'Be sure to mention your core topic, format of the session, intended audience, and what attendees will gain from the workshop. This is your opportunity to explain how you will use your workshop time and your approach to teaching on this topic. You may provide a written response or provide a link to a 3 minute video or audio file (we recommend an unlisted YouTube video).', 'type' => 'textarea', 'rules' => '', 'style' => 'question', 'question' => 'Describe your workshop.'],
                        ['id' => 'question-tracks', 'help' => 'Please review the [full workshop track descriptions](https://mblgtacc.org/speakers-events/workshop-tracks) before making selections. Workshops are not required to align with a track and not all accepted workshops will be placed into a track.', 'type' => 'list', 'rules' => '', 'style' => 'question', 'options' => ['Doing the Work in Rural and Small Communities', 'Taking Care of Ourselves to Take Care of Others', 'Designing a Queer Future Through Media', 'Activism and Protest as Tools for Justice', 'Creating Change on College Campuses', 'Advisor Track', 'Virtual Track'], 'question' => 'Would your workshop fall under any of the following tracks?', 'list-style' => 'checkbox'],
                        ['id' => 'question-experience', 'type' => 'text', 'rules' => '', 'style' => 'question', 'question' => 'What personal, academic, or advocacy experiences prepare you/your group to give this presentation?'], ['id' => 'question-extra', 'type' => 'text', 'rules' => '', 'style' => 'question', 'question' => 'Is there anything else we should know about you and your presentation?'],
                    ],
                    'settings' => ['searchable' => ['question-attendance', 'question-presenting', 'question-name', 'question-tracks']],
                ];
            });
        }
        if ($type === 'new-workshop') {
            return $this->state(function (array $attributes) {
                return [
                    'name' => $name = 'MBLGTACC ' . now()->format('Y') . ' Workshop Proposal',
                    'slug' => str($name)->slug(),
                    'type' => 'workshop',
                    'auth_required' => 0,
                    'form' => [
                        [
                            'data' => [
                                'id' => 'timeline-information',
                                'content' => '<h2>Application Timeline</h2><ul><li>May 22 - proposals due</li><li>June 23 - presenters notified of acceptance</li><li>July 21 - deadline for accepted presenters to confirm attendance</li><li>August 25 - presenters notified of workshop schedule</li><li>September 1 - final titles and descriptions due</li><li>October 20 - deadline to submit copies of presenter materials (slideshows, etc.) to conference staff</li></ul>',
                            ],
                            'type' => 'content',
                        ],
                        [
                            'data' => [
                                'id' => 'session-information',
                                'content' => '<h2>Proposal Details</h2><p>In this section, please provide some information about your proposed workshop including the name of your workshop, a brief description, who is presenting, and what times you are available to present.</p>',
                            ],
                            'type' => 'content',
                        ],
                        [
                            'data' => [
                                'id' => 'name',
                                'help' => 'This can be updated/edited at a later date',
                                'type' => 'text',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'Name of Workshop',
                                'conditions' => [
                                    'c0b27803-e486-44ca-bd61-5c08abdf8afc' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => true,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'description',
                                'help' => 'This will be printed in the conference program. You’ll have a chance to edit this later.',
                                'type' => 'textarea',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'Provide a 75 word summary of your workshop.',
                                'conditions' => [
                                    '992d0595-d788-4121-aafd-7777389780f1' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => true,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'session',
                                'help' => 'You’ll have a chance to edit this later.',
                                'type' => 'list',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                    'breakout-1' => 'Saturday, Nov. 4, 9:00-10:15 a.m.',
                                    'breakout-2' => 'Saturday, Nov, 4, 10:45 a.m.-12:00 p.m.',
                                    'breakout-4' => 'Saturday, Nov. 4, 3:45-5:00 p.m.',
                                    'breakout-6' => 'Sunday, Nov. 5, 10:45 a.m.-12:00 p.m.',
                                ],
                                'question' => 'Which time(s) are you available to present at?',
                                'conditions' => [
                                    '5b5c8f9e-5712-449f-9beb-86e60d2a54b1' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => 'checkbox',
                                'visibility' => null,
                                'option-data' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => true,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'collaborators',
                            ],
                            'type' => 'collaborators',
                        ],
                        [
                            'data' => [
                                'id' => 'format',
                                'help' => null,
                                'type' => 'list',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                    'identity' => 'Identity Forum (Ex: a closed group for queer folks in STEM)',
                                    'discussion' => 'Facilitated Discussion (Ex: leading a group conversation about campus policy)',
                                    'interactive' => 'Interactive Activity (Ex: Skill Share, heavy group involvement, Crafts/Art)',
                                    'presentation' => 'Presentation (Ex: lecture, presenting research)',
                                ],
                                'question' => 'Which format best describes your workshop? ',
                                'conditions' => [
                                    '8a0369fd-c15d-4ad9-aee4-4b495dcd797f' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => 'radio',
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'content-outline',
                                'content' => '<h2>Detailed Description</h2><p>In this section, please provide a thorough outline of your workshop idea, identify which (if any) tracks your workshop relates to, and highlight your experience(s) relating to this workshop. This is your opportunity to explain how you will use your workshop time and your approach to teaching on this topic.</p><p>Some key items to mention:</p><ul><li>how your session contributes to this year’s theme: “Queer Joy as Our Lasting Legacy”</li><li>the topic of your session</li><li>intended audience (ex: students, any/all, advisors)&nbsp;</li><li>any potential videos, media, resources or other tools you might use in your presentation&nbsp;</li><li>what you hope attendees will learn from your session</li></ul>',
                            ],
                            'type' => 'content',
                        ],
                        [
                            'data' => [
                                'id' => 'outline-method',
                                'help' => 'We offer these options for those who may feel more confident providing an outline in either a written format or a verbalized/oral format.',
                                'type' => 'list',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                    'text' => 'Written Outline',
                                    'video' => 'Video/Audio Recording',
                                ],
                                'question' => 'How would you like to submit your outline?',
                                'conditions' => [
                                    '417b0f23-4d08-4759-90c6-c08a58a9273b' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => 'radio',
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'outline-method-option-video',
                                'help' => 'Provide a link',
                                'type' => 'text',
                                'other' => false,
                                'rules' => 'required_if:outline-method,video',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'Video/Audio Recording',
                                'conditions' => [
                                    0 => [
                                        'field' => 'outline-method',
                                        'value' => 'video',
                                        'method' => 'equals',
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => 'conditional',
                                'visibility-andor' => 'and',
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'outline-method-option-text',
                                'help' => null,
                                'type' => 'rich-editor',
                                'other' => false,
                                'rules' => 'required_if:outline-method,text',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'Written Outline',
                                'conditions' => [
                                    0 => [
                                        'field' => 'outline-method',
                                        'value' => 'text',
                                        'method' => 'equals',
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => 'conditional',
                                'visibility-andor' => 'and',
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'track-first-choice',
                                'help' => 'If none apply, click “General Session”',
                                'type' => 'list',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                    1 => 'media:Art, Media & Design',
                                    2 => 'college:Change on College Campuses',
                                    3 => 'activism:Justice - Activism & Protest',
                                    4 => 'rural:Small-town Queerness',
                                    5 => 'care:Self and Community Care',
                                    6 => 'advisor:Advisor Track',
                                    7 => 'general:General Session',
                                ],
                                'question' => 'Workshops will be considered for inclusion in either one of six tracks or as a general session. What workshop track does your workshop MOST align with?',
                                'conditions' => [
                                    'df20c2d2-841b-4635-8c54-38f4e731d71c' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => 'radio',
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'track-second-choice',
                                'help' => 'If none apply, click “General Session”',
                                'type' => 'list',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                    1 => 'media:Art, Media & Design',
                                    2 => 'college:Change on College Campuses',
                                    3 => 'activism:Justice - Activism & Protest',
                                    4 => 'rural:Small-town Queerness',
                                    5 => 'care:Self and Community Care',
                                    6 => 'advisor:Advisor Track',
                                    7 => 'general:General Session',
                                ],
                                'question' => 'Is there an additional track your workshop closely aligns with?',
                                'conditions' => [
                                    'b4b35288-ac4b-44c1-a63a-08e7c49745de' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => 'radio',
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'experience',
                                'help' => 'Ex: lived experiences, extensive work or research around this topic, previous presentations, occupation, etc.',
                                'type' => 'textarea',
                                'other' => false,
                                'rules' => 'required',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'What personal, academic, and/or advocacy experiences prepare you/your group to give this presentation?',
                                'conditions' => [
                                    'c7d8ec61-1aed-44e1-9a17-a20e1413d4ad' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'other',
                                'help' => null,
                                'type' => 'textarea',
                                'other' => false,
                                'rules' => 'nullable',
                                'scale' => null,
                                'options' => [
                                ],
                                'question' => 'Is there anything else we should know about you and your presentation?',
                                'conditions' => [
                                    'f34211f7-4522-4489-af4d-66eaf227b2e4' => [
                                        'field' => null,
                                        'value' => null,
                                        'method' => null,
                                    ],
                                ],
                                'list-style' => null,
                                'visibility' => null,
                                'visibility-andor' => null,
                                'editable_after_submission' => false,
                            ],
                            'type' => 'question',
                        ],
                        [
                            'data' => [
                                'id' => 'presenter-guidelines',
                                'content' => '<h2>Presenter Guidelines</h2><p>If you are accepted to present at MBLGTACC 2023, you will be expected to abide by certain guidelines. Please be sure to review these and let us know if you have any questions by emailing <a href="mailto:hello@sgdinstitute.org">hello@sgdinstitute.org</a>.</p><p><strong>Communication</strong></p><p>We will provide updates and important information via the email you provided in your workshop submission. Please be attentive to your email and be mindful of any communicated due dates.</p><p><strong>Accessibility</strong></p><p>We trust presenters to aid us in curating an accessible environment for all attendees. We will provide as much guidance and support as possible to equip presenters with accessibility tools for their workshops. This is not an exhaustive list, but we would like to emphasize these simple ways to enhance the accessibility of your workshop:&nbsp;</p><ul><li>Use Google Slides to build your presentation and check for color contrast and readability. Check out <a href="https://accessibility.oit.ncsu.edu/google-slides/">IT Accessibility: Google Slides</a> for more info on accessible slides.</li><li>Always use a microphone while presenting. Each workshop room is equipped with a microphone. Also, repeat any attendee questions into the microphone for those who may have missed it.</li><li>If you’re using Google Slides, enable the captions function&nbsp;</li><li>If you’re using slides or images, describe the content while presenting. For example, “This photo shows five people laughing” or “This is the Midwest Institute logo”&nbsp;</li><li>If there is text on the screen, read it out loud. And be mindful of the font size for all text in your presentation materials. Fancy fonts or text that is too small can be difficult to process.&nbsp;</li></ul><p>We welcome additional recommendations you have discovered that we could share out to all presenters. <br><br><strong>Preparedness</strong></p><p>MBLGTACC is a stepping stone for queer and trans presenters who use their experience of presenting to launch into careers in education, public speaking, entertainment, community organizing, and more! We want to support you in feeling confident, comfortable and prepared to present your exciting workshop idea.<br><br>In mid-September, we’ll provide more details about a Presenter Orientation hosted via Zoom. This will be an opportunity for you to ask questions as you put the finishing touches on your workshop materials.&nbsp;<br><br>We will be requesting digital copies of presentation materials (ex: presentation slides, handouts, worksheets, video clips, etc) by October 20. Presentation content collected will only be used for internal purposes such as reviewing content for compliance with the Code for Inclusion. More details about this process will be provided closer to the submission deadline.</p>',
                            ],
                            'type' => 'content',
                        ],
                    ],
                    'settings' => ['searchable' => ['question-attendance', 'question-presenting', 'question-name', 'question-tracks']],
                ];
            });
        }
    }

    public function current()
    {
        return $this->state([
            'start' => now()->subDay(),
            'end' => now()->addDay(),
        ]);
    }

    public function future()
    {
        return $this->state([
            'start' => now()->addMonth(),
            'end' => now()->addMonth()->addDays(2),
        ]);
    }

    public function past()
    {
        return $this->state([
            'start' => now()->subMonth(),
            'end' => now()->subMonth()->addDays(2),
        ]);
    }
}
