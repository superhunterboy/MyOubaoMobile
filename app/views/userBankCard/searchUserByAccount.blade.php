@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop
@section('container')
<div class="col-md-12">

    <div class="h2">{{ __('_function.search by bank card') }} </div>

    @include('w.breadcrumb')
    @include('w.notification')


    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach
    <div class="panel panel-default">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                @foreach( $aColumnForList as $sColumn )
                    <th>{{ (__($sLangPrev . $sColumn, null, 3)) }} {{ order_by($sColumn) }}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->username }}</td>
                    <td>{{ $data->parent_username }}</td>
                    <td>{{ $data->bank }}</td>
                    <td>{{ $data->province }}</td>
                    <td>{{ $data->city }}</td>
                    <td>{{ yes_no($data->is_blocked) }}</td>
                    <td>{{ $data->blocked_type }}</td>
                    <td>{{ yes_no($data->is_tester) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
    </div>
@stop



