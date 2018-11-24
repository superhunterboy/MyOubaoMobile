@extends('l.admin', ['active' => $resource])

@section('title')
@parent
{{ __('View') . $resourceName }}
@stop

@section('container')
@include('w.breadcrumb')

    <div class="h2">{{ __($sLangKey, ['resource' => $resourceName]) }}
        <div class=" pull-right" role="toolbar" >
        @include('w.page_link', ['id' => $data->id , 'parent_id' => $data->parent_id])
        </div>
    </div>


    @include('w.notification')

    <div class="panel panel-default">
    <table class="table table-bordered table-striped">
        <tbody>
    @if(isset($sParentTitle))

          <tr>
            <th  class="text-right col-xs-2">{{ __('Parent') }}</th>
            <td>{{ $sParentTitle }}</td>
        </tr>
    @endif
    <?php $i = 0; ?>
    <?php
    foreach($aColumnSettings as $sColumn => $aSetting){
        if (isset($aSetting['type'])){
            switch($aSetting['type']){
                case 'ignore':
                    continue 2;
                    break;
                case 'bool':
                    $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                    break;
                case 'text':
                    $sDisplayValue = nl2br($data->$sColumn);
                    break;
                case 'select':
                    $sDisplayValue = $data->$sColumn ? ${$aSetting['options']}[$data->$sColumn] : null;
                    break;
                case 'numeric':
                case 'date':
                default:
                    $sDisplayValue = $data->$sColumn;
            }
        }
        else{
            $sDisplayValue = $data->$sColumn;
        }

        ?>

        <tr>
            <th  class="text-right col-xs-2">{{  __($sLangPrev . $sColumn, null, 2) }}</th>
            <td>{{ $sDisplayValue }}</td>
        </tr>
<?php
    }
    ?>
    </tbody>
    </table>
    </div>
</div>

@stop

