@extends('l.admin', ['active' => $resource])
@section('title')
@parent

@stop
@section('container')
<div class="col-md-12">
    <div class="h2">{{ __('_function.agent prize groups') }}</div>
    @include('w.breadcrumb')
    @include('w.notification')

    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach

    <div class="panel panel-default">
        <table class="table table-striped table-hover">
            <thead class="thead-mini thead-inverse">
                <tr>
                    <th>{{ __('_user.username') }} {{ order_by('username') }}</th>
                    <th>{{ __('_user.is_agent') }}</th>
                    <th>{{ __('_userprofit.prize group') }} {{ order_by('prize_group') }}</th>
                    <th>{{ __('Actions') }} </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->username }}</td>
                    <td>{{ $data->user_type_formatted }}</td>
                    <td>{{ $data->prize_group }}</td>
                    <td>
                        @include('w.item_link')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
</div>
@stop



