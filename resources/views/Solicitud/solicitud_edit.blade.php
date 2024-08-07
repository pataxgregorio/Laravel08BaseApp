@extends('adminlte::layouts.app')

@section('css_database')
@include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">EDITAR SOLICITUD</h2>
    @component('components.boton_back', ['ruta' => route('solicitud.index'), 'color' => $array_color['back_button_color']])
    Botón de retorno
    @endcomponent
</div>

@endsection


@section('main-content')

<div class="container-fluid w-50" style="max-width:640px">
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <?php 
                    $rols_id = auth()->user()->rols_id;
$phpValue = $rols_id;
$idmunicipio = $solicitud_edit->municipio_id;
echo "<script> var rolsJS = '" . $phpValue . "'; </script>";
echo "<script> var idmunicipioJS = '" . $idmunicipio . "'; </script>"
                    ?>
                    
                    {!! Form::open(
    array(
        'route' => array('solicitud.update', $solicitud_edit->id),
        'method' => 'POST',
        'id' => 'form_users_id',
        'enctype' => 'multipart/form-data'
    )
) !!}


                <div class="form-group">
                <div style="text-align:left;">
                        {!! Form::label('solicitud_salud_id_label', 'ID DE LA SOLICITUD', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('solicitud_salud_id_show', old('solicitud_salud_id'), ['placeholder' => $correlativoSALUD, 'class' => 'form-control', 'id' => 'solicitud_salud_id', 'DISABLED' => TRUE]) !!}
                        <input type="text" name="solicitud_salud_id" id="solicitud_salud_id" value="{{ $correlativoSALUD }}" hidden>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('trabajador', 'Trabajador', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('trabajador', $trabajador, $solicitud_edit->trabajador, ['class' => 'form-control', 'id' => 'trabajador']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('nombre', trans('message.users_action.nombre'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('nombre', $solicitud_edit->nombre, ['placeholder' => trans('message.solicitud_action.nombre'), 'class' => 'form-control', 'id' => 'nombre_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('cedula', trans('message.solicitud_action.cedula'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('cedula', $solicitud_edit->cedula, ['placeholder' => trans('message.solicitud_action.cedula'), 'class' => 'form-control', 'id' => 'cedula_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('telefono', trans('message.solicitud_action.telefono'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('telefono', $solicitud_edit->telefono, ['placeholder' => trans('message.solicitud_action.telefono'), 'class' => 'form-control', 'id' => 'telefono_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('telefono2', trans('message.solicitud_action.telefono2'), ['class' => 'control-label']) !!}
                        {!! Form::text('telefono2', $solicitud_edit->telefono2, ['placeholder' => trans('message.solicitud_action.telefono2'), 'class' => 'form-control', 'id' => 'telefono2_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('email', trans('message.users_action.email_user'), ['class' => 'control-label']) !!}
                        {!! Form::email('email', $solicitud_edit->email, ['placeholder' => trans('message.users_action.mail_ejemplo'), 'class' => 'form-control', 'id' => 'email_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('estado_id', 'SEXO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('sexo', $sexo, $solicitud_edit->sexo, ['placeholder' => trans('message.solicitud_action.sexo'), 'class' => 'form-control', 'id' => 'sexo']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('edocivil', trans('message.solicitud_action.edocivil'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('edocivil', $edocivil, $solicitud_edit->edocivil, ['placeholder' => trans('message.solicitud_action.edocivil'), 'class' => 'form-control', 'id' => 'edocivil_id']) !!}

                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('fechaNacimiento', 'FECHA DE NACIMIENTO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::date('fechaNacimiento', $solicitud_edit->fechaNacimiento, ['placeholder' => 'FECHA DE NACIMIENTO', 'class' => 'form-control', 'id' => 'fechaNacimiento_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('nivelestudio', 'NIVEL EDUCATIVO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('nivelestudio', $nivelestudio, $solicitud_edit->nivelestudio, ['placeholder' => 'NIVEL EDUCATIVO', 'class' => 'form-control', 'id' => 'nivelestudio_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('profesion', 'OCUPACION O/U OFICIO', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('profesion', $profesion, $solicitud_edit->profesion, ['placeholder' => 'OCUPACION O/U OFICIO', 'class' => 'form-control', 'id' => 'profesion_user']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('estado_id', trans('message.solicitud_action.estado'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('estado_id', $estado, $solicitud_edit->estado_id, ['placeholder' => trans('message.solicitud_action.estado'), 'class' => 'form-control', 'id' => 'estado_id']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('municipio_id', trans('message.solicitud_action.municipio'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('municipio_id', $municipio, $solicitud_edit->municipio_id, ['placeholder' => trans('message.solicitud_action.municipio'), 'class' => 'form-control', 'id' => 'municipio_id']) !!}
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('parroquia_id', trans('message.solicitud_action.parroquia'), ['class' => 'control-label', 'id' => 'parroquia_id_label']) !!}<span
                            class="required" style="color:red;" id="parroquia_id_span">*</span>
                        {!! Form::select('parroquia_id', $parroquia, $solicitud_edit->parroquia_id, ['placeholder' => trans('message.solicitud_action.parroquia'), 'class' => 'form-control', 'id' => 'parroquia_id']) !!}
                    </div>
                    
                    <div style="text-align:left;">
                        {!! Form::label('comuna_id_label', trans('message.solicitud_action.comuna'), ['class' => 'control-label', 'id' => 'comuna_id_label']) !!}<span
                            class="required" style="color:red;" id="comuna_id_span">*</span>
                        <select name="comuna_id" id="comuna_id" class="form-control">
                            @foreach($comuna as $key => $value)
                                <option value="{{ $value->id }}" @if(old('comuna_id', $solicitud_edit->comuna_id) == $value->id) selected @endif>{{ $value->codigo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('comunidad_id', trans('message.solicitud_action.comunidad'), ['class' => 'control-label', 'id' => 'comunidad_id_label']) !!}<span
                            class="required" style="color:red;" id="comunidad_id_span">*</span>
                        <select name="comunidad_id" id="comunidad_id" class="form-control">
                            @foreach($comunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('comunidad_id', $solicitud_edit->comunidad_id) == $value->id) selected @endif>{{ $value->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('jefecomunidad', 'Jefe de Comunidad', ['class' => 'control-label', 'id' => 'jefecomunidad_label']) !!}<span
                            class="required" style="color:red;" id="jefecomunidad_Span">*</span>
                        <select name="jefecomunidad_id" id="jefecomunidad_id" class="form-control">
                            @foreach($jefecomunidad2 as $key => $value)
                                <option value="{{ $value->id}}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Jefe_Comunidad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('telefonoJEFE', 'Telefono de Jefe de Comunidad', ['class' => 'control-label', 'id' => 'telefonoJEFE_label']) !!}<span
                            class="required" style="color:red;" id="telefonoJEFE_span">*</span>
                        <select name="telefonoJEFE" id="telefonoJEFE" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Telefono_Jefe_Comunidad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('nombreUBCH', 'Nombre de UBCH', ['class' => 'control-label', 'id' => 'nombreUBCH_label']) !!}<span
                            class="required" style="color:red;" id="nombreUBCH_span">*</span>
                        <select name="nombreUBCH" id="nombreUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Ubch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('nomjefeUBCH', 'Nombre de Jefe UBCH', ['class' => 'control-label', 'id' => 'nomjefeUBCH_label']) !!}<span
                            class="required" style="color:red;" id="nomjefeUBCH_span">*</span>
                        <select name="nomjefeUBCH" id="nomjefeUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Nombre_Jefe_Ubch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="text-align:left;">
                        {!! Form::label('teljefeUBCH', 'Telefono de Jefe UBCH', ['class' => 'control-label', 'id' => 'teljefeUBCH_label']) !!}<span
                            class="required" style="color:red;" id="teljefeUBCH_span">*</span>
                        <select name="teljefeUBCH" id="teljefeUBCH" class="form-control" disabled>
                            @foreach($jefecomunidad as $key => $value)
                                <option value="{{ $value->id }}" @if(old('jefecomunidad_id', $solicitud_edit->jefecomunidad_id) == $value->id) selected @endif>
                                    {{ $value->Telefono_Jefe_Ubch }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div style="text-align:left;">
                        {!! Form::label('direccion', trans('message.solicitud_action.direccion'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::text('direccion', $solicitud_edit->direccion, ['placeholder' => trans('message.solicitud_action.direccion'), 'class' => 'form-control', 'id' => 'direccion_user']) !!}
                    </div>

                    <div style="text-align:left;">
                        {!! Form::label('tipo_solicitud_id', trans('message.solicitud_action.tipo_solicitud'), ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        {!! Form::select('tipo_solicitud_id', $tipo_solicitud, $rols_id == 10 ? 6 : old('tipo_solicitud_id'), ['placeholder' => trans('message.solicitud_action.tipo_solicitud'), 'class' => 'form-control', 'id' => 'tipo_solicitud_id', $rols_id == 10 ? 'disabled' : '']) !!}
                        @if($rols_id == 10)
                            <input type="hidden" name="tipo_solicitud_id" id="tipo_solicitud_id" value="6">
                        @endif
                    </div>
                    
                    @if($rols_id == 10)                    
                    <div style="text-align:left;">
                        {!! Form::label('tipo_subsolicitud_id', 'TIPO SOLICITUD', ['class' => 'control-label']) !!}<span
                            class="required" style="color:red;">*</span>
                        <select name="tipo_subsolicitud_id" id="tipo_subsolicitud_id" class="form-control">
                            @foreach($subtiposolicitud as $key => $value)
                                <option value="{{ $value->id}}" @if(old('tipo_subsolicitud_id', $solicitud_edit->tipo_subsolicitud_id) == $value->id) selected @endif>
                                    {{ $value->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div id="denunciado">
                        <?php  
                    
                         $variable = $solicitud_edit->tipo_solicitud_id;

if ($solicitud_edit->tipo_solicitud_id == 1) {
    $valores = $denuncia;
}
if ($solicitud_edit->tipo_solicitud_id == 2) {

    $valores = $quejas;
}
if ($solicitud_edit->tipo_solicitud_id == 3) {
    $valores = $reclamo;
}
                            
                         ?>

                        <h3>Datos de Denuncia, Reclamo o Queja </h3>
                        <br>
                        <div style="text-align:left;">
                            {!! Form::label('ceduladenunciado', trans('message.solicitud_action.ceduladenunciado'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('ceduladenunciado', isset($denunciado[0]["cedula"]) ? $denunciado[0]["cedula"] : '', ['placeholder' => trans('message.solicitud_action.ceduladenunciado'), 'class' => 'form-control', 'id' => 'ceduladenunciado_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('nombredenunciado', trans('message.solicitud_action.nombredenunciado'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('nombredenunciado', isset($denunciado[0]["nombre"]) ? $denunciado[0]["nombre"] : '', ['placeholder' => trans('message.solicitud_action.nombredenunciado'), 'class' => 'form-control', 'id' => 'nombredenunciado_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('testigo', trans('message.solicitud_action.testigo'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('testigo', isset($denunciado[0]["testigo"]) ? $denunciado[0]["testigo"] : '', ['placeholder' => trans('message.solicitud_action.testigo'), 'class' => 'form-control', 'id' => 'testigo_user']) !!}
                        </div>
                        <h3>Descripcion de Hechos </h3>
                        <br>

                        <div style="text-align:left;">
                            {!! Form::label('relato', trans('message.solicitud_action.relato'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('relato', isset($valores[0]["relato"]) ? $valores[0]["relato"] : '', ['placeholder' => trans('message.solicitud_action.relato'), 'class' => 'form-control', 'id' => 'relato_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('observacion', trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('observacion', isset($valores[0]["observacion"]) ? $valores[0]["observacion"] : '', ['placeholder' => trans('message.solicitud_action.observacion'), 'class' => 'form-control', 'id' => 'observacion_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            <label>DENUNCIA PRESENTADA*</label>
                            <select required name="presentada" id="presentada" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('explique', trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('explique', isset($valores[0]["expliquepresentada"]) ? $valores[0]["expliquepresentada"] : '', ['placeholder' => trans('message.solicitud_action.explique'), 'class' => 'form-control', 'id' => 'explique_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            <label>COMPETENCIA*</label>
                            <select required name="competencia" id="competencia" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('explique2', trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('explique2', isset($valores[0]["explique competencia"]) ? $valores[0]["explique competencia"] : '', ['placeholder' => trans('message.solicitud_action.explique'), 'class' => 'form-control', 'id' => 'explique_user']) !!}
                        </div>
                        <h3>Recuados de la Solicitud</h3>
                        <br>
                        <div class="col">
                            <div style="text-align:left;">
                                <?php 
                                 $valor2 = isset($recaudos[0]["cedula"]) ? $recaudos[0]["cedula"] : '';
//  $valor2 = '';
$valor = false;
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkcedula', 'on', $valor) !!}
                                {!! Form::label('checkcedula', 'Copia Cedula') !!}

                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 //$valor3 = isset($recaudos[0]["motivo"]) ?$recaudos[0]["motivo"]: '';
$valor2 = isset($recaudos[0]["motivo"]) ? $recaudos[0]["motivo"] : '';
// $valor2 = '';
$valor = false;
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkmotivo', 'on', $valor) !!}
                                {!! Form::label('checkmotivo', 'Motivo') !!}

                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 $valor2 = isset($recaudos[0]["video"]) ? $recaudos[0]["video"] : '';
//$valor2 = '';
$valor = false;
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkvideo', 'on', $valor) !!}
                                {!! Form::label('checkvideo', 'Video') !!}

                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 $valor2 = isset($recaudos[0]["foto"]) ? $recaudos[0]["foto"] : '';
//$valor2 = '';
$valor = false;
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkfoto', 'on', $valor) !!}
                                {!! Form::label('checkfoto', 'Foto') !!}

                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 $valor = false;
//$valor2 = '';
$valor2 = isset($recaudos[0]["grabacion"]) ? $recaudos[0]["grabacion"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkgrabacion', 'on', $valor) !!}
                                {!! Form::label('checkgrabacion', 'Grabacion') !!}
                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 $valor = false;
//$valor2 = '';
$valor2 = isset($recaudos[0]["testigo"]) ? $recaudos[0]["testigo"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checktestigo', 'on', $valor) !!}
                                {!! Form::label('checktestigo', 'Cedula Testigo') !!}

                            </div>
                            <div style="text-align:left;">
                                <?php 
                                 $valor = false;
//$valor2 = '';
$valor2 = isset($recaudos[0]["residencia"]) ? $recaudos[0]["residencia"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                                {!! Form::checkbox('checkresidencia', $valor) !!}
                                {!! Form::label('checkresidencia', 'Carta Residencia') !!}

                            </div>
                        </div>
                    </div>
                    <div id="sugerencia">
                        <?php  
                    
                    $variable = $solicitud_edit->tipo_solicitud_id;

if ($solicitud_edit->tipo_solicitud_id == 4) {
    $valores = $sugerecia;
}
if ($solicitud_edit->tipo_solicitud_id == 5) {

    $valores = $asesoria;
}
                   
                       
                    ?>
                        <h3>Sugerencia o Asesoria</h3>
                        <div style="text-align:left;">
                            {!! Form::label('observacion2', trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('observacion2', isset($valores[0]["observacion"]) ? $valores[0]["observacion"] : '', ['placeholder' => trans('message.solicitud_action.observacion'), 'class' => 'form-control', 'id' => 'observacion_user']) !!}
                        </div>
                        <h3>Recuados de la Solicitud</h3>
                        <br>
                        <div style="text-align:left;">
                            <?php 
                                 $valor = false;
$valor2 = isset($recaudos[0]["motivo"]) ? $recaudos[0]["motivo"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                  ?>

                            {!! Form::checkbox('checkmotivo2', $valor) !!}
                            {!! Form::label('checkmotivo2', 'Exposicion de Motivo') !!}
                        </div>
                    </div>
                    <div id="beneficiario">
                        <?php  
                    
                        $variable = $solicitud_edit->tipo_solicitud_id;

if ($solicitud_edit->tipo_solicitud_id == 6) {
    $valores = $beneficiario;
}
                        
                   
                       
                    ?>

                        <h3>Solicitud</h3>
                        <div style="text-align:left;">
                            {!! Form::label('nombrebeneficiario', trans('message.solicitud_action.nombrebeneficiario'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('nombrebeneficiario', isset($valores[0]["nombre"]) ? $valores[0]["nombre"] : '', ['placeholder' => trans('message.solicitud_action.nombrebeneficiario'), 'class' => 'form-control', 'id' => 'nombrebeneficiario_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('cedulabeneficiario', trans('message.solicitud_action.cedulabeneficiario'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('cedulabeneficiario', isset($valores[0]["cedula"]) ? $valores[0]["cedula"] : '', ['placeholder' => trans('message.solicitud_action.cedulabeneficiario'), 'class' => 'form-control', 'id' => 'cedulabeneficiario_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('direccionbeneficiario', trans('message.solicitud_action.direccionbeneficiario'), ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('direccionbeneficiario', isset($valores[0]["direccion"]) ? $valores[0]["direccion"] : '', ['placeholder' => trans('message.solicitud_action.direccionbeneficiario'), 'class' => 'form-control', 'id' => 'direccionbeneficiario_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('solicita', 'Solicita', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('solicita', isset($valores[0]["solicita"]) ? $valores[0]["solicita"] : '', ['placeholder' => 'Solicita', 'class' => 'form-control', 'id' => 'solicita_user']) !!}
                        </div>
                        <div style="text-align:left;">
                            {!! Form::label('venApp', 'Codigo venApp', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::text('venApp', isset($valores[0]["venApp"]) ? $valores[0]["venApp"] : '', ['placeholder' => 'Codigo', 'class' => 'form-control', 'id' => 'venApp_user']) !!}
                        </div>
                        <h3>Recuados de la Solicitud</h3>
                        <br>
                        <div style="text-align:left;">
                                    <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["cedula"]) ? $recaudos[0]["cedula"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                    {!! Form::checkbox('checkcedula2', 'on', $valor) !!}
                                    {!! Form::label('checkcedula2', 'Copia Cedula') !!}
                                    
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["motivo"]) ? $recaudos[0]["motivo"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                        {!! Form::checkbox('checkmotivo3', 'on', $valor) !!}
                                        {!! Form::label('checkmotivo3', 'Exposicion de Motivo') !!}
                                    
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["recipe"]) ? $recaudos[0]["recipe"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                        {!! Form::checkbox('recipe', 'on', $valor) !!}
                                        {!! Form::label('recipe', 'Recipe Medico') !!}
                                    
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["informe"]) ? $recaudos[0]["informe"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                        {!! Form::checkbox('checkinforme', 'on', $valor) !!}
                                        {!! Form::label('checkinforme', 'Informe Medico') !!}
                                    
                                    
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["beneficiario"]) ? $recaudos[0]["beneficiario"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                        {!! Form::checkbox('checkcedulabeneficiario', 'on', $valor) !!}
                                        {!! Form::label('checkcedulabeneficiario', 'Cedula Beneficiario') !!}
                                    
                                    </div>
                                    <?php 
                                             $valor = false;
$valor2 = isset($recaudos[0]["checkpresupuesto"]) ? $recaudos[0]["checkpresupuesto"] : '';
if ($valor2 == "on") {
    $valor = true;

}   
                                               ?>
                                    
                                    {!! Form::checkbox('checkpresupuesto', 'on', $valor) !!}
                                    {!! Form::label('checkpresupuesto', 'Presupuesto (BS)') !!}
                                    
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                            $valor = false;
$valor2 = isset($recaudos[0]["evifotobeneficiario"]) ? $recaudos[0]["evifotobeneficiario"] : '';
if ($valor2 == "on") {
    $valor = true;
}   
                                ?>
                                        {!! Form::checkbox('evifotobeneficiario', 'on', $valor) !!}
                                        {!! Form::label('evifotobeneficiario', 'Evidencia Fotografica') !!}
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                            $valor = false;
$valor2 = isset($recaudos[0]["permisoinhumacion"]) ? $recaudos[0]["permisoinhumacion"] : '';
if ($valor2 == "on") {
    $valor = true;
}   
                                ?>
                                        {!! Form::checkbox('permisoinhumacion', 'on', $valor) !!}
                                        {!! Form::label('permisoinhumacion', 'Permiso de Inhumacion') !!}
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                            $valor = false;
$valor2 = isset($recaudos[0]["certificadodefuncion"]) ? $recaudos[0]["certificadodefuncion"] : '';
if ($valor2 == "on") {
    $valor = true;
}   
                                ?>
                                        {!! Form::checkbox('certificadodefuncion', 'on', $valor) !!}
                                        {!! Form::label('certificadodefuncion', 'Certificado de Defuncion') !!}
                                    </div>
                                    <div style="text-align:left;">
                                        <?php 
                            $valor = false;
$valor2 = isset($recaudos[0]["ordenexamen"]) ? $recaudos[0]["ordenexamen"] : '';
if ($valor2 == "on") {
    $valor = true;
}   
                                ?>
                                        {!! Form::checkbox('ordenexamen', 'on', $valor) !!}
                                        {!! Form::label('ordenexamen', 'Orden de Examen') !!}
                                    </div>
                                    </div>
                    @if($rols_id != 10)
                        <div style="text-align:left;">
                            {!! Form::label('asignacion', 'ASIGNACION', ['class' => 'control-label']) !!}<span
                                class="required" style="color:red;">*</span>
                            {!! Form::select('asignacion', $asignacion, $solicitud_edit->asignacion, ['placeholder' => 'ASIGNACION', 'class' => 'form-control', 'id' => 'asignacion']) !!}

                        </div>
                        <div id="direccion">
                            <div style="text-align:left;">

                                {!! Form::label('direcciones_id', trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span
                                    class="required" style="color:red;">*</span>
                                {!! Form::select('direcciones_id', $direcciones, $solicitud_edit->direccion_id, ['placeholder' => trans('message.solicitud_action.direcciones'), 'class' => 'form-control', 'id' => 'direcciones_id']) !!}
                            </div>
                            <div style="text-align:left;">
                                {!! Form::label('coordinacion_id', trans('message.solicitud_action.coordinacion'), ['class' => 'control-label']) !!}<span
                                    class="required" style="color:red;">*</span>
                                {!! Form::select('coordinacion_id', $coordinacion, $solicitud_edit->coordinacion_id, ['placeholder' => trans('message.solicitud_action.coordinacion'), 'class' => 'form-control', 'id' => 'coordinacion_id']) !!}
                            </div>
                        </div>
                    @endif                      
                    <?php  

                    $variable = $solicitud_edit->tipo_solicitud_id;
$variable2 = $solicitud_edit->asignacion;
if ($variable == 1) {
    echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
    echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
}
if ($variable == 2) {
    echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
    echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
}
if ($variable == 3) {
    echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
    echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
}
if ($variable == 4) {
    echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
    echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
}
if ($variable == 5) {
    echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
    echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
}
if ($variable == 6) {
    echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
    echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
}
if ($variable2 == 'DIRECCION') {
    echo '<script>document.getElementById("enter_descentralizados_id").style.display = "none";</script>';
}
if ($variable2 == 'ENTER') {
    echo '<script>document.getElementById("direccion").style.display = "none";</script>';
}
                   ?>
                    <hr>
                    {!! Form::submit('ACT. SOLIC', ['class' => 'form-control btn btn-primary', 'title' => 'ACT. SOLIC', 'data-toggle' => 'tooltip', 'style' => 'background-color:' . $array_color['group_button_color'] . ';']) !!}
                    <input type="hidden" name="id_solicitud" value="{{$solicitud_edit->id}}">
                    {!!  Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script_datatable')
<script src="{{ url('/js_users/js_users.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function () {
        // $("#comuna_id").empty()
        //  $("#comuna_id").html('<option value="">COMUNA<option/>')

        // const comuna = $('#parroquia_id')

        // $("#denunciado").hide();
        // $("#sugerencia").hide();
        //$("#beneficiario").hide();
        //   $("#enter").hide();
        // $("#direccion").hide();
        
        if(idmunicipioJS == 2){
            $("#parroquia_id").hide();
                $("#parroquia_id_label").hide();
                $("#parroquia_id_span").hide();
                $("#comuna_id").hide();
                $("#comuna_id_label").hide();
                $("#comuna_id_span").hide();
                $("#comunidad_id").hide();
                $("#comunidad_id_label").hide();
                $("#comunidad_id_span").hide();
                $("#jefecomunidad_label").hide();
                $("#jefecomunidad_Span").hide();
                $("#jefecomunidad_id").hide();
                $("#telefonoJEFE").hide();
                $("#telefonoJEFE_label").hide();
                $("#telefonoJEFE_span").hide();
                $("#nombreUBCH").hide();
                $("#nombreUBCH_label").hide();
                $("#nombreUBCH_span").hide();
                $("#nomjefeUBCH").hide();
                $("#nomjefeUBCH_label").hide();
                $("#nomjefeUBCH_span").hide();
                $("#teljefeUBCH").hide();
                $("#teljefeUBCH_label").hide();
                $("#teljefeUBCH_span").hide();
        }
        $('#municipio_id').change(function () {
            var municipio = $('#municipio_id').val();
            if (municipio == 2) {
                $("#parroquia_id").hide();
                $("#parroquia_id_label").hide();
                $("#parroquia_id_span").hide();
                $("#comuna_id").hide();
                $("#comuna_id_label").hide();
                $("#comuna_id_span").hide();
                $("#comunidad_id").hide();
                $("#comunidad_id_label").hide();
                $("#comunidad_id_span").hide();
                $("#jefecomunidad_label").hide();
                $("#jefecomunidad_Span").hide();
                $("#jefecomunidad_id").hide();
                $("#telefonoJEFE").hide();
                $("#telefonoJEFE_label").hide();
                $("#telefonoJEFE_span").hide();
                $("#nombreUBCH").hide();
                $("#nombreUBCH_label").hide();
                $("#nombreUBCH_span").hide();
                $("#nomjefeUBCH").hide();
                $("#nomjefeUBCH_label").hide();
                $("#nomjefeUBCH_span").hide();
                $("#teljefeUBCH").hide();
                $("#teljefeUBCH_label").hide();
                $("#teljefeUBCH_span").hide();
            } else {
                $("#parroquia_id").show();
                $("#parroquia_id_label").show();
                $("#parroquia_id_span").show();
                $("#comuna_id").show();
                $("#comuna_id_label").show();
                $("#comuna_id_span").show();
                $("#comunidad_id").show();
                $("#comunidad_id_label").show();
                $("#comunidad_id_span").show();
                $("#jefecomunidad_id").show();
                $("#jefecomunidad_label").show();
                $("#jefecomunidad_Span").show();
                $("#telefonoJEFE").show();
                $("#telefonoJEFE_label").show();
                $("#telefonoJEFE_span").show();
                $("#nombreUBCH").show();
                $("#nombreUBCH_label").show();
                $("#nombreUBCH_span").show();
                $("#nomjefeUBCH").show();
                $("#nomjefeUBCH_label").show();
                $("#nomjefeUBCH_span").show();
                $("#teljefeUBCH").show();
                $("#teljefeUBCH_label").show();
                $("#teljefeUBCH_span").show();
            }
        })
        $('#municipio_id').change(function () {
            $("#parroquia_id").prop('disabled', false);
        });
        $('#estado_id').change(function () {
            $("#municipio_id").prop('disabled', false);

        });
        $('#parroquia_id').change(function () {
            var parroquia = $('#parroquia_id').val();
            $("#comuna_id").prop('disabled', false);

            $.ajax({
                url: "{{ route('getComunas') }}",
                type: "GET",
                data: { parroquia: parroquia },
                success: function (data) {
                    $("#comuna_id").empty();
                    $("#comuna_id").append('<option value="">COMUNA</option>'); // Opción inicial
                    $.each(data, function (key, value) {
                        $("#comuna_id").append('<option value="' + value.id + '">' + value.codigo + '</option>');
                    });
                },
                error: function () {
                    alert("Error al cargar las comunas."); // Manejo de errores
                }
            });
        });


        $('#asignacion').change(function () {

            var asignacion = $("#asignacion").val();

            if (asignacion == "DIRECCION") {
                $("#enter").hide();
                $("#direccion").show();

            }
            if (asignacion == "ENTER") {
                $("#enter").show();
                $("#direccion").hide();

            }
        })
        $('#jefecomunidad_id').change(function () {
            var jefecomunidadID = $(this).val();
            $.ajax({
                url: "{{ route('getJefeComunidad2') }}",
                type: "GET",
                data: { jefecomunidadID: jefecomunidadID },
                success: function (data) {
                    // Verifica si se recibieron datos
                    if (data.length > 0) {
                        var value = data[0]; // Accede al primer elemento del array
                        // Actualiza los campos usando .text() para elementos <p>
                        $("#telefonoJEFE").empty();
                        $("#telefonoJEFE").append('<option value="' + value.Telefono_Jefe_Comunidad + '">' + value.Telefono_Jefe_Comunidad + '</option>');
                        $("#nombreUBCH").empty();
                        $("#nombreUBCH").append('<option value="' + value.Telefono_Jefe_Comunidad + '">' + value.Telefono_Jefe_Comunidad + '</option>');
                        $("#nomjefeUBCH").empty();
                        $("#nomjefeUBCH").append('<option value="' + value.Nombre_Jefe_Ubch + '">' + value.Nombre_Jefe_Ubch + '</option>');
                        $("#teljefeUBCH").empty();
                        $("#teljefeUBCH").append('<option value="' + value.Telefono_Jefe_Ubch + '">' + value.Telefono_Jefe_Ubch + '</option>');
                        //  $("#telefonoJEFE").val(value.Telefono_Jefe_Comunidad);
                        //  $("#nombreUBCH").val(value.Nombre_Ubch);
                        //   $("#nomjefeUBCH").val(value.Nombre_Jefe_Ubch);
                        //  $("#teljefeUBCH").val(value.Telefono_Jefe_Ubch); 
                    } else {
                        // Maneja el caso donde no se encontraron datos
                        alert("No se encontraron datos para este jefe de comunidad.");
                    }
                },
                error: function () {
                    alert("Error al cargar los datos.");
                }
            });
        });

        $('#comuna_id').change(function () {
            var comunaId = $(this).val();
            var comuna = $('#comuna_id').val();
            $("#jefecomunidad_id").prop('disabled', false); // Habilita el select

            $.ajax({
                url: "{{ route('getJefeComunidad') }}", // Ruta a tu controlador
                type: "GET",
                data: { comuna_id: comunaId },
                success: function (data) {
                    $("#jefecomunidad_id").empty(); // Limpia opciones anteriores
                    $("#jefecomunidad_id").append('<option value="">Seleccione Jefe de Comunidad</option>'); // Opción inicial

                    $.each(data, function (key, value) {
                        $("#jefecomunidad_id").append('<option value="' + value.id + '">' + value.Nombre_Jefe_Comunidad + '</option>');
                    });
                },
                error: function () {
                    // Manejo de errores (opcional)
                    alert("Error al cargar los jefes de comunidad.");
                }
            })
            $.ajax({
                url: "{{ route('getComunidad2') }}", // Ruta a tu controlador
                type: "GET",
                data: { comuna: comuna },
                success: function (data) {
                    $("#comunidad_id").empty(); // Limpia opciones anteriores
                    $("#comunidad_id").append('<option value="">Seleccione Comunidad</option>'); // Opción inicial

                    $.each(data, function (key, value) {
                        $("#comunidad_id").append('<option value="' + value.id + '">' + value.nombre + '</option>');
                    });
                },
                error: function () {
                    // Manejo de errores (opcional)
                    alert("Error al cargar la comunidad.");
                }
            });
        });


        $('#direcciones_id').change(function () {
            var direccion = $('#direcciones_id').val();

            $.ajax({

                url: "{{ route('getCoodinacion') }}",
                type: "GET",
                data: { direccion: direccion }

            }).done(function (data) {
                // alert(JSON.stringify(data));

                $("#coordinacion_id").empty();
                $("#coordinacion_id").html('<option value="">COORDINACION<option/>');
                for (let c in data) {

                    $("#coordinacion_id").append(`<option value="${c}">${data[c]}<option/>`);

                }
                //  $("#comuna_id").find("option[value='']").remove();
                // $("#comuna_id").change();

            })

        });


        $('#tipo_solicitud_id').change(function () {

            var tipo = $('#tipo_solicitud_id').val();
            alert(tipo);
            if (tipo == 0) {
                $("#denunciado").hide();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }

            if (tipo == 1) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }

            if (tipo == 2) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }
            if (tipo == 3) {
                $("#denunciado").show();
                $("#sugerencia").hide();
                $("#beneficiario").hide();
            }
            if (tipo == 4) {
                $("#denunciado").hide();
                $("#sugerencia").show();
                $("#beneficiario").hide();
            }
            if (tipo == 5) {
                $("#denunciado").hide();
                $("#sugerencia").show();
                $("#beneficiario").hide();
            }
            if (tipo == 6) {
                $("#denunciado").hide();
                $("#sugerencia").hide();
                $("#beneficiario").show();
            }

        });
    })
</script>
@endsection