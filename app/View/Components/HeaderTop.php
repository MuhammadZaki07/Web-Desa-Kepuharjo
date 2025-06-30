<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderTop extends Component
{
    /**
     * Create a new component instance.
     */
    public $headlines;

    public function __construct($headlines)
    {
        $this->headlines = $headlines;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-top');
    }
}
