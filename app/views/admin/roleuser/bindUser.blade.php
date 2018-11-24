@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Create') . $resourceName }}
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
                <input name='step' value='step2' type='hidden'/>
                <input name='role_id' value='{{$role_id}}' type='hidden'/>
                <div class = "form-group">
                    <label for = "role_name" class = "col-sm-3 control-label">角色</label>
                    <div class="col-sm-5">
                        <span class="form-control">
                        {{$aUserRoles[$role_id]}}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="expire_date" class="col-sm-3 control-label">开始时间</label>
                    <div class="col-sm-5">
                            <input id="expire_date" data-date-format="yyyy-mm-dd" class="form-control boot-date" type="text" name="add_date" value="{{@$aSearchFields['created_at'][0]}}" >
                    </div>

                </div>
                <div class="form-group">
                    <label for="expire_date" class="col-sm-3 control-label">过期时间</label>
                    <div class="col-sm-5">
                            <input id="expire_date" class="form-control boot-date" data-date-format="yyyy-mm-dd" type="text" name="expire_date" value="{{@$aSearchFields['created_at'][0]}}" >
                    </div>
                </div>
                @if (isset($aUsers))
                <div class = "form-group">
                    <label class="col-sm-3 control-label">下级用户</label>
                    <div class="col-sm-5">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            @foreach ($aUsers as $key => $val)
                            <label class="btn btn-b btn-sm btn-default">
                                <input type="checkbox"  @if(in_array($key, $aRoleUsers)) checked@endif name="user_id[]" value="{{ $key }}" /> {{$val}}
                            </label>
                            @endforeach
                    </div>
                </div>
                @endif
                <div class = "form-group">
                    <div class = "col-sm-offset-3 col-sm-5">
                        <a class = "btn btn-default" href = "javascript:void();" onclick="history.go(-1)">返回</a>
                        <input class = "btn btn-success" type = "submit" value = "创建"> </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop



