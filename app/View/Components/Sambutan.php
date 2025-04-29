<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sambutan extends Component
{
    /**
     * Create a new component instance.
     */

     public $id;
     public $class;
    public function __construct($class,$id)
    {
        $this->class = $class;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sambutan');
    }
}
