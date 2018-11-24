@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">
            <form class="form-horizontal" method="post" action="{{ route($resource . '.create') }}" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                @include('admin.user.topAgentForm')


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="reset" class="btn btn-default">{{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@section('end')
@parent
<script type="text/javascript">
    $(function(){

        var quotaFun = function(isVal){
            var minVal= 1970;
            if(isVal >= minVal){
                $("#j-quota").show();
                $("#j-prize-group").html('');
                $("#j-prize-group-input").html('');
                for(var i = 0; i< isVal-minVal+1 ;i++ ){
                    $("#j-prize-group").append('<td>'+ (minVal+i) +'</td>')
                    $("#j-prize-group-input").append('<td><input style="width:50px" name="quota[ '+(minVal+i)+']" type="text" value=""></td>')
                }
            }else{
                $("#j-quota").hide();
            }
        };
        quotaFun($("#prize_group").val());
        $("#prize_group").change(function(event){
            quotaFun($(this).val());
        })
    });
</script>
@stop
