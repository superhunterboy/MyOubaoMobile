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
            <form method = "POST" action = "{{route('role-users.create')}}" accept-charset = "UTF-8" class = "form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input name='step' value='step1' type='hidden'/>
                <div class = "form-group">
                    <label for = "priority" class = "col-sm-3 control-label">角色</label>
                    <div class = "col-sm-5">
                        <select id = "priority" class = "form-control select-sm" name = "role_id">
                            <option value = "" selected = "selected"></option>
                            @foreach($aUserRoles as $key => $val)
                            <option @if($role_id==$key)selected@endif value = "{{$key }}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class = "form-group">
                    <label for = "sequence" class = "col-sm-3 control-label">用户名</label>
                    <div class = "col-sm-5">
                        <input id = "sequence" class = "form-control" name = "username" type = "text">
                    </div>
                </div>

                <div class = "form-group">
                    <div class = "col-sm-offset-3 col-sm-5">
                        <a class = "btn btn-default" href = "{{ route($resource. '.create', @$data->id) }}">重置</a>
                        <input class = "btn btn-success" type = "submit" value = "搜索">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('end')
{{ script('bootstrap-switch') }}
@parent

@stop
