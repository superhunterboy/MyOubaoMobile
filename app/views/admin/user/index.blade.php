@extends('l.admin', ['active' => $resource])

@section('title')
@parent
{{ $resourceName . __('Management') }}
@stop
@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

    @foreach($aWidgets as $sWidget)
    @include($sWidget)
    @endforeach

    <div class="panel">
        <table class="table table-striped table-hover">
            <thead class="thead-mini  thead-inverse">
                <tr>
                    @foreach( $aColumnForList as $sColumn )
                    <th>
                        {{ __($sLangPrev . $sColumn) }}
                        @if (!in_array($sColumn, $aNoOrderByColumns))
                        {{ order_by($sColumn) }}
                        @endif
                    </th>
                    @endforeach
                    <th>{{ __('Actions') }}</th>
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
    $aBlockedTypes = array_slice($aBlockedTypes, 1);
    $aBlockedTypeSelects = '';
    foreach ($aBlockedTypes as $element => $value) {
        $aBlockedTypeSelects .= '<option value="' . ((int) $element + 1) . '">' . __('_user.' . $value) . '</option>';
    }

    $modalData['modal'] = [
        'id' => 'myModal',
        'title' => 'Action Confirmation',
        'message' => __('Confirm execute this action ?'),
        'footer' =>
        Form::open(['id' => 'real-delete', 'method' => 'delete']) . '
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('Cancel') . '</button>
                <button type="submit" class="btn btn-sm btn-danger">' . __('Confirm Delete') . '</button>' .
        Form::close(),
    ];
    $modalData2['modal'] = [
        'id' => 'myModal2',
        'title' => __('_user.block-user-title'),
        'action' => 'block-user',
        'method' => 'put',
        'message' =>
        join('', [
            '<div class="form-group">',
            '<label for="blocked" class="col-sm-5 control-label">' . __('_user.block-type') . '</label>',
            '<div class="col-sm-5">',
            '<select class="form-control" name="blocked" id="blocked" >',
            $aBlockedTypeSelects,
            '</select>',
            '</div>',
            '</div>',
            '<div class="form-group">',
            '<label for="is_include_children" class="col-sm-5 control-label">' . __('_user.include-sub-users') . '</label>',
            '<div class="col-sm-5">',
            '<div class="switch " data-on-label="' . __('Yes') . '"  data-off-label="' . __('No') . '">',
            '<input type="checkbox" name="is_include_children" id="is_include_children" value="1">',
            '</div>',
            '</div>',
            '</div>',
            '<div class="form-group">',
            '<label for="comment" class="col-sm-5 control-label">' . __('_usermanagelog.comment') . '</label>',
            '<div class="col-sm-5">',
            '<textarea name="comment" cols="30" rows="2"></textarea>',
            '</div>',
            '</div>'
        ]),
        'footer' =>
        '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.cancel') . '</button>' .
        '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.confirm') . '</button>'
    ];
    $modalData3['modal'] = [
        'id' => 'myModal3',
        'title' => __('_user.unblock-user-title'),
        'action' => 'unblock-user',
        'method' => 'put',
        'message' =>
        join('', [
            '<div class="form-group">',
            '<label for="is_include_children" class="col-sm-5 control-label">' . __('_user.include-sub-users') . '</label>',
            '<div class="col-sm-5">',
            '<div class="switch " data-on-label="' . __('Yes') . '"  data-off-label="' . __('No') . '">',
            '<input type="checkbox" name="is_include_children" id="is_include_children" value="1">',
            '</div>',
            '</div>',
            '</div>',
            '<div class="form-group">',
            '<label for="comment" class="col-sm-5 control-label">' . __('_usermanagelog.comment') . '</label>',
            '<div class="col-sm-5">',
            '<textarea name="comment" cols="30" rows="2"></textarea>',
            '</div>',
            '</div>'
        ]),
        'footer' =>
        '<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">' . __('_function.cancel') . '</button>' .
        '<button type="submit" class="btn btn-sm btn-danger">' . __('_function.confirm') . '</button>'
    ];
    ?>
    @include('w.modal', $modalData)
    @include('w.formModal', $modalData2)
    @include('w.formModal', $modalData3)
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
    function setBlockedStatus(href, username)
    {
        $('#block-user').attr('action', href);
        $('#myModal2').modal();
    }
    function setUnblockedStatus(href, username)
    {
        $('#unblock-user').attr('action', href);
        $('#myModal3').modal();
    }

</script>
@stop

