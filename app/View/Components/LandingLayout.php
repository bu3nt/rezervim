<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\Navigation;

class LandingLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $navigation = Navigation::where('status', 1)->orderBy('index', 'asc')->get();
        return view('layouts.landing', compact('navigation'));
    }
}
