<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VisiMisi extends Component
{
    /**
     * Create a new component instance.
     */
    public $class;
    public $visi;
    public $misi;
    public function __construct($class = "", $visi = "", $misi = [])
    {
        $this->class = $class;
        $this->misi = $misi;
        $this->visi = $visi;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.visi-misi');
    }
}
