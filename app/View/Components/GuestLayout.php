<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public bool $hideToggle;
    public bool $hideClose;

    public function __construct(bool $hideToggle = false, bool $hideClose = false)
    {
        $this->hideToggle = $hideToggle;
        $this->hideClose = $hideClose;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
