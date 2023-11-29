<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerSkipToContentLink();
    }

    private function registerSkipToContentLink()
    {
        Filament::registerRenderHook(
            'styles.end',
            fn (): string => Blade::render(<<<'HTML'
                <style>
                    #skip-to-content a {
                        padding: 10px 15px 15px 10px;
                        position: absolute;
                        top: -100px;
                        left: 0;
                        color: white;
                        border-right: 1px solid #FFFFFF;
                        border-bottom: 1px solid #FFFFFF;
                        -webkit-transition: top 1s ease-out;
                        transition: top 1s ease-out;
                        z-index: 10000;
                    }

                    #skip-to-content a:focus {
                        position: absolute;
                        left: 0;
                        top: 0;
                        outline-color: transparent;
                        -webkit-transition: top 0.1s ease-in;
                        transition: top 0.1s ease-in;
                    }
                </style>
            HTML)
        );

        Filament::registerRenderHook(
            'body.start',
            fn (): string => Blade::render(<<<'HTML'
                <div id="skip-to-content">
                    <a class="bg-primary-500" href="#main-content">Skip to main content</a>
                </div>
            HTML)
        );

        Filament::registerRenderHook(
            'content.start',
            fn (): string => Blade::render('<div id="main-content"></div>')
        );

        TextInput::macro('money', function (): TextInput {
            /**
             * @var TextInput $this
             */
            $this->mask(RawJs::make(<<<'JS'
                $money($input)
            JS))
                ->prefix('$')
                ->suffix('.00');

            return $this;
        });
    }
}
