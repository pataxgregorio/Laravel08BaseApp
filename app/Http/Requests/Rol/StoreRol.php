<?php

namespace App\Http\Requests\Rol;

use Illuminate\Foundation\Http\FormRequest;

class StoreRol extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'name'        => 'min:3|max:50|required|string|unique:rols',
            'description' => 'min:3|max:80|required'
        ];        
    }

    public function messages(){
        return [
            'name.required' => trans('validacion_froms.rol.name_required'),
            'name.min' => trans('validacion_froms.rol.name_min'),
            'name.max' => trans('validacion_froms.rol.name_max'),
            'name.unique' => trans('validacion_froms.rol.name_unique'),
            'description.required' => trans('validacion_froms.rol.description_required'),
            'description.min' => trans('validacion_froms.rol.description_min'),
            'description.max' => trans('validacion_froms.rol.description_max'),
        ];
    }
}
