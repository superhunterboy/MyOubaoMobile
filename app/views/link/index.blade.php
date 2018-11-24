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

<div class="panel panel-default">

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                @foreach( $aColumnForList as $sColumn )
                <th>{{ (__($sLangPrev . $sColumn, null, 3)) }} {{ $sColumn == 'status_formatted' ? '' :  order_by($sColumn) }}</th>
                @endforeach
                <th>{{ __('_basic.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                @foreach($aColumnForList as $sColumn)
                <?php
                if (isset($aListColumnMaps[$sColumn])) {
                    $sDisplayValue = $data->{$aListColumnMaps[$sColumn]};
                } else {
                    if (isset($aColumnSettings[$sColumn]['type'])) {
                        $sDisplayValue = $sColumn . $aColumnSettings[$sColumn]['type'];
                        switch ($aColumnSettings[$sColumn]['type']) {
                            case 'bool':
                                $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                                break;
                            case 'select':
                                $sDisplayValue = !is_null($data->$sColumn) ? ${$aColumnSettings[$sColumn]['options']}[$data->$sColumn] : null;
                                break;
                            default:
                                $sDisplayValue = is_array($data->$sColumn) ? implode(',', $data->$sColumn) : $data->$sColumn;
                        }
                    } else {
                        $sDisplayValue = $data->$sColumn;
                    }
                    if (array_key_exists($sColumn, $aNumberColumns)) {
                        $sDisplayValue = number_format($sDisplayValue, $aNumberColumns[$sColumn]);
                    }
                    // ----------------- TIP 特殊处理 start -----------------------
                    if ($sColumn == 'created_count') {
                        $sDisplayValue = '<a title="' .  __('_basic.click-to-see-detail')  . '" href="' . route('register-link-users.index', ['register_link_id' => $data->id]) . '">' . $sDisplayValue . '</a>';
                    }
                }
                // ----------------- TIP 特殊处理 end -------------------------
                ?>
                <td>{{ $sDisplayValue }}</td>
                @endforeach
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

<?php
$modalData['modal'] = array(
    'id' => 'myModal',
    'title' => '系统提示',
    'message' => __('_basic.delete-confirm', $aLangVars) . '？',
    'footer' =>
    Form::open(['id' => 'real-delete', 'method' => 'delete']) . '
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-danger">确认删除</button>' .
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