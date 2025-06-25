<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pengajuan extends Component
{
    /**
     * Create a new component instance.
     */

    public $profileDesa;
    public function __construct($profileDesa)
    {
        $this->profileDesa = $profileDesa;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pengajuan');
    }
}
