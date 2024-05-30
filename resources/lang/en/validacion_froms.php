<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
* El presente archivo contiene todas las validaciones que se realizan
* en los diferentes formularios de la aplicación
*/
return [
    'user' => [
        'name_required' => 'The Full Name field is required',
        'name_min' => 'The Name field must have a minimum of 8 characters',
        'name_max' => 'The Name field must have a maximum of 40 characters',
        'email_required' => 'The Email field must be required',
        'email_max' => 'The Email field must have a maximum of 90 characters',
        'email_unique' => 'The Email field must be unique, it already exists in the database',
        'password_required' => 'The Password field is required',
        'password_min' => 'The Password field must have a minimum of 8 characters',
        'password_max' => 'The Password field must have a maximum of 15 characters',
        'activo_required' => 'The Active field is required',
        'rols_id_required' => 'The Role field is required',
        'init_day_required' => 'The Start Date field is required',
        'end_day_required' => 'The End Date field is required',
        'end_day_after_or_equal' => 'The End Date field cannot be less than the Start Date field',
    ],
    'rol' => [
        'name_required' => 'The Name field is required',
        'name_min' => 'The Name field must have a minimum of 3 characters',
        'name_max' => 'The Name field must have a maximum of 50 characters',
        'name_unique' => 'The Name field must be unique, it is already included in the database',
        'description_required' => 'The Description field is required',
        'description_min' => 'The Description field must have a minimum of 3 characters',
        'description_max' => 'The Name field must have a maximum of 80 characters',        
    ],
    'modulo' => [
        'name_required' => 'The Name field is required',
        'name_min' => 'The Name field must have a minimum of 3 characters',
        'name_max' => 'The Name field must have a maximum of 50 characters',
        'name_unique' => 'The Name field must be unique, it is already included in the database',
        'description_required' => 'The Description field is required',
        'description_min' => 'The Description field must have a minimum of 3 characters',
        'description_max' => 'The Name field must have a maximum of 80 characters',        
    ],
];
