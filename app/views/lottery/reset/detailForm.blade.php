<?php
$aAttributes = $isEdit ? $data->getAttributes() : array_combine($aOriginalColumns , array_fill(0,count($aOriginalColumns),null));
//if (!$isEdit && $bTreeable){
//    $data->parent_id = $parent_id;
//}
if (!$isEdit){
    foreach($aInitAttributes as $sColumn => $mValue){
        $data->$sColumn = $mValue;
    }
}
//pr($aInitAttributes);
//pr($functionality_id);
// pr($aColumnSettings);
// exit;
$oFormHelper->setErrorObject($errors);
$sMethod = !$isEdit ? 'POST' : 'PUT';
?>
{{ Form::model($data, array('method' => $sMethod, 'class' => 'form-horizontal')) }}
@foreach ($aAttributes as $sColumn => $sValue)
    <?php
    if ($sColumn == 'id') continue;
    switch($aColumnSettings[$sColumn]['form_type']){
        case 'text':
        case 'textarea':
            $sHtml = $oFormHelper->input($sColumn,null,['id' => $sColumn, 'class' => 'form-control']);
            break;
        case 'bool':
            $sHtml = $oFormHelper->input($sColumn,null,['id' => $sColumn]);
            break;
        case 'select':
            $sHtml = $oFormHelper->input($sColumn, null, ['id' => $sColumn, 'class' => 'form-control', 'options' => ${$aColumnSettings[$sColumn]['options']}, 'empty' => true]);
            break;
        case 'ignore':
            continue 2;
        default:
            $sHtml = Form::input('text',$sColumn,$sValue,['class' => 'form-control']);
    }
    switch($sColumn){
//        case 'start_date':
//        case 'end_date':
//            $sHtml = $oFormHelper->input($sColumn,null,['id' => $sColumn, 'type'=>'date', 'class' => 'form-control']);
//            break;
//        case 'start_time':
//        case 'end_time':
//            $sHtml = $oFormHelper->input($sColumn,null,['id' => $sColumn, 'type'=>'date', 'class' => 'form-control']);
//            break;
//  
           case 'lottery_id':
               $sHtml = $oFormHelper->input($sColumn, $lottery_id, ['id' => $sColumn, 'class' => 'form-control', 'options' => ${$aColumnSettings[$sColumn]['options']}, 'empty' => true]);
               break;
    }
    
    if($sColumn=='week'){
        ?>
        <div class="form-group">
<label for="week" class="col-sm-2 control-label">Week</label>
<div class="col-sm-6">
<input id="week" type="checkbox" name="week" value='1'/>周一
<input id="week" type="checkbox" name="week" value='2'/>周二
<input id="week" type="checkbox" name="week" value='3'/>周三
<input id="week" type="checkbox" name="week" value='4'/>周四
<input id="week" type="checkbox" name="week" value='5'/>周五
<input id="week" type="checkbox" name="week" value='6'/>周六
<input id="week" type="checkbox" name="week" value='0'/>周日

</div>


<div class="col-sm-4">
</div>

</div>
<?php 
    }else{
    ?>

            {{ $sHtml }}
    <?php } ?>

@endforeach
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <a class="btn btn-default" href="{{ route($resource.'.edit', $data->id) }}">{{ __('Reset') }}</a>
      {{ Form::submit(__('Submit'), ['class' => 'btn btn-success']) }}
    </div>
</div>
{{Form::close()}}
