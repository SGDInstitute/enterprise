<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Contracts\Support\Htmlable;
use Stripe\PaymentIntent;

class Payment extends Field
{
    protected string $view = 'forms.components.payment';

    protected array | \Closure $appearance = [];
    protected \Closure $calculateAmount;
    protected array | \Closure $options = [];
    protected string | Htmlable | null $submitAction = null;

    public function appearance(array | \Closure | null $appearance): static
    {
        $this->appearance = $appearance;

        return $this;
    }

    public function calculateAmount(\Closure | null $calculateAmount): static
    {
        $this->calculateAmount = $calculateAmount;

        return $this;
    }

    public function options(array | \Closure | null $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function submitAction(string | Htmlable | null $action): static
    {
        $this->submitAction = $action;

        return $this;
    }

    public function getAppearance(): mixed
    {
        return $this->evaluate($this->appearance);
    }

    public function getClientSecret(): mixed
    {
        return PaymentIntent::create([
            'amount' => $this->getCalculatedAmount(),
            'currency' => 'usd',
        ])->client_secret;
    }

    public function getCalculatedAmount(): mixed
    {
        return $this->evaluate($this->calculateAmount);
    }

    public function getOptions(): mixed
    {
        return $this->evaluate($this->options);
    }

    public function getSubmitAction(): string | Htmlable | null
    {
        return $this->submitAction;
    }
}
