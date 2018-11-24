@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ __('Modify User Prize Group') }}
@stop

@section('container')
<div class="col-md-12">
     <div class="h2">{{ __('Modify User Prize Group') }}
        <div class=" pull-right" role="toolbar" >
            @include('w.page_link')
        </div>
    </div>
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
    <div class="panel-body">
    <form class="form-horizontal" method="post" action="{{ route($resource . '.set-agent-prize-group', $id) }}" autocomplete="off">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="form-group">
            <label for="username" class="col-sm-3 control-label">{{ __('User Name') }}</label>
            <div class="col-sm-5">
                <span class="form-control">{{ isset($data) ? $data->username : '' }} </span>
            </div>
        </div>
        <div class="form-group">
            <label for="prize_group" class="col-sm-3 control-label">{{ __('Exist Prize Group') }}</label>
            <div class="col-sm-5">
                <span class="form-control">{{ isset($data) ? $data->prize_group : '' }}</span>
            </div>
        </div>
        <div class="form-group">
            <label for="prize_group" class="col-sm-3 control-label">{{ __('New Prize Group') }}</label>
            <div class="col-sm-5">
                <select class="form-control" name="prize_group" id="prize_group" >
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach ($aLimitPrizeGroups as $iPrizeGroup)
                        <option value="{{ $iPrizeGroup }}" >{{ $iPrizeGroup }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="valid_days" class="col-sm-3 control-label">{{ __('Valid Days') }}</label>
            <div class="col-sm-5">
                <select class="form-control" name="valid_days" id="valid_days" >
                    <option value="">{{ __('Please Select') }}</option>
                    @foreach ($aLimitDays as $iDay)
                        <option value="{{ $iDay }}" >{{ $iDay ? $iDay . __(' day') : __('Forever') }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <a class="btn btn-default" href="{{ route('users.agent-prize-group', ['is_agent' => 1]) }}">{{ __('Cancel') }}</a>
              <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
            </div>
        </div>
    </form>
    </div>
    </div>
</div>
@stop