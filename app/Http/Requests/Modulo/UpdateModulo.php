<?php

namespace App\Http\Requests\Modulo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModulo extends FormRequest
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
            'description' => 'min:3|max:80|required'
        ];        
    }

    public function messages(){
        return [            
            'description.required' => trans('validacion_froms.modulo.description_required'),
            'description.min' => trans('validacion_froms.modulo.description_min'),
            'description.max' => trans('validacion_froms.modulo.description_max'),
        ];
    }
}
