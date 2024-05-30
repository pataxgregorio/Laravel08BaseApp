<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest{
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
        if($this->id_user == '1'){
            return [
                'password' => 'required|min:8|max:15',                
            ];
        }else{
            if($this->rols_id == '1'){
                return [
                    'name'     => 'min:8|max:40|required|string',            
                    'password' => 'required|min:8|max:15',
                    'activo'   => 'required',
                    'rols_id'  => 'required',
                    'init_day' => 'required',
                    'end_day'  => 'required|after_or_equal:init_day'
                ];
            }else{
                return [
                    'name'     => 'min:8|max:40|required|string',            
                    'password' => 'required|min:8|max:15',                    
                ];
            }            
        }        
    }

    public function messages(){
        if($this->id_user == '1'){
            return [                
                'password.required' => trans('validacion_froms.user.password_required'),
                'password.min' => trans('validacion_froms.user.password_min'),
                'password.max' => trans('validacion_froms.user.password_max'),
            ];
        }else{
            if($this->rols_id == '1'){
                return [
                    'name.required' => trans('validacion_froms.user.name_required'),
                    'name.min' => trans('validacion_froms.user.name_min'),
                    'name.max' => trans('validacion_froms.user.name_max'),
                    'password.required' => trans('validacion_froms.user.password_required'),
                    'password.min' => trans('validacion_froms.user.password_min'),
                    'password.max' => trans('validacion_froms.user.password_max'),
                    'activo.required' => trans('validacion_froms.user.activo_required'),
                    'rols_id.required' => trans('validacion_froms.user.rols_id_required'),
                    'init_day.required' => trans('validacion_froms.user.init_day_required'),
                    'end_day.required' => trans('validacion_froms.user.end_day_required'),
                    'end_day.after_or_equal' => trans('validacion_froms.user.end_day_after_or_equal'),
                ];
            }else{
                return [
                    'name.required' => trans('validacion_froms.user.name_required'),
                    'name.min' => trans('validacion_froms.user.name_min'),
                    'name.max' => trans('validacion_froms.user.name_max'),
                    'password.required' => trans('validacion_froms.user.password_required'),
                    'password.min' => trans('validacion_froms.user.password_min'),
                    'password.max' => trans('validacion_froms.user.password_max'),                    
                ];
            }            
        }        
    }
}
