@extends('l.admin', array('active' => 'admin'))


@section('container')
<div class="col-md-12">
    <div class="jumbotron">
      <h3>{{ __('_basic.welcome') }}{{ __('_basic.app-name') }}</h3>
    </div>

    <div class="row">
        <div class="col-xs-3">
          <div class="panel panel-primary">
              <div class="panel-heading">{{ __('APP') . __('Version') }}</div>
              <div class=" panel-body">
                {{ $sysInfo['app_version'] }}
              </div>
          </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-primary">
              <div class="panel-heading">PHP {{ __('Version') }}</div>
               <div class=" panel-body">{{ $sysInfo['php_version'] }}</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-primary">
              <div class="panel-heading">{{ __('Server') . __('OS') }}</div>
              <div class=" panel-body">{{ $sysInfo['os'] }}</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="panel panel-primary">
              <div class="panel-heading">Web {{ __('Server') }}</div>
              <div class=" panel-body">{{ $sysInfo['web_server'] }}</div>
            </div>
        </div>
  </div>
</div>
@stop


