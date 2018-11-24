@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('User Binding') }}
@stop



@section('container')
<div class="col-md-12">

    <div class="h2">{{ __('User Binding') }}
        <div class=" pull-right" role="toolbar" >
            <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
                {{ __('Return') . $resourceName . __('List') }}
            </a>
        </div>
    </div>

    @include('w.breadcrumb')
    @include('w.notification')

    注意：如果使用者看到此页面，请务必联系开发者，daniel

    <div class="panel panel-default">
        <div class=" panel-body">
            {{ Form::open(array('method' => 'get', 'class' => 'form-inline')) }}
                <input type="hidden" name="is_search_form" value="1">
                {{ Form::label('role_id', 'Role Type') }}
                <div class="form-group">
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="" >All</option>
                        @foreach ($aRoles as $key => $sRoleName)
                        <option value="{{ $key }}" {{ (isset($role_id) ? $role_id : Input::get('role_id')) == $key ? 'selected' : '' }}>{{ $sRoleName }}</option>
                        @endforeach
                    </select>
                </div>
                {{ Form::label('is_agent', 'User Type') }}
                <div class="form-group">
                    <select name="is_agent" id="is_agent" class="form-control">
                        <option value="" >All</option>
                        <option value="0" {{ Input::get('is_agent') == '0' }}>Player</option>
                        <option value="1" {{ Input::get('is_agent') == 1 }}>Agent</option>
                    </select>
                </div>
                {{ Form::label('username', ('User Name')) }}
                <div class="form-group">
                    {{ Form::text('username', Input::get('username'), ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    <button type="submit" class="btn  btn-primary"><i class="glyphicon glyphicon-search"></i>{{ __('Search') }}</button>
                </div>
                @foreach ($buttons['pageButtons'] as $element)
                    <div class="form-group">
                       <a  href="{{ $element->route_name ? route($element->route_name) : 'javascript:void(0);' }}" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> {{ __($element->label) }}</a>
                    </div>
                @endforeach
            {{ Form::close() }}


            @if (isset($datas))
                <div class="col-xs-12">
                    <form name="userBindingForm" method="post" action="{{ route($resource . '.bind-user', isset($role_id) && $role_id ? $role_id : null) }}" autocomplete="off">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="removedFromCheckedUsers" value="" />
                        <input type="hidden" name="newUsers" value="" />
                        <div class="col-xs-12">
                            @foreach ($datas as $data)
                            <div class="col-md-3">
                                <label class="checkbox"  for="{{ 'User_' . ($data->id) }}">

                                <input type="checkbox" data-toggle="checkbox" name="user_id[]" id="{{  'User_' . ($data->id) }}" value="{{ $data->id }}" />
                                {{ $data->username }}
                                </label>

                            </div>
                            @endforeach
                        </div>
                        {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
                        <hr>
                        <div class="clearfix">
                            <a href="" class="btn btn-default">{{ __('Reset') }}</a>
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                        </div>
                        <div class="clearfix visible-xs"></div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@stop
