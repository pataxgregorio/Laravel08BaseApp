<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Box extends Component
{
    public string $titulo;

    public int $cantidad;

    public string $name;

    public string $color;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $titulo, int $cantidad = 0,
                                string $name,string $color = '')
    {
        $this->titulo = $titulo;
        $this->cantidad = $cantidad;
        $this->name = $name;
        $this->color = $color;
        
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.box');
    }
}
