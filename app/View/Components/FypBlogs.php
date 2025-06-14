<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FypBlogs extends Component
{
    /**
     * Create a new component instance.
     */

     public $viralBlogs;
    public function __construct($viralBlogs)
    {
        $this->viralBlogs = $viralBlogs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fyp-blogs');
    }
}
