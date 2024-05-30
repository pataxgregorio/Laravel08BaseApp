<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
*/
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest{
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
            'name'     => 'min:8|max:40|required|string',
            'email'    => 'required|email|max:90|unique:users',
            'password' => 'required|min:8|max:15',
            'activo'   => 'required',
            'rols_id'  => 'required',
            'init_day' => 'required',
            'end_day'  => 'required|after_or_equal:init_day'            
        ];        
    }

    public function messages(){
        return [
            'name.required' => trans('validacion_froms.user.name_required'),
            'name.min' => trans('validacion_froms.user.name_min'),
            'name.max' => trans('validacion_froms.user.name_max'),
            'email.required' => trans('validacion_froms.user.email_required'),
            'email.max' => trans('validacion_froms.user.email_max'),
            'email.unique' => trans('validacion_froms.user.email_unique'),
            'password.required' => trans('validacion_froms.user.password_required'),
            'password.min' => trans('validacion_froms.user.password_min'),
            'password.max' => trans('validacion_froms.user.password_max'),
            'activo.required' => trans('validacion_froms.user.activo_required'),
            'rols_id.required' => trans('validacion_froms.user.rols_id_required'),
            'init_day.required' => trans('validacion_froms.user.init_day_required'),
            'end_day.required' => trans('validacion_froms.user.end_day_required'),
            'end_day.after_or_equal' => trans('validacion_froms.user.end_day_after_or_equal'),
        ];
    }
}
