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
            <thead class="thead-mini  thead-inverse">
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
                    foreach ($aColumnForList as $sColumn) {
                        if (isset($aListColumnMaps[$sColumn])) {
                            $sDisplayValue = $data->{$aListColumnMaps[$sColumn]};
                        } else {
                            if ($sColumn == 'sequence') {
                                $sDisplayValue = Form::text('sequence[' . $data->id . ']', $data->sequence, ['class' => 'form-control', 'style' => 'width:70px;text-align:right']);
                            } else {
                                if (isset($aColumnSettings[$sColumn]['type'])) {
                                    $sDisplayValue = $sColumn . $aColumnSettings[$sColumn]['type'];
                                    switch ($aColumnSettings[$sColumn]['type']) {
                                        case 'bool':
                                            $sDisplayValue = !is_null($data->$sColumn) ? ($data->$sColumn ? __('Yes') : __('No')) : null;
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
    {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
    <?php
        $modalData2['modal'] = [
        'id' => 'myModal2',
        'title' => '分红信息',
        'action' => 'reject-dividen',
        'method' => 'put',
        'message' =>
        join('', [
            '<div class="form-group">',
            '<label for="comment" class="col-sm-5 control-label">拒绝原因：</label>',
            '<div class="col-sm-5">',
            '<textarea name="note" cols="30" rows="2"></textarea>',
            '</div>',
            '</div>'
        ]),
        'footer' =>
        '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.cancel') . '</button>' .
        '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.confirm') . '</button>'
    ];
    ?>
    @include('w.formModal', $modalData2)
</div>
@stop


@section('end')
@parent
<script>
    function modal(href)
    {
        $('#real-delete').attr('action', href);
        $('#myModal').modal();
    }
    function rejectBonus(href)
    {
        $('#reject-dividen').attr('action', href);
        $('#myModal2').modal();
    }
</script>
@stop

