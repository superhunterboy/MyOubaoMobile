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

    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach

    @if ($bSequencable)
    {{ Form::open(['action' => $sSetOrderRoute ]) }}
    @endif
    <div class="panel panel-default">

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                @foreach( $aColumnForList as $sColumn )
                    <th>{{ (__($sLangPrev . $sColumn, null, 3)) }}
                        @if (!in_array($sColumn, $aNoOrderByColumns))
                        {{ order_by($sColumn) }}
                        @endif
                    </th>
                @endforeach
                    <th>{{ __('_basic.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
<?php
foreach ($aColumnForList as $sColumn){
//    $sDisplayColumn = isset($aColumnDisplayMaps[ $sColumn ]) ? $aColumnDisplayMaps[ $sColumn ] : $sColumn;
    if (isset($aListColumnMaps[ $sColumn ])){
        $sDisplayValue = $data->{$aListColumnMaps[ $sColumn ]};
    }
    else{
        if ($sColumn == 'sequence'){
            $sDisplayValue = Form::text('sequence[' . $data->id . ']',$data->sequence,['class' => 'form-control','style' => 'width:70px;text-align:right']);
        }
        else{
            if (isset($aColumnSettings[ $sColumn ][ 'type' ])){
                $sDisplayValue = $sColumn . $aColumnSettings[ $sColumn ][ 'type' ];
                switch ($aColumnSettings[ $sColumn ][ 'type' ]){
                    case 'bool':
                        $sDisplayValue = !is_null($data->$sColumn) ? ($data->$sColumn ? __('Yes') : __('No')) : null;
                        break;
                    case 'select':
                        //                                        $sDisplayValue = (isset($data->$sColumn) && !is_null($data->$sColumn)) ? ${$aColumnSettings[$sColumn]['options']}[$data->$sColumn] : null;
                        $sDisplayValue = !is_null($data->$sColumn) ? ${$aColumnSettings[ $sColumn ][ 'options' ]}[ $data->$sColumn ] : null;
                        break;
                    default:
                        $sDisplayValue = is_array($data->$sColumn) ? implode(',',$data->$sColumn) : $data->$sColumn;
                }
            }
            else{
                $sDisplayValue = $data->$sColumn;
            }
            if (array_key_exists($sColumn,$aNumberColumns)){
                $sDisplayValue = number_format($sDisplayValue,$aNumberColumns[ $sColumn ]);
            }
        }
    }
    echo "<td>$sDisplayValue</td>";
}
?>
                    <td>
                        @include('w.item_link')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="pull-left">
            @if ($bSequencable)
                {{ Form::submit(__('_basic.set-order',null,2), ['class' => 'btn btn-success btn-b btn-xs']) }}
            @endif
        </div>

    {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}

    @if ($bSequencable)
    {{ Form::close() }}
    @endif
<?php
//pr($aLangVars);
//exit;
$modalData['modal'] = array(
    'id'      => 'myModal',
    'title'   => '系统提示',
    'message' => __('_basic.cancel-issue-confirm',$aLangVars) . '？',
    'footer'  =>
        Form::open(['id' => 'cancel-issue', 'method' => 'get']).'
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认</button>'.
        Form::close(),
);
$modalData2['modal'] = array(
    'id'      => 'myModal2',
    'title'   => '系统提示',
    'message' => __('_basic.revise-issue-confirm',$aLangVars) . '？',
    'footer'  =>
        Form::open(['id' => 'revise-issue', 'method' => 'get']).'
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认</button>'.
        Form::close(),
);
$modalData3['modal'] = array(
    'id'      => 'myModal3',
    'title'   => '系统提示',
    'message' => __('_basic.advance-issue-confirm',$aLangVars) . '？',
    'footer'  =>
        Form::open(['id' => 'advance-issue', 'method' => 'get']).'
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-sm btn-danger">确认</button>'.
        Form::close(),
);
?>
    @include('w.modal', $modalData)
    @include('w.modal', $modalData2)
    @include('w.modal', $modalData3)
</div>
@stop


@section('end')
    @parent
    <script>
        function cancelCode(href)
        {
            $('#cancel-issue').attr('action', href);
            $('#myModal').modal();
        }
        function reviseCode(href)
        {
            $('#revise-issue').attr('action', href);
            $('#myModal2').modal();
        }
        function advanceCode(href)
        {
            $('#advance-issue').attr('action', href);
            $('#myModal3').modal();
        }
    </script>
@stop

