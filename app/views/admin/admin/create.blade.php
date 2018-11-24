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
            <div class="panel-body">
                <form class="form-horizontal" method="post" action="{{ route($resource.'.create') }}" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        @include('admin.admin.detailForm')

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="reset" class="btn btn-default">{{ __('Reset') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

