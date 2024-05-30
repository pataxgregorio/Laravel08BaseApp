<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\View\Components;

use Illuminate\View\Component;

class button extends Component{

    public string $titulo_modulo;
    public string $router_modulo_create;
    public string $id_new_modulo;
    public string $boton_crear;
    public string $route_print;
    public string $route_download;
    public string $route_upload;
    public string $tooltip;
    public string $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $titulo_modulo, string $router_modulo_create, string $id_new_modulo, 
                                string $boton_crear, string $route_print, string $route_download, 
                                string $route_upload, string $tooltip,string $color)
    {
        $this->titulo_modulo = $titulo_modulo;
        $this->$router_modulo_create = $router_modulo_create;
        $this->id_new_modulo = $id_new_modulo;
        $this->boton_crear = $boton_crear;
        $this->route_print = $route_print;
        $this->route_download = $route_download;
        $this->route_upload = $route_upload;
        $this->tooltip = $tooltip;
        $this->ruta = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(){
        return view('components.button');
    }
}
