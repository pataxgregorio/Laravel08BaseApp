<?php

namespace App\Http\Requests\Modulo;

use Illuminate\Foundation\Http\FormRequest;

class StoreModulo extends FormRequest
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
            'name'        => 'min:3|max:50|required|string|unique:modulos',
            'description' => 'min:3|max:80|required'
        ];        
    }

    public function messages(){
        return [
            'name.required' => trans('validacion_froms.modulo.name_required'),
            'name.min' => trans('validacion_froms.modulo.name_min'),
            'name.max' => trans('validacion_froms.modulo.name_max'),
            'name.unique' => trans('validacion_froms.modulo.name_unique'),
            'description.required' => trans('validacion_froms.modulo.description_required'),
            'description.min' => trans('validacion_froms.modulo.description_min'),
            'description.max' => trans('validacion_froms.modulo.description_max'),
        ];
    }
}
