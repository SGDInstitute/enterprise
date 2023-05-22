<?php

declare(strict_types=1);

namespace App\View\Components\UI;

use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(public string $search, public string $src = '', public string $provider = '', public string $fallback = '')
    {
    }

    public function render(): string
    {
        return <<<'blade'
            <img src="{{ $url() }}" {{ $attributes }}/>
        blade;
    }

    public function url(): string
    {
        if ($this->src) {
            return $this->src;
        }

        $query = http_build_query(array_filter([
            'fallback' => $this->fallback,
        ]));

        if ($this->provider) {
            return sprintf('https://unavatar.io/%s/%s?%s', $this->provider, $this->search, $query);
        }

        return sprintf('https://unavatar.io/%s?%s', $this->search, $query);
    }
}
