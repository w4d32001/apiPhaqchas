<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SectionDeports extends Component
{
    public $sports;
    public function __construct($sports)
    {
        $this->sports = $sports;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.section-deports');
    }
}
