<?php

namespace App\Http\Requests\Rol;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRol extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [            
            'description' => 'min:3|max:80|required'
        ];        
    }

    public function messages(){
        return [            
            'description.required' => trans('validacion_froms.rol.description_required'),
            'description.min' => trans('validacion_froms.rol.description_min'),
            'description.max' => trans('validacion_froms.rol.description_max'),
        ];
    }
}
