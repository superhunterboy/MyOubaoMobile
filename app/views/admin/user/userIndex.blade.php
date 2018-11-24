@extends('l.admin', ['active' => $resource])

@section('title')
@parent
{{ $sPageTitle }}
@stop
@section('styles')
@parent
<style>
   body{ background: none}
     .table .thead-mini>tr>th,.table>tbody>tr>td,.btn-default{ padding: 1px;  vertical-align: middle;text-align: center;}
      .thList{background:-webkit-gradient(linear, 50% 50%, 50% 0%, from(#6FCBFC), to(#A7E7FF)); height: 20px; line-height: 20px; text-align: center;border-bottom: 1px solid #339DC5; }
  .thList th{height: 20px; line-height: 20px; text-align: center; }
  .table>thead>tr>th{ padding: 5px;}
  .thead{ position: fixed; top: 0; width:100%; z-index: 2;}
  .mind{ position: relative;}
  .tbody{  margin-top: 20px;}
</style>
@stop
@section('container')
    @include('w.notification')
    <div class="mind">
        <table class="thead">
            <thead>
                <tr class="thList">
                     <th width="90">上级</th>
                     <th width="90">用户名</th>
                     <th width="80">昵称</th>
                     <th width="60">余额</th>
                     <th width="60">奖金组</th>
                     <th width="50">冻结</th>
                     <th width="90">激活时间</th>
                     <th width="80">最后登陆</th>
                     <th width="90">创建</th>
                     <th width="30">代理？</th>
                     <th width="30">测试？</th>
                     <th width="300">{{ __('Actions') }}</th>
                </tr>
            </thead>
        </table>
    <table class="table table-striped table-hover table-bordered tbody">
        <tbody>
        <?php
            $w = [90,90,80,60, 60, 50, 90, 80, 90, 30, 30];
        ?>
            @foreach ($datas as $data)
            <tr>
                <?php
                foreach ($aColumnForList as $key=>$sColumn) {
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
                    echo '<td  width="'.$w[$key].'px">'.$sDisplayValue.'</td>';
                }
                ?>
                <td width="300px">
                    @include('w.item_link_group')
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
    $('[data-toggle="popover"]').popover();
</script>
@stop

