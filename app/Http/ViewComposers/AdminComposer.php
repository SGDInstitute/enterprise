<?php

namespace App\Http\ViewComposers;

use App\Models\Event;
use Illuminate\View\View;

class AdminComposer
{
    protected $events;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->events = Event::upcoming()->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('events', $this->events);
    }
}
