<?php

namespace App\Http\Livewire\Galaxy\Config\Donations;

use App\Models\Setting;
use Livewire\Component;
use Stripe\StripeClient;

class Page extends Component
{
    public $editPanel = false;
    public $type = 'monthly';
    public $otherAmount = false;
    public $newPrice;

    public $title;
    public $image;
    public $content;
    public $oneTimeOptions;
    public $monthlyOptions;

    public $rules = [
        'title.payload' => 'required',
        'image.payload' => 'required',
        'content.payload' => 'required',
    ];

    public function mount()
    {
        $this->title = $this->settings->firstWhere('name', 'title');
        $this->image = $this->settings->firstWhere('name', 'image');
        $this->content = $this->settings->firstWhere('name', 'content');
        $this->oneTimeOptions = $this->settings->firstWhere('name', 'onetime');
        $this->monthlyOptions = $this->settings->firstWhere('name', 'monthly');
    }

    public function render()
    {
        return view('livewire.galaxy.config.donations.page')
            ->with([
                'settings' => $this->settings,
            ]);
    }

    public function getPricesProperty()
    {
        return collect($this->stripe->prices->all()->data)->filter(function($price) {
            return !array_key_exists($price->id, $this->monthlyOptions->payload) && $price->type === 'recurring';
         });
    }

    public function getStripeProperty()
    {
        return new StripeClient(config('services.stripe.secret'));
    }

    public function getSettingsProperty()
    {
        return Setting::where('group', 'donations.page')->get();
    }

    public function addOption($type)
    {
        if($type === 'oneTimeOptions') {
            $options = $this->$type->payload;
            $options[] = $this->newPrice;
        } else {
            $options = $this->$type->payload;

            $existing = $this->prices->firstWhere('unit_amount', $this->newPrice * 100);
            if($existing) {
                $options[$existing->id] = $this->newPrice;
            } else {
                $price = $this->stripe->prices->create([
                    'unit_amount' => $this->newPrice * 100,
                    'currency' => 'usd',
                    'recurring' => ['interval' => 'month'],
                    'product_data' => [
                        'name' => 'Recurring Donation - $' . $this->newPrice,
                    ],
                ]);
                $options[$price->id] = $this->newPrice;
            }
        }

        $this->$type->payload = $options;
        $this->$type->save();
        $this->emit('notify', ['message' => 'Added ' . $this->newPrice, 'type' => 'success']);
        $this->reset('newPrice');
    }

    public function moveOption($type, $direction, $amount)
    {
        $options = $this->$type->payload;

        $this->$type->payload = array_shove($options, array_search($amount, $options), $direction);
        $this->$type->save();
    }

    public function removeOption($type, $amount)
    {
        $options = $this->$type->payload;

        unset($options[array_search($amount, $options)]);

        $this->$type->payload = $options;
        $this->$type->save();
        $this->emit('notify', ['message' => 'Removed ' . $amount, 'type' => 'success']);
    }

    public function saveImage()
    {
        $this->validate(['image.payload' => 'required|url'], ['required' => 'The image field is required', 'url' => 'The image field must be a url with the https://']);
        $this->image->save();
        $this->emit('notify', ['message' => 'Saved image.', 'type' => 'success']);
        $this->show(false);
    }

    public function saveContent()
    {
        $this->validate(['content.payload' => 'required'], ['required' => 'The content field is required']);
        $this->content->save();
        $this->emit('notify', ['message' => 'Saved content.', 'type' => 'success']);
        $this->show(false);
    }

    public function saveTitle()
    {
        $this->validate(['title.payload' => 'required'], ['required' => 'The title field is required']);
        $this->title->save();
        $this->emit('notify', ['message' => 'Saved title.', 'type' => 'success']);
        $this->show(false);
    }

    public function show($panel)
    {
        $this->editPanel = $panel;
    }
}
