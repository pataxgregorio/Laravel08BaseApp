@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">CREAR SOLICITUD</h2>
    @component('components.boton_back',['ruta' => route('solicitud.index'),'color' => $array_color['back_button_color']])
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
                    echo "<script> var rolsJS = '" . $phpValue . "'; </script>";
                ?>
                {!! Form::open(array('route' => array('solicitud.store'),
                'method'=>'POST','id' => 'form_solicitud_id','enctype' =>'multipart/form-data')) !!}

                {{ csrf_field() }}  
                <div class="form-group ">
                    <h3>Datos del Solicitante </h3>
                        <br>
                                       
                        <div style="text-align:left;">
                            {!! Form::label('nombre',trans('message.users_action.nombre'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('nombre',old('nombre'),['placeholder' => trans('message.users_action.nombre'),'class' => 'form-control','id' => 'nombre_user']) !!}
                        </div>      
                        <div style="text-align:left;">
                            {!! Form::label('cedula',trans('message.solicitud_action.cedula'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('cedula',old('cedula'),['placeholder' => trans('message.solicitud_action.cedula'),'class' => 'form-control','id' => 'cedula_user']) !!}
                        </div>            
                        <div style="text-align:left;">
                            {!! Form::label('telefono',trans('message.solicitud_action.telefono'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('telefono',old('telefono'),['placeholder' => trans('message.solicitud_action.telefono'),'class' => 'form-control','id' => 'telefono_user']) !!}
                        </div>     
                        <div style="text-align:left;">
                            {!! Form::label('telefono2',trans('message.solicitud_action.telefono2'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('telefono2',old('telefono2'),['placeholder' => trans('message.solicitud_action.telefono2'),'class' => 'form-control','id' => 'telefono2_user']) !!}
                        </div>             
                        
                        <div style="text-align:left;">
                            {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::email('email',old('email'),['placeholder' => trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' => 'email_user']) !!}
                        </div>
                      
                     <div style="text-align:left;">
                         <label>Sexo *</label>
                             <select required name="sexo"  id="sexo" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                 <option value="MASCULINO">MASCULINO</option>
                                 <option value="FEMENINO">FEMENINO</option>
                                </select>
                         </div>
                      <div style="text-align:left;">
                          <label>ESTADO CIVIL*</label>
                         <select required name="edocivil"  id="edocivil" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                         <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                         <option value="SOLTERO">SOLTERO</option>
                            <option value="CASADO">CASADO</option>
                         <option value="VIUDO">VIUDO</option>
                          <option value="DIVORCIADO">DIVORCIADO</option>
                        </select>
                        </div>
                        <div style="text-align:left;">
                           <label>FECHA NACIMIENTO</label>
                            <input type="date" id="fechanacimiento" name="fechanacimiento" class="form-control">
                         </div>
                    <div style="text-align:left;">
                         <label>NIVEL EDUCATIVO*</label>
                             <select required name="niveleducativo"  id="niveleducativo" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="PRIMARIA">PRIMARIA</option>
                                 <option value="SECUNDARIA">SECUNDARIA</option>
                                <option value="BACHILLERATO">BACHILLERATO</option>
                                 <option value="UNIVERSITARIO">UNIVERSITARIO</option>
                                <option value="ESPECIALIZACION">ESPECIALIZACION</option>
                             </select>
                     </div>      
               
                     <div style="text-align:left;">
                        <label>OCUPACION O/U OFICIO*</label>
                         <select required name="profesion"  id="profesion"  class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                             <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                             <option value="TECNICO MEDIO">TECNICO MEDIO</option>
                            <option value="TECNICO SUPERIOR">TECNICO SUPERIOR</option>
                            <option value="INGENIERO CIVIL">INGENIERO</option>
                             <option value="ABOGADO">ABOGADO</option>
                             <option value="MEDICO CIRUJANO">MEDICO CIRUJANO</option>
                         <option value="HISTORIADOR">HISTORIADOR</option>
                         <option value="PALEONTOLOGO">PALEONTOLOGO</option>
                         <option value="GEOGRAFO">GEOGRAFO</option>
                             <option value="BIOLOGO">BIOLOGO</option>
                             <option value="PSICOLOGO">PSICOLOGO</option>
                         <option value="MATEMATICO">MATEMATICO</option>
                         <option value="ARQUITECTO">ARQUITECTO</option>
                          <option value="COMPUTISTA">COMPUTISTA</option>
                          <option value="PROFESOR">PROFESOR</option>
                              <option value="PERIODISTA">PERIODISTA</option>
                           <option value="BOTANICO">BOTANICO</option>
                           <option value="FISICO">FISICO</option>
                            <option value="SOCIOLOGO">SOCIOLOGO</option>
                           <option value="FARMACOLOGO">FARMACOLOGO</option>
                            <option value="QUIMICO">QUIMICO</option>
                          <option value="POLITOLOGO">POLITOLOGO</option>
                              <option value="ENFERMERO">ENFERMERO</option>
                             <option value="ELECTRICISTA">ELECTRICISTA</option>
                          <option value="BIBLIOTECOLOGO">BIBLIOTECOLOGO</option>
                          <option value="PARAMEDICO">PARAMEDICO</option>
                         <option value="TECNICO DE SONIDO">TECNICO DE SONIDO</option>
                          <option value="ARCHIVOLOGO">ARCHIVOLOGO</option>
                               <option value="MUSICO">MUSICO</option>
                           <option value="FILOSOFO">FILOSOFO</option>
                            <option value="SECRETARIA">SECRETARIA</option>
                            <option value="TRADUCTOR">TRADUCTOR</option>
                            <option value="ANTROPOLOGO">ANTROPOLOGO</option>
                           <option value="TECNICO TURISMO">TECNICO TURISMO</option>
                           <option value="ECONOMISTA">ECONOMISTA</option>
                          <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                           <option value="CARPITERO">CARPITERO</option>
                          <option value="RADIOLOGO">RADIOLOGO</option>
                         <option value="COMERCIANTE">COMERCIANTE</option>
                         <option value="CERRAJERO">CERRAJERO</option>
                           <option value="COCINERO">COCINERO</option>
                           <option value="ALBAÑIL">ALBAÑIL</option>
                           <option value="PLOMERO">PLOMERO</option>
                           <option value="TORNERO">TORNERO</option>
                           <option value="EDITOR">EDITOR</option>
                           <option value="ESCULTOR">ESCULTOR</option>
                          <option value="ESCRITOR">ESCRITOR</option>
                          <option value="BARBERO">BARBERO</option>
                     </select>
                </div>   
              <div style="text-align:left;">
                            {!! Form::label('estado_id',trans('message.solicitud_action.estado'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('estado_id', $estado, old('estado_id'), ['placeholder' => trans('message.solicitud_action.estado'),'class' => 'form-control','id' => 'estado_id']) !!}
                        </div>  

                        <div style="text-align:left;">
                            {!! Form::label('municipio_id',trans('message.solicitud_action.municipio'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('municipio_id', $municipio, old('municipio_id'), ['placeholder' => trans('message.solicitud_action.municipio'),'class' => 'form-control','id' => 'municipio_id']) !!}
                        </div>  

                        <div style="text-align:left;">
                            {!! Form::label('parroquia_id',trans('message.solicitud_action.parroquia'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('parroquia_id', $parroquia, old('parroquia_id'), ['placeholder' => trans('message.solicitud_action.parroquia'),'class' => 'form-control','id' => 'parroquia_id']) !!}
                        </div>  
                        <div style="text-align:left;">
                            {!! Form::label('comuna_id',trans('message.solicitud_action.comuna'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('comuna_id', $comuna, old('comuna_id'), ['placeholder' => trans('message.solicitud_action.comuna'),'class' => 'form-control','id' => 'comuna_id']) !!}
                        </div>  
                        <div style="text-align:left;">
                            {!! Form::label('comunidad_id',trans('message.solicitud_action.comunidad'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('comunidad_id', $comunidad, old('comunidad_id'), ['placeholder' => trans('message.solicitud_action.comunidad'),'class' => 'form-control','id' => 'comunidad_id']) !!}
                        </div>  
                        <div style="text-align:left;">
                            {!! Form::label('direccion',trans('message.solicitud_action.direccion'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('direccion',old('direccion'),['placeholder' => trans('message.solicitud_action.direccion'),'class' => 'form-control','id' => 'direccion_user']) !!}
                        </div>    
                            
                        <div style="text-align:left;">
                            {!! Form::label('tipo_solicitud_id',trans('message.solicitud_action.tipo_solicitud'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                            {!! Form::select('tipo_solicitud_id', $tipo_solicitud, $rols_id == 10 ? 6 : old('tipo_solicitud_id'), ['placeholder' => trans('message.solicitud_action.tipo_solicitud'),'class' => 'form-control','id' => 'tipo_solicitud_id', $rols_id == 10 ? 'disabled' : '']) !!}
                            @if($rols_id == 10)
                                <input type="hidden" name="tipo_solicitud_id" id="tipo_solicitud_id" value="6">
                            @endif
                        </div>  

                        <div id = "denunciado">
                            <h3>Datos de Denuncia, Reclamo o Queja </h3>
                              <br>
                                <div style="text-align:left;">
                                   {!! Form::label('ceduladenunciado',trans('message.solicitud_action.ceduladenunciado'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                 {!! Form::text('ceduladenunciado',old('ceduladenunciado'),['placeholder' => trans('message.solicitud_action.ceduladenunciado'),'class' => 'form-control','id' => 'ceduladenunciado_user']) !!}
                                </div>    
                            <div style="text-align:left;">
                                {!! Form::label('nombredenunciado',trans('message.solicitud_action.nombredenunciado'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                 {!! Form::text('nombredenunciado',old('nombredenunciado'),['placeholder' => trans('message.solicitud_action.nombredenunciado'),'class' => 'form-control','id' => 'nombredenunciado_user']) !!}
                              </div>    
                             <div style="text-align:left;">
                                {!! Form::label('testigo',trans('message.solicitud_action.testigo'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                 {!! Form::text('testigo',old('testigo'),['placeholder' => trans('message.solicitud_action.testigo'),'class' => 'form-control','id' => 'testigo_user']) !!}
                                </div>    
                                <h3>Descripcion de Hechos </h3>
                               <br>
                      
                            <div style="text-align:left;">
                            {!! Form::label('relato',trans('message.solicitud_action.relato'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                             {!! Form::text('relato',old('relato'),['placeholder' => trans('message.solicitud_action.relato'),'class' => 'form-control','id' => 'relato_user']) !!}
                             </div> 
                            <div style="text-align:left;">
                                 {!! Form::label('observacion',trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('observacion',old('observacion'),['placeholder' => trans('message.solicitud_action.observacion'),'class' => 'form-control','id' => 'observacion_user']) !!}
                            </div>  
                             <div style="text-align:left;">
                                 <label>DENUNCIA PRESENTADA*</label>
                                 <select required name="presentada"  id="presentada" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                              </select>
                              </div>
                              <div style="text-align:left;">
                                 {!! Form::label('explique',trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('explique',old('observacion'),['placeholder' => trans('message.solicitud_action.explique'),'class' => 'form-control','id' => 'explique_user']) !!}
                            </div>  
                            <div style="text-align:left;">
                                 <label>COMPETENCIA*</label>
                                 <select required name="competencia"  id="competencia" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                              </select>
                              </div>
                              <div style="text-align:left;">
                                 {!! Form::label('explique2',trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('explique2',old('observacion'),['placeholder' => trans('message.solicitud_action.explique'),'class' => 'form-control','id' => 'explique_user']) !!}
                             </div> 
                            <h3>Recuados de la Solicitud</h3>
                            <br>
                            <div class ="col">
                            <div style="text-align:left;">
                                     <input  type="checkbox" id="checkcedula" name ="checkcedula" >
                                     <label class="form-check-label" for="defaultCheck1">Copia Cedula</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkmotivo" name ="checkmotivo">
                                     <label class="form-check-label" for="defaultCheck1">Exposicion de Motivo</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkvideo" name ="checkvideo">
                                     <label class="form-check-label" for="defaultCheck1">Video</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkfoto" name ="checkfoto">
                                     <label class="form-check-label" for="defaultCheck1">Fotos</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkgrabacion" name ="checkgrabacion">
                                     <label class="form-check-label" for="defaultCheck1">Grabacion</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checktestigo" name ="checktestigo">
                                     <label class="form-check-label" for="defaultCheck1">Cedula Testigo</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkresidencia" name ="checkresidencia">
                                     <label class="form-check-label" for="defaultCheck1">Carta Residencia</label>
                                 </div>
                            </div>
                     </div>
                        <div id="sugerencia">
                            <h3>Sugerencia o Asesoria</h3>
                                <div style="text-align:left;">
                                 {!! Form::label('observacion2',trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                {!! Form::text('observacion2',old('observacion'),['placeholder' => trans('message.solicitud_action.observacion'),'class' => 'form-control','id' => 'observacion_user']) !!}
                                 </div> 
                             <h3>Recuados de la Solicitud</h3>
                             <br>
                             <div style="text-align:left;">
                                     <input  type="checkbox" id="checkmotivo2" name ="checkmotivo2">
                                     <label class="form-check-label" for="defaultCheck1">Exposicion de Motivo</label>
                                 </div>
                             </div>

                             <div id="beneficiario">
                                    <h3>Peticion</h3>
                                     <div style="text-align:left;">
                                        {!! Form::label('nombrebeneficiario',trans('message.solicitud_action.nombrebeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                         {!! Form::text('nombrebeneficiario',old('nombrebeneficiario'),['placeholder' => trans('message.solicitud_action.nombrebeneficiario'),'class' => 'form-control','id' => 'nombrebeneficiario_user']) !!}
                                     </div> 
                                     <div style="text-align:left;">
                                        {!! Form::label('cedulabeneficiario',trans('message.solicitud_action.cedulabeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                         {!! Form::text('cedulabeneficiario',old('cedulabeneficiario'),['placeholder' => trans('message.solicitud_action.cedulabeneficiario'),'class' => 'form-control','id' => 'cedulabeneficiario_user']) !!}
                                     </div> 
                                     <div style="text-align:left;">
                                        {!! Form::label('direccionbeneficiario',trans('message.solicitud_action.direccionbeneficiario'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                                         {!! Form::text('direccionbeneficiario',old('direccionbeneficiario'),['placeholder' => trans('message.solicitud_action.direccionbeneficiario'),'class' => 'form-control','id' => 'direccionbeneficiario_user']) !!}
                                     </div> 
                                    <h3>Recuados de la Peticion</h3>
                                    <br>
                                    <div style="text-align:left;">
                                         <input  type="checkbox" id="checkcedula2" name ="checkcedula2">
                                         <label class="form-check-label" for="defaultCheck1">Copia Cedula</label>
                                    </div>
                                    <div style="text-align:left;">
                                     <input  type="checkbox" id="checkmotivo3" name ="checkmotivo3">
                                     <label class="form-check-label" for="defaultCheck1">Exposicion de Motivo</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkinforme" name ="checkinforme">
                                     <label class="form-check-label" for="defaultCheck1">Informe Medico</label>
                                 </div>
                                 <div style="text-align:left;">
                                     <input  type="checkbox" id="checkcedulabeneficiario" name ="checkcedulabeneficiario">
                                     <label class="form-check-label" for="defaultCheck1">Cedula Beneficiario</label>
                                 </div>
                             </div>
                             

                </div>

                <div style="text-align:left;">

               
                     <div id= sinasignar>

                
                        <label>ASIGNACION*</label>
                          <select required name="asignacion"  id="asignacion" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                            <option value="SELECCIONE UNA OPCION">SELECCIONE UNA OPCION</option>
                           <option value="DIRECCION">DIRECCION</option>
                           <option value="ENTER">ENTER</option>
                         </select>
                    </div>   
                </div>
                <div id="direccion">
                    <div style="text-align:left;">
                      {!! Form::label('direcciones_id',trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                      {!! Form::select('direcciones_id', $direcciones, old('direcciones_id'), ['placeholder' => trans('message.solicitud_action.direcciones'),'class' => 'form-control','id' => 'direcciones_id']) !!}
                    </div> 
                    <div style="text-align:left;">
                      {!! Form::label('coordinacion_id',trans('message.solicitud_action.coordinacion'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                      {!! Form::select('coordinacion_id', $coordinacion, old('coordinacion_id'), ['placeholder' => trans('message.solicitud_action.coordinacion'),'class' => 'form-control','id' => 'coordinacion_id']) !!}
                    </div> 
                </div>
                <div id="enter">
                    <div style="text-align:left;">
                      {!! Form::label('enter_id',trans('message.solicitud_action.enter'), ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                      {!! Form::select('enter_id', $enter, old('enter_id'), ['placeholder' => trans('message.solicitud_action.enter'),'class' => 'form-control','id' => 'enter_id']) !!}
                    </div> 

                </div>  
                            
     
     <br>
                        {!! Form::submit(trans('message.solicitud_action.new_solicitud'),['class'=> 'form-control btn btn-primary','title' => trans('message.solicitud_action.new_solicitud'),'data-toggle' => 'tooltip','style' => 'background-color:'.$array_color['group_button_color'].';']) !!}                     
                </div>      
                {!!  Form::close() !!}
            </div>             
        </div>
    </div>
</div>
@endsection
@section('script_datatable')
   
    
    <script type="text/javascript">

    $(document).ready(function(){
        var rolID  = rolsJS;
        // $("#comuna_id").empty()
        $("#comuna_id").html('<option value="">COMUNA<option/>')

   // const comuna = $('#parroquia_id')
   $("#municipio_id").prop('disabled', true);
   $("#parroquia_id").prop('disabled', true);
   $("#comuna_id").prop('disabled', true);
   $("#comunidad_id").prop('disabled', true);
   $("#denunciado").hide();
   $("#sugerencia").hide();
   if(rolID == 10){
    x =  $("#tipo_solicitud_id").val();
    $("#direccion").show();
    $("#beneficiario").show();
   }
   else{
     $("#beneficiario").hide();
     $("#direccion").hide();
   }
   $("#sinasignar").hide();
   $("#enter").hide();
   $('#municipio_id').change(function(){
    $("#parroquia_id").prop('disabled', false);
   


   });
   $('#estado_id').change(function(){
    $("#municipio_id").prop('disabled', false);

   });
    $('#parroquia_id').change(function(){
        var parroquia= $('#parroquia_id').val();
        $("#comuna_id").prop('disabled', false);
        $.ajax({

            url:"{{ route('getComunas2') }}",
            type:"GET",
            data:{parroquia:parroquia}

            }).done(function(data){
                // alert(JSON.stringify(data));
                $("#comuna_id").empty();
                $("#comuna_id").html('<option value="">COMUNA<option/>');
                console.log(data);
            for (let c in data){
                $("#comuna_id").append(`<option value="${c}">${data[c]}<option/>`);
            }
          //  $("#comuna_id").find("option[value='']").remove();
           // $("#comuna_id").change();
            
        })   
   
    });
    $('#asignacion').change(function(){

        var asignacion = $("#asignacion").val();
        if (asignacion =="DIRECCION"){
            $("#enter").hide();
            $("#direccion").show();

        }
        if (asignacion =="ENTER"){
            $("#enter").show();
            $("#direccion").hide();

        }
      }) 


    $('#comuna_id').change(function(){
        var comuna= $('#comuna_id').val();
        $("#comunidad_id").prop('disabled', false);
        $.ajax({

            url:"{{ route('getComunidad2') }}",
            type:"GET",
            data:{comuna:comuna}

            }).done(function(data){
                // alert(JSON.stringify(data));
                
                $("#comunidad_id").empty();
                $("#comunidad_id").html('<option value="">COMUNA<option/>');
            for (let c in data){
               
                $("#comunidad_id").append(`<option value="${c}">${data[c]}<option/>`);
            
            }
          //  $("#comuna_id").find("option[value='']").remove();
           // $("#comuna_id").change();
            
        })   
   
    });

    $('#direcciones_id').change(function(){
        var direccion= $('#direcciones_id').val();
      
        $.ajax({

            url:"{{ route('getCoodinacion2') }}",
            type:"GET",
            data:{direccion:direccion}

            }).done(function(data){
                // alert(JSON.stringify(data));
                
                $("#coordinacion_id").empty();
                $("#coordinacion_id").html('<option value="">COORDINACION<option/>');
            for (let c in data){
               
                $("#coordinacion_id").append(`<option value="${c}">${data[c]}<option/>`);
            
            }
          //  $("#comuna_id").find("option[value='']").remove();
           // $("#comuna_id").change();
            
        })   
   
    });
    
    $('#tipo_solicitud_id').change(function(){ 
        var tipo = $('#tipo_solicitud_id').val();
        if (tipo == 0){
            $("#denunciado").hide();
            $("#sugerencia").hide();
            $("#beneficiario").hide(); 
            $("#sinasignar").hide();

        }

        if (tipo == 1){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
            $("#sinasignar").show();
        }

        if (tipo == 2){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
            $("#sinasignar").show();
        }
        if (tipo == 3){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
            $("#sinasignar").show();
        }
        if (tipo == 4){
            $("#denunciado").hide();
            $("#sugerencia").show();
            $("#beneficiario").hide();
            $("#sinasignar").hide();
        

        }
        if (tipo == 5){
            $("#denunciado").hide();
            $("#sugerencia").show();
            $("#beneficiario").hide();
            $("#sinasignar").hide();
        }
        if (tipo == 6){
            $("#denunciado").hide();
            $("#sugerencia").hide();
            $("#beneficiario").show();
            $("#sinasignar").show();
        }
       
    });
  })
</script>

<script src="{{ url ('/js_users/js_users.min.js') }}" type="text/javascript"></script>
@endsection  