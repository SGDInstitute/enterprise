<?php

namespace Sgd\FormResponse;

use Laravel\Nova\Fields\Field;

class FormResponse extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'form-response';

    /**
     * Set the hues that may be selected by the color picker.
     *
     * @param  array  $form
     * @return $this
     */
    public function form($form = [])
    {
        return $this->withMeta(['form' => $form]);
    }
}
