<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert_MSG extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // DE NECESITAR VARIABLES AL COMPONENTE, COLOQUELAS AQUÍ.
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert_msg');
    }
}
