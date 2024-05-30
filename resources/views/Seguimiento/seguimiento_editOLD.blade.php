@extends('adminlte::layouts.app')

@section('css_database')
    @include('adminlte::layouts.partials.link')
@endsection

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
<div>
    <h2 class="mb-4">Seguimiento</h2>
    @component('components.boton_back',['ruta' => route('seguimiento.index'),'color' => $array_color['back_button_color']])
        Botón de retorno
    @endcomponent   
</div>
    
@endsection

    
@section('main-content')

<div class="container-fluid ">
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
                <div class="form-group">
                    <div style="justify-content: center; font-size:42px;padding-left:380px">
                            <h3 >Datos de la Solicitud</h3>
                    </div>   
                    <div class="col-lg-6 col-xs-6">
                            <div style="text-align:left;">
                             {!! Form::label('nombre',trans('message.users_action.nombre'), ['class' => 'control-label']) !!}
                             {!! Form::text('nombre',$solicitud_edit->nombre,['placeholder' => trans('message.solicitud_action.nombre'),'class' => 'col-lg-6 form-control','id' => 'nombre_user','disabled' => true]) !!}
                            </div>   
                            <div style="text-align:left;">
                                {!! Form::label('cedula',trans('message.solicitud_action.cedula'), ['class' => 'control-label']) !!}
                                 {!! Form::text('cedula',$solicitud_edit->cedula,['placeholder' => trans('message.solicitud_action.cedula'),'class' => 'form-control','id' => 'cedula_user','disabled' => true]) !!}
                              </div>   
                             <div style="text-align:left;">
                                  {!! Form::label('telefono',trans('message.solicitud_action.telefono'), ['class' => 'control-label']) !!}
                                  {!! Form::text('telefono',$solicitud_edit->telefono,['placeholder' => trans('message.solicitud_action.telefono'),'class' => 'form-control','id' => 'telefono_user','disabled' => true]) !!}
                              </div>   
                             <div style="text-align:left;">
                                 {!! Form::label('email',trans('message.users_action.email_user'), ['class' => 'control-label']) !!}
                                 {!! Form::email('email',$solicitud_edit->email,['placeholder' => trans('message.users_action.mail_ejemplo'),'class' => 'form-control','id' => 'email_user','disabled' => true]) !!}
                             </div>   
                             <div style="text-align:left;">
                                {!! Form::label('tipo_solicitud_id',trans('message.solicitud_action.tipo_solicitud'), ['class' => 'control-label']) !!}
                                {!! Form::select('tipo_solicitud_id', $tipo_solicitud,$solicitud_edit->tipo_solicitud_id, ['placeholder' => trans('message.solicitud_action.tipo_solicitud'),'class' => 'form-control','id' => 'tipo_solicitud_id','disabled' => true]) !!}
                             </div>  
                            <div style="text-align:left;">
                             {!! Form::label('asignacion','ASIGNACION', ['class' => 'control-label']) !!}
                             {!! Form::select('asignacion',$asignacion, $solicitud_edit->asignacion, ['placeholder' => 'ASIGNACION','class' => 'form-control','id' => 'asignacion','disabled' => true]) !!}
                            </div> 
                            <div id="direccion">  
                                 <div style="text-align:left;">
                                     {!! Form::label('direcciones_id',trans('message.solicitud_action.direcciones'), ['class' => 'control-label']) !!}
                                    {!! Form::select('direcciones_id', $direcciones, $solicitud_edit->direccion_id, ['placeholder' => trans('message.solicitud_action.direcciones'),'class' => 'form-control','id' => 'direcciones_id','disabled' => true]) !!}
                                 </div> 
                                <div style="text-align:left;">
                                     {!! Form::label('coordinacion_id',trans('message.solicitud_action.coordinacion'), ['class' => 'control-label']) !!}
                                     {!! Form::select('coordinacion_id', $coordinacion, $solicitud_edit->coordinacion_id, ['placeholder' => trans('message.solicitud_action.coordinacion'),'class' => 'form-control','id' => 'coordinacion_id','disabled' => true]) !!}
                                </div> 
                            </div>
                            <div id="enter">
                                 <div style="text-align:left;">
                                     {!! Form::label('enter_id',trans('message.solicitud_action.enter'), ['class' => 'control-label']) !!}
                                    {!! Form::select('enter_id', $enter,$solicitud_edit->enter_descentralizados_id, ['placeholder' => trans('message.solicitud_action.enter'),'class' => 'form-control','id' => 'enter_descentralizados_id','disabled' => true]) !!}
                                </div> 
                            </div>  
                    </div> <!--col-lg-6 col-xs-6 primera columna-->
                    <div class="col-lg-6 col-xs-6"> 
                         <div id = "denunciado" >
                                  <?php  
                    
                                     $variable =$solicitud_edit->tipo_solicitud_id;

                                      if($solicitud_edit->tipo_solicitud_id == 1){
                                      $valores =$denuncia;
                                             }
                                      if($solicitud_edit->tipo_solicitud_id == 2){
               
                                          $valores = $quejas;
                                              }
                                     if($solicitud_edit->tipo_solicitud_id == 3){
                                         $valores = $reclamo;
                                         }
                            
                                 ?>
                                    <div style="text-align:left;">
                                         {!! Form::label('ceduladenunciado',trans('message.solicitud_action.ceduladenunciado'), ['class' => 'control-label']) !!}
                                         {!!Form::text('ceduladenunciado',isset($denunciado[0]["cedula"]) ?$denunciado[0]["cedula"]: '',['placeholder' => trans('message.solicitud_action.ceduladenunciado'),'class' => 'form-control','id' => 'ceduladenunciado_user','disabled' => true]) !!}
                                      </div>    
                                     <div style="text-align:left;">
                                            {!! Form::label('nombredenunciado',trans('message.solicitud_action.nombredenunciado'), ['class' => 'control-label']) !!}
                                            {!! Form::text('nombredenunciado',isset($denunciado[0]["nombre"]) ?$denunciado[0]["nombre"]: '',['placeholder' => trans('message.solicitud_action.nombredenunciado'),'class' => 'form-control','id' => 'nombredenunciado_user','disabled' => true]) !!}
                                     </div>    
                                    <div style="text-align:left;">
                                        {!! Form::label('testigo',trans('message.solicitud_action.testigo'), ['class' => 'control-label']) !!}
                                        {!! Form::text('testigo',isset($denunciado[0]["testigo"]) ?$denunciado[0]["testigo"]: '',['placeholder' => trans('message.solicitud_action.testigo'),'class' => 'form-control','id' => 'testigo_user','disabled' => true]) !!}
                                    </div>    
                      
                                     <div style="text-align:left;">
                                         {!! Form::label('relato',trans('message.solicitud_action.relato'), ['class' => 'control-label']) !!}
                                          {!! Form::text('relato',isset($valores[0]["relato"]) ?$valores[0]["relato"]: '',['placeholder' => trans('message.solicitud_action.relato'),'class' => 'form-control','id' => 'relato_user','disabled' => true]) !!}
                                     </div> 
                                     <div style="text-align:left;">
                                          {!! Form::label('observacion',trans('message.solicitud_action.observacion'), ['class' => 'control-label']) !!}
                                         {!! Form::text('observacion',isset($valores[0]["observacion"]) ?$valores[0]["observacion"]: '',['placeholder' => trans('message.solicitud_action.observacion'),'class' => 'form-control','id' => 'observacion_user','disabled' => true]) !!}
                                     </div>  
                                    <div style="text-align:left;">
                                         <label>DENUNCIA PRESENTADA*</label>
                                    </div>
                                    <div style="text-align:left;">
                                         {!! Form::label('explique',trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}
                                          {!! Form::text('explique',isset($valores[0]["expliquepresentada"]) ?$valores[0]["expliquepresentada"]: '',['placeholder' => trans('message.solicitud_action.explique'),'class' => 'form-control','id' => 'explique_user','disabled' => true]) !!}
                                     </div>  
                                    <div style="text-align:left;">
                                        <label>COMPETENCIA*</label>
                                     </div>
                                    <div style="text-align:left;">
                                         {!! Form::label('explique2',trans('message.solicitud_action.explique'), ['class' => 'control-label']) !!}
                                         {!! Form::text('explique2',isset($valores[0]["explique competencia"]) ?$valores[0]["explique competencia"]: '',['placeholder' => trans('message.solicitud_action.explique'),'class' => 'form-control','id' => 'explique_user','disabled' => true]) !!}
                                         </div> 
                        </div> <!--denunciado--> 
                        <div id="beneficiario"> 
                                    <?php  
                    
                                        $variable =$solicitud_edit->tipo_solicitud_id;

                                          if($solicitud_edit->tipo_solicitud_id == 6){
                                               $valores =$beneficiario;
                                               }
                       
                                     ?>
                      
                                    <div style="text-align:left;">
                                         {!! Form::label('nombrebeneficiario',trans('message.solicitud_action.nombrebeneficiario'), ['class' => 'control-label']) !!}
                                         {!! Form::text('nombrebeneficiario',isset($valores[0]["nombre"]) ?$valores[0]["nombre"]: '',['placeholder' => trans('message.solicitud_action.nombrebeneficiario'),'class' => 'form-control','id' => 'nombrebeneficiario_user','disabled' => true]) !!}
                                    </div> 
                                    <div style="text-align:left;">
                                         {!! Form::label('cedulabeneficiario',trans('message.solicitud_action.cedulabeneficiario'), ['class' => 'control-label']) !!}
                                         {!! Form::text('cedulabeneficiario',isset($valores[0]["cedula"]) ?$valores[0]["cedula"]: '',['placeholder' => trans('message.solicitud_action.cedulabeneficiario'),'class' => 'form-control','id' => 'cedulabeneficiario_user','disabled' => true]) !!}
                                    </div> 
                                    <div style="text-align:left;">
                                         {!! Form::label('direccionbeneficiario',trans('message.solicitud_action.direccionbeneficiario'), ['class' => 'control-label']) !!}
                                           {!! Form::text('direccionbeneficiario',isset($valores[0]["direccion"]) ?$valores[0]["direccion"]: '',['placeholder' => trans('message.solicitud_action.direccionbeneficiario'),'class' => 'form-control','id' => 'direccionbeneficiario_user','disabled' => true]) !!}
                                    </div> 
                                 
                        </div> <!--beneficiariop -->
                            
                    </div> <!--col-lg-6 col-xs-6 segunda columna-->    
                    <div style="text-align:left;">
                        <?php  
                            $variable =$solicitud_edit->tipo_solicitud_id;
                            $variable2 =$solicitud_edit->asignacion;
                             if($variable == 1){
                                 echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
                                 echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
                                 }
                             if($variable == 2){
                                 echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
                                  echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
                                }
                             if($variable == 3){
                                 echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
                                  echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
                                  }
                             if($variable == 4){
                                 echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
                                 echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
                                 }
                             if($variable == 5){
                                 echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
                                 echo '<script>document.getElementById("beneficiario").style.display = "none";</script>';
                                 }
                             if($variable == 6){
                               echo '<script>document.getElementById("sugerencia").style.display = "none";</script>';
                                  echo '<script>document.getElementById("denunciado").style.display = "none";</script>';
                                 }
                             if($variable2 == 'DIRECCION'){
                                  echo '<script>document.getElementById("enter").style.display = "none";</script>';
                                 }
                             if($variable2 == 'ENTER'){
                                   echo '<script>document.getElementById("direccion").style.display = "none";</script>';
                                  }
                        ?> 
                
                    </div>  
                  <div class="container col-lg-12 col-xs-12">
                            <div style="text-align:center;">
                                 <h3 style="justify-content: center; font-size:20px;">Actividades del Seguimiento</h3>
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 10px;">+Seguimiento</button>

                            <table class="table table-bordered solicitud_all">
                                <thead>
                                    <tr>
                                     <th>ITEM</th>
                                     <th  style="text-align:center;">FECHA</th>
                                        <th style="text-align:center;">ASUNTO</th>
                                         <th style="text-align:center;">EVIDENCIA</th>
                                     </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>   
                     
                        </div><!--div que contiene la tabla -->
                        <div class="modal" id="myModal">

<div class="modal-dialog">
    <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Agregar Seguimiento</h5>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
             <div style="text-align:left;">
                  {!! Form::label('asunto','Asunto del Caso', ['class' => 'control-label']) !!}<span class="required" style="color:red;">*</span>
                 {!! Form::textarea('asunto',old('asunto'),['placeholder' => 'Asunto del Caso','class' => 'form-control','id' => 'asunto']) !!}
             </div>
             <div style="text-align:left;">
               {!! Form::label('asunto','Evidencia', ['class' => 'control-label']) !!}
                   <input type="file" name="image" id="image">
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             <form id="addSeguimientoForm" method="POST" action="{{ route('addSeguimiento') }}">
                 <button type="submit" class="btn btn-primary" id="agregar" data-dismiss="modal">Agregar</button>
                 <input type="text" hidden value="{{$solicitud_edit->id}}" name="solicitud_id">
             </form>
         </div>
     </div>
</div>
</div>

                    <?php
                         $phpValue = $solicitud_edit;
                             echo "<script> var jsValue = '" . $phpValue . "'; </script>";
                            ?>
                 </div>    <!--div col-lg-12 col-xs-12-->
                </div><!--form-group -->
            </div><!--col-lg-12 col-xs-12 -->
     </div> <!--card-body -->
   </div><!--card -->
</div><!-- container-fluid -->
@endsection
@section('script_datatable')
    <script type="text/javascript">
        
    $(document).ready(function(){
        // $("#comuna_id").empty()
      //  $("#comuna_id").html('<option value="">COMUNA<option/>')

   // const comuna = $('#parroquia_id')
   
 // $("#denunciado").hide();
  // $("#sugerencia").hide();
 //$("#beneficiario").hide();
//   $("#enter").hide();
 // $("#direccion").hide();
 $('#myModal').on('shown.bs.modal', function () {
    // Do something when the modal is shown
});
  var valueFromPHP = jsValue;
 $("#boton").hide();
 $('#agregar').click(function() {
        var inputData = $('#asunto').val();
        var formData = new FormData();
           formData.append('image', $('#image')[0].files[0]);
            var registro = {
                asunto : inputData,
                evidencia :formData,
                tipo_solicitud_id: 6,
                relato:"dszfsagerg",
                observacion:"dfsgesge",
                explique:"dfcsaefweaf",
                explique2:"dfcsaefweaf",
                ceduladenunciado:"5456655788787",
                nombredenunciado:"jose",
                testigo:"jose2",
                _token: "{{ csrf_token() }}",
            }
          //  
          var var1 = JSON.stringify(registro);
       $.ajax({
          url: "{{route ('addSeguimiento')}}",  // Replace with the actual URL where the data will be processed
          type: 'POST',
            data:  var1,
            contentType: 'application/json',
            processData: false,
          success: function(response) {
            $('#output').text('Data added successfully: ' + response);
          },
          error: function() {
            $('#output').text('Error occurred while adding data');
          }
        });
      });

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

            url:"{{ route('getComunas') }}",
            type:"GET",
            data:{parroquia:parroquia}

            }).done(function(data){
                // alert(JSON.stringify(data));
                
                $("#comuna_id").empty();
                $("#comuna_id").html('<option value="">COMUNA<option/>');
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

            url:"{{ route('getComunidad') }}",
            type:"GET",
            data:{comuna:comuna}

            }).done(function(data){
                // alert(JSON.stringify(data));
                
                $("#comunidad_id").empty();
              //  $("#comunidad_id").html('<option value="">COMUNA<option/>');
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

            url:"{{ route('getCoodinacion') }}",
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
        alert(tipo);
        if (tipo == 0){
            $("#denunciado").hide();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
        }

        if (tipo == 1){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
        }

        if (tipo == 2){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
        }
        if (tipo == 3){
            $("#denunciado").show();
            $("#sugerencia").hide();
            $("#beneficiario").hide();
        }
        if (tipo == 4){
            $("#denunciado").hide();
            $("#sugerencia").show();
            $("#beneficiario").hide();
        }
        if (tipo == 5){
            $("#denunciado").hide();
            $("#sugerencia").show();
            $("#beneficiario").hide();
        }
        if (tipo == 6){
            $("#denunciado").hide();
            $("#sugerencia").hide();
            $("#beneficiario").show();
        }
       
    });
  })
</script>
@endsection  