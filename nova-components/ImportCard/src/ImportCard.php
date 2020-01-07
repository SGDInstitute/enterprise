<?php

namespace Sgd\ImportCard;

use Laravel\Nova\Card;
use Laravel\Nova\Fields\File;

class ImportCard extends Card
{
    public $width = '1/3';

    public function __construct($resource)
    {
        parent::__construct();
        $this->withMeta([
            'fields' => [
                new File('File'),
            ],
            'resourceLabel' => $resource::label(),
            'resource' => $resource::uriKey(),
        ]);
    }

    public function withSample($sample)
    {
        return $this->withMeta(['sample' => $sample]);
    }

    public function component()
    {
        return 'import-card';
    }
}
