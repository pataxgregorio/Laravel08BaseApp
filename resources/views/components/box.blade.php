<div class="card">   
    <div class="small-box {{$color}} card-body">             
    <!--   <div class="small-box bg-blue card-body">  -->
        <div class="inner">                        
            <h3 style ="font-size:24px;">{{$titulo}}</h3>
            <div class="form-group form-inline">
                {{ trans('message.dashboard_user.mensaje_interno_box') }} {{$cantidad}}&nbsp;&nbsp;{{$name}}
            </div>
        </div>
        <div class="icon">
            <i class="fa fa-folder-open fa-fw"></i>
        </div>
        <div class="small-box-footer">
            {{$titulo}}<i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
</div>
