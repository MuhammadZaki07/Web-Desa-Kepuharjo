<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LatestInformation extends Component
{
    /**
     * Create a new component instance.
     */

    public $blogs;
    public $viralBlogs;
    public function __construct($blogs, $viralBlogs)
    {
        $this->blogs = $blogs;
        $this->viralBlogs = $viralBlogs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.latest-information');
    }
}
