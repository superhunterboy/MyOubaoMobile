@extends('l.admin', ['active' => $resource])

@section('title')
@parent
{{ __('View') . $resourceName }}
@stop

@section('container')
<div class="col-md-12">

    <div class="h2">{{ __($sLangKey, ['resource' => $resourceName]) }}
        <div class=" pull-right" role="toolbar" >
            @include('w.page_link', ['id' => $data->id , 'parent_id' => $data->parent_id])
        </div>
    </div>

    @include('w.breadcrumb')
    @include('w.notification')
    <div class="panel panel-default">
        <div class=" panel-body">
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
                    foreach ($aColumnSettings as $sColumn => $aSetting) {
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
                                    $sDisplayValue = $data->$sColumn ? ${$aSetting['options']}[$data->$sColumn] : null;
                                    break;
                                case 'numeric':
                                case 'date':
                                default:
                                    $sDisplayValue = $data->$sColumn;
                            }
                        } else {
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
                    <tr>
                        <th  class="text-right col-xs-2">{{  __($sLangPrev . 'forefathers', null, 2) }}</th>
                        <td>
                            @if($data->forefathers)
                                @foreach(explode(',',$data->forefathers) as $username)
                                <a style="cursor: pointer" href='{{route('users.index').'?username='.$username}}'>{{$username}} </a> &nbsp;&nbsp;&nbsp;&nbsp;
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

