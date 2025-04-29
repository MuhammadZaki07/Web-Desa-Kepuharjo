<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PengurusDesa extends Component
{
    /**
     * Create a new component instance.
     */

     public $pengurusDesa;
    public function __construct($pengurusDesa)
    {
        $this->pengurusDesa = $pengurusDesa;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pengurus-desa');
    }
}
