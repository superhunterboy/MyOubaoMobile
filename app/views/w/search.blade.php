@if ($aSearchFields)
<div class="panel panel-default">
      <div class=" panel-body">
{{ Form::open(array('method' => 'get', 'class' => 'form-inline')) }}
        @if (isset($bWithTrashed) && $bWithTrashed)
        <input type="hidden" name="_withTrashed" value="1" />
        @endif
        <?php
        $i = 0;
        $sCalendarJs = '';

        foreach($aSearchFields as $sField => $aInfo):

            $aInputInfo = isset($aInfo['input_info']) ? $aInfo['input_info'] : array();
            $sNodeId = String::camel($sField);
            if ($aInfo['is_date']) {
                    $aInfo['type'] = 'date';
                    $oFormHelper->dateObjects[] = $sField;
                }
            if ($aInfo['type'] == 'select' && is_string($aInfo['options']) && $aInfo['options']{0} == '$'){
                $sVarName = substr($aInfo['options'],1);
                $sModelName::translateArray($$sVarName);
                $aInfo['options'] = $$sVarName;

            }
            $aInfo['div'] = false;
            $aInfo['message'] = false;
            $sLabel = $aInfo['label'];

            $aInfo['label'] = false;
        ?>
            <?php echo $oFormHelper->makeLabel($sField, __($sLangPrev . $sLabel), false, false, false, 'form-group'); ?>
            <div class="form-group">
            <?php echo $oFormHelper->input($sField,isset($$sField) ? $$sField : null,$aInfo, 'input-xs'); ?>
            </div>
        <?php

        endforeach;

        ?>

        <div class="form-group pull-right">
              {{ Form::submit(__('_basic.search',null,1), ['class' => 'btn btn-success btn-xs']) }}
        </div>
    <?php
    echo Form::hidden('is_search');
    echo Form::close();
    ?>
</div>
</div>
@endif

@section('end')
@parent
<script type="text/javascript">
    $(function () {
        $('#download').click(function () {
            $('#user_search_form').attr('action','/users/download');
            $('#user_search_form').submit();
        });
        $('#submitForm').click(function(event) {
            $('#user_search_form').attr('action','/users');
            $('#user_search_form').submit();
        });
    });
</script>

@stop