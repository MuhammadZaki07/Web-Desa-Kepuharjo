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
    public $tanggal, $jam, $format, $headlines;

    public function __construct($tanggal, $jam, $format, $headlines)
    {
        $this->tanggal = $tanggal;
        $this->jam = $jam;
        $this->format = $format;
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
