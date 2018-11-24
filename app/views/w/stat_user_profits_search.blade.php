@if ($aSearchFields)
{{ Form::open(array('method' => 'get', 'class' => 'form-inline', 'style' => 'background: #F8F8F8;margin-bottom: 5px;text-align: left;padding: 5px;margin-top: -20px;', 'id'=>'stat_user_profit_search_form')) }}
<input id="download_flag" name="download_flag"  value="" type="hidden" />
@if (isset($bWithTrashed) && $bWithTrashed)
<input type="hidden" name="_withTrashed" value="1" />
@endif
<?php
$i = 0;
$sCalendarJs = '';
//        $iRowSize = $aSearchConfig['row_size'];
foreach ($aSearchFields as $sField => $aInfo):
//            if ($i % $iRowSize == 0){
//                echo "<tr>\n";
//            }
    $aInputInfo = isset($aInfo['input_info']) ? $aInfo['input_info'] : array();
    $sNodeId = String::camel($sField);
    if ($aInfo['is_date']) {
        $aInfo['type'] = 'date';
        $oFormHelper->dateObjects[] = $sField;
//            die($$sField);
    }
    if ($aInfo['type'] == 'select' && is_string($aInfo['options']) && $aInfo['options']{0} == '$') {
        $sVarName = substr($aInfo['options'], 1);
        $sModelName::translateArray($$sVarName);
        $aInfo['options'] = $$sVarName;
//                pr($aInfo['options'])
    }
    $aInfo['div'] = false;
    $aInfo['message'] = false;
    $sLabel = $aInfo['label'];
//            die($sLangPrev);
    $aInfo['label'] = false;
    ?>
    <?php echo $oFormHelper->makeLabel($sField, __($sLangPrev . $sLabel), false, false, false, 'form-group'); ?>
    <div class="form-group">
        <?php echo $oFormHelper->input($sField, isset($$sField) ? $$sField : null, $aInfo); ?>
    </div>
    <?php
endforeach;
?>

<div class="form-group">
    <td class="text-right">
        <a class="btn btn-success"  id='submit_user_profits'>搜索</a>
        <a class="btn btn-default"  id="download_user_profits">下载数据报表</a>
    </td>
</div>
<?php
echo Form::hidden('is_search');
echo Form::close();
?>
@endif
@stop
@section('end')
<script type="text/javascript">
    $(function () {
        $('#download_user_profits').click(function () {
            $('#download_flag').val('download');
            $('#stat_user_profit_search_form').submit();
        });

        $('#submit_user_profits').click(function () {
            $('#download_flag').val('');
            $('#stat_user_profit_search_form').submit();
        });

    });
</script>
@stop