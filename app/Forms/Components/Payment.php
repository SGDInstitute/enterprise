<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class Payment extends Field
{
    protected string $view = 'forms.components.payment';

    protected $amount = null;
    protected $clientSecret = null;
    protected string $returnUrl = '';
    protected string $receiptEmail = '';
    protected array|Closure $appearance = [];
    protected array|Closure $options = [];

    public function amount($amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function clientSecret($clientSecret): static
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    public function returnUrl(string $returnUrl): static
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    public function receiptEmail(string $receiptEmail): static
    {
        $this->receiptEmail = $receiptEmail;

        return $this;
    }

    public function appearance(array|Closure|null $appearance): static
    {
        $this->appearance = $appearance;

        return $this;
    }

    public function options(array|Closure|null $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getAmount(): mixed
    {
        return $this->evaluate($this->amount);
    }

    public function getClientSecret(): mixed
    {
        return $this->evaluate($this->clientSecret);
    }

    public function getReturnUrl(): mixed
    {
        return $this->evaluate($this->returnUrl);
    }

    public function getReceiptEmail(): mixed
    {
        return $this->receiptEmail ?? auth()->user()->email;
    }

    public function getAppearance(): mixed
    {
        return $this->evaluate($this->appearance);
    }

    public function getOptions(): mixed
    {
        return $this->evaluate($this->options);
    }
}
