<?php
/**
* Realizado por @author Tarsicio Carrizales Septiembre 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\View\Components;

use Illuminate\View\Component;

class Ventana_Modal extends Component
{
    public string $id_modal;
    public string $windows_title;
    public string $id_body_modal;
    public string $modal_footer_close;
    public string $size_windows;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $id_modal, string $windows_title, 
                                string $id_body_modal, string $modal_footer_close, string $size_windows){
        $this->id_modal = $id_modal;
        $this->windows_title = $windows_title;
        $this->id_body_modal = $id_body_modal;
        $this->modal_footer_close = $modal_footer_close;
        $this->$size_windows = $size_windows;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(){
        return view('components.ventana_modal');
    }
}
