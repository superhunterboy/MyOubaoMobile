@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title', ['id' => $data->id , 'parent_id' => $data->parent_id])

    @include('w.notification')

    <div class="panel panel-default">
    <table class="table table-bordered table-striped">
        <tbody>

        @if(!empty($sParentTitle))
            <tr>
                <th  class="text-right col-xs-2">{{ __('Parent') }}</th>
                <td>{{ $sParentTitle }}</td>
            </tr>
        @endif
            <?php $i = 0;
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
                    <th class="text-right col-xs-2">{{ __($sColumn) }}</th>
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
