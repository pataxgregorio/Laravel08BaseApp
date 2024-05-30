<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Boton_Back extends Component
{
    public string $ruta;
    public string $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $ruta,string $color)
    {
        $this->ruta = $ruta;
        $this->ruta = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.boton_back');
    }
}
