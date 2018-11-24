@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop
@section('container')


<div class="col-md-12">


    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')
    <?php
    if (isset($aTotalColumns)){
        $aTotals = array_fill(0, count($aColumnForList),null);
        $aTotalColumnMap = array_flip($aColumnForList);
    }
    ?>
    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach

    <div class="panel panel-default">

        <table class="table table-striped table-hover">
            <thead class="thead-mini thead-inverse">
                <tr>
                @foreach( $aColumnForList as $sColumn )
                    <th>{{ __(String::humenlize($sColumn)) }} {{ order_by($sColumn) }}</th>
                @endforeach
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td> {{ $data->name}}</td>
                     <td>{{ $data->content }}</td>
                    <td><img src="{{ $data->pic_url }}" width="50px"></td>
                    <td>{{$data->is_closed ? __('Yes'):    __('No') }}</td>
                    <td>{{ $data->redirect_url }}</td>
                    <td>{{ $data->creator_name }}</td>
                    <td>{{  $aLocations[ $data->ad_location_id]}}</td>
                    <td>@include('w.item_link')</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
    </div>

<?php
$modalData['modal'] = array(
    'id'      => 'myModal',
    'title'   => '系统提示',
    'message' => '确认删除此'.$resourceName.'？',
    'footer'  =>
        Form::open(['id' => 'real-delete', 'method' => 'delete']).'
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认删除</button>'.
        Form::close(),
);
?>
    @include('w.modal', $modalData)

@stop

@section('end')
    @parent
    <script>
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
    </script>
@stop

