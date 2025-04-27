<?php

namespace App\View\Components\Chart;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MixedChart extends Component
{
    public $id;
    public $series1Data;
    public $series2Data;
    public $categories;
    public $series1Name;
    public $series2Name;
    public $yAxisTitle;

    public function __construct(
        $id,
        $series1Data = [],
        $series2Data = [],
        $categories = [],
        $series1Name = 'Column',
        $series2Name = 'Line',
        $yAxisTitle = 'Values'
    ) {
        $this->id = $id;
        $this->series1Data = $series1Data;
        $this->series2Data = $series2Data;
        $this->categories = $categories;
        $this->series1Name = $series1Name;
        $this->series2Name = $series2Name;
        $this->yAxisTitle = $yAxisTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart.mixed-chart');
    }
}
