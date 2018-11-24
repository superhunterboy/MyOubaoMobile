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
                <tr>
                    <th  class="text-right col-xs-2">{{ __('_basic.parent',null,2) }}</th>
                    <td>{{ $sParentTitle }}</td>
                </tr>
                @endif
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'id', null, 2) }}</th>
                    <td> <?php echo $data->id; ?></td>
                </tr>
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'qq', null, 2) }}</th>
                    <td><?php echo $data->qq; ?></td>
                </tr>
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'platform', null, 2) }}</th>
                    <td><?php echo $data->platform; ?></td>
                </tr>
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'sale', null, 2) }}</th>
                    <td><?php echo ${$aColumnSettings['sale']['options']}[$data->sale]; ?></td>
                </tr>
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'available_date', null, 2) }}</th>
                    <td>{{__($sLangPrev .${$aColumnSettings['available_date']['options']}[ $data->available_date]).'  '.__($sLangPrev .${$aColumnSettings['available_time']['options']}[ $data->available_time])}}</td>
                </tr>
                <tr>
                    <th  class="text-right col-xs-2">{{ __($sLangPrev . 'screenshot', null, 2) }}</th>
                    <td><img src="{{route('reserve-agents.load-img', $data->id)}}"></td>
                </tr>
                {{--<tr>--}}
                {{--<th  class="text-right col-xs-2">{{ __($sLangPrev . $sColumn, null, 2) }}</th>--}}
                {{--<td>{{ $sDisplayValue }}</td>--}}
                {{--</tr>--}}
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
