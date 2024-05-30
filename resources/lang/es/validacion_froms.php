<?php
/**
* Realizado por @author Tarsicio Carrizales Agosto 2021
* Correo: telecom.com.ve@gmail.com
* El presente archivo contiene todas las validaciones que se realizan
* en los diferentes formularios de la aplicación
*/
return [
    'user' => [
        'name_required' => 'El campo Nombre Completo es requerido',
        'name_min' => 'El campo Nombre debe tener mínimo 8 caracteres',
        'name_max' => 'El campo Nombre debe tener máxino 40 caracteres',
        'email_required' => 'El campo Correo Electrónico debe es requerido',
        'email_max' => 'El campo Correo Electrónico debe tener máxino 90 caracteres',
        'email_unique' => 'El campo Correo Electrónico debe ser unico, ya existe en la base de datos',
        'password_required' => 'El campo Password es requerido',
        'password_min' => 'El campo Password debe tener mínimo 8 caracteres',
        'password_max' => 'El campo Password debe tener máximo 15 caracteres',
        'activo_required' => 'El campo Activo es requerido!',
        'rols_id_required' => 'El campo Rol es requerido',
        'init_day_required' => 'El campo Fecha Inicio es requerido',
        'end_day_required' => 'El campo Fecha Fin es requerido',
        'end_day_after_or_equal' => 'El campo Fecha Fin no puede ser menor al campo Fecha inicio',
    ],
    'rol' => [
        'name_required' => 'El campo Nombre es requerido',
        'name_min' => 'El campo Nombre debe tener mínimo 3 caracteres',
        'name_max' => 'El campo Nombre debe tener máxino 50 caracteres',
        'name_unique' => 'El campo Nombre debe ser único, ya esta incluido en base de datos',
        'description_required' => 'El campo descripción es requerido',
        'description_min' => 'El campo descripción debe tener mínimo 3 caracteres',
        'description_max' => 'El campo descripción debe tener máxino 80 caracteres',        
    ],
    'modulo' => [
        'name_required' => 'El campo Nombre es requerido',
        'name_min' => 'El campo Nombre debe tener mínimo 3 caracteres',
        'name_max' => 'El campo Nombre debe tener máxino 50 caracteres',
        'name_unique' => 'El campo Nombre debe ser único, ya esta incluido en base de datos',
        'description_required' => 'El campo descripción es requerido',
        'description_min' => 'El campo descripción debe tener mínimo 3 caracteres',
        'description_max' => 'El campo descripción debe tener máxino 80 caracteres',        
    ],
];
