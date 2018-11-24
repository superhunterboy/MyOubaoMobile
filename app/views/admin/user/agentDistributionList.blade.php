@extends('l.admin', ['active' => $resource])

@section('title')
@parent
@stop
@section('container')
<div class="col-md-12">

    <div class="h2">{{ __('_function.agent distribution') }}
        <div class=" pull-right" role="toolbar" >
            @include('w.page_link')
        </div>
    </div>

    @include('w.breadcrumb')
    @include('w.notification')


    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach
    <div class="panel panel-default">

        <table class="table table-striped table-hover">
            <thead class="thead-mini  thead-inverse">
                <tr>
                    <th>{{ __('_userprofit.prize group') }} {{ order_by('prize_group') }}</th>
                    <th>{{ __('_user.agent-count') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->prize_group }}</td>
                    <td>{{ $data->num }}</td>
                    <td>
                    @foreach ($buttons['itemButtons'] as $element)
                        @if ($element->isAvailable($data))
                        <a  href="{{ $element->route_name ? route($element->route_name, [$element->para_name => $data->prize_group]) : 'javascript:void(0);'
        }}" class="btn btn-xs btn-default" > {{ __( $element->label) }}</a>
                        @endif
                    @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop