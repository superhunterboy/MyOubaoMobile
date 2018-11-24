@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w._function_title', ['id' => $data->id , 'parent_id' => $data->parent_id])
    @include('w.breadcrumb')
    @include('w.notification')

    <div class="panel panel-default">
        <table class="table table-bordered table-striped">
            <tbody>

                @if(!empty($sParentTitle))

<!--        <tr>
            <th  class="text-right col-xs-2">{{ __('_basic.parent',null,2) }}</th>
            <td>{{ $sParentTitle }}</td>
        </tr>-->
                @endif
                <?php
//    pr($aColumnSettings);
                $i = 0;
                foreach ($aColumnSettings as $sColumn => $aSetting) {
                    if (isset($aViewColumnMaps[$sColumn])) {
                        $sDisplayValue = $data->{$aViewColumnMaps[$sColumn]};
                    }if ($sColumn == 'transaction_pic_url') {
                        // $sDisplayValue = '<a href="'.route('deposits.load-img',[$data->id,$data->$sColumn]).'">查看图片</a>';
                        // $sDisplayValue = '<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="<img src='.route('deposits.load-img',[$data->id,$data->$sColumn]).' ">查看图片</button>';

                        $sDisplayValue = '<a tabindex="0" class="btn btn-xs btn-danger" role="button" data-toggle="popover" data-trigger="focus" data-html="true" data-content="<img src=' . route('deposits.load-img', [$data->id, $data->$sColumn]) . ' >">查看图片</a>';
                    } else {
                        if (isset($aSetting['type'])) {
                            switch ($aSetting['type']) {
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
                                    $sDisplayValue = !is_null($data->$sColumn) ? @${$aSetting['options']}[$data->$sColumn] : null;
                                    break;
                                case 'numeric':
                                case 'date':
                                default:
                                    $sDisplayValue = $data->$sColumn;
                            }
                        } else {
                            $sDisplayValue = $data->$sColumn;
                        }
                    }
                    ?>

                    <tr>
                        <th  class="text-right col-xs-2">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
                        @if($sColumn=='transaction_pic_url')
                        <td class="data-copy"><img src="{{route('exception-deposits.load-img', [$data->id, $data->transaction_pic_url])}}"/></td>
                        @else
                        <td class="data-copy">{{ $sDisplayValue }}</td>
                        @endif
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
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
</script>
@stop
