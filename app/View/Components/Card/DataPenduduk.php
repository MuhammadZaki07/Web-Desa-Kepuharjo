<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataPenduduk extends Component
{

    public $class;
    public $id;
    public $dataPenduduk;
    /**
     * Create a new component instance.
     */
    public function __construct($class = '', $id = null, $dataPenduduk = [])
    {
        $this->class = $class;
        $this->id = $id;
        $this->dataPenduduk = $dataPenduduk;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.data-penduduk');
    }
}
