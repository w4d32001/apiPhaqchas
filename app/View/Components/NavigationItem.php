<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavigationItem extends Component
{
     public $href;
    public $text;
    
    public function __construct($href, $text)
    {
        $this->href = $href;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.navigation-item');
    }
}
