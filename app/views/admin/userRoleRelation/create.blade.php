@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('updateUserBinding') }}
@stop



@section('container')


<div class="col-md-12">
    <div class="h2">{{ __('updateUserBinding') }}
        <div class=" pull-right" role="toolbar" >
            <a href="{{ route($resource.'.index') }}" class="btn btn-sm btn-default">
                {{ __('Return') . $resourceName . __('List') }}
            </a>
        </div>
    </div>
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">
            {{ Form::open(array('method' => 'get', 'class' => 'form-inline', 'style' => 'background: #F8F8F8;margin-bottom: 5px;text-align: left;padding: 5px;margin-top: -20px;')) }}
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
            <div>
                <form name="userBindingForm" method="post" action="{{ route($resource . '.updateUserBinding', $role_id) }}" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="removedFromCheckedUsers" value="" />
                    <input type="hidden" name="newUsers" value="" />
                    <div class="col-xs-12">
                        @foreach ($datas as $oUser)
                        <div class="col-md-3">
                            <label class="checkbox"  for="{{ 'User_' . ($oUser->id) }}">

                            <input type="checkbox" data-toggle="checkbox" name="user_id[]" id="{{  'User_' . ($oUser->id) }}" value="{{ $oUser->id }}" />
                            {{ $oUser->username }}
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
        </div>
    </div>
</div>

@stop