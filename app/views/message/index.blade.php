@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">

    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

    @foreach($aWidgets as $sWidget)
        @include($sWidget)
    @endforeach
    <div class="panel panel-default">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ __('_msguser.status') }}</th>
                    <th>{{ __('_msguser.msg_title') }} {{ order_by('msg_title') }}</th>
                    <th>{{ __('_msguser.type_id') }} {{ order_by('type_id') }}</th>
                    <th>{{ __('_msguser.sender') }} {{ order_by('sender') }}</th>
                    <th>{{ __('_msguser.receiver') }} {{ order_by('receiver') }}</th>
                    <th>{{ __('_msguser.created_at') }} {{ order_by('created_at') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $aDeletedStatus[(int)!!$data->deleted_at] }}</td>
                    <td>{{ '[' . $aReadedStatus[(int)!!$data->readed_at] . ']' }} <a href="{{ route('msg-users.view', $data->id) }}">{{ $data->msg_title }}</a></td>
                    <td>{{ $aMsgTypes[$data->type_id] }}</td>
                    <td>{{ $data->sender }}</td>
                    <td>{{ $data->receiver }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        @foreach ($buttons['itemButtons'] as $element)
                            @if ($element->btn_type == 1)
                            <a href="javascript:void(0)" class="btn btn-xs   btn-danger"
                             onclick="modal('{{ $element->route_name ? route($element->route_name, $data->id) : 'javascript:void(0);' }}')">{{ __( $element->label) }}</a>
                            @elseif ($element->btn_type == 2)
                            <a href="{{ $element->route_name ? route($element->route_name, $data->id) : 'javascript:void(0);' }}" class="btn btn-xs   btn-success">{{ __( $element->label) }}</a>
                            @else
                            <a  href="{{ $element->route_name ? route($element->route_name, str_contains($element->route_name, 'index') ? ['id' => $data->id] : $data->id) : 'javascript:void(0);' }}" class="btn btn-xs   btn-default" > {{ __( $element->label) }}</a>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        {{ pagination($datas->appends(Input::except('page')), 'p.slider-3') }}
    </div>

    <?php
        $modalData['modal'] = array(
            'id'      => 'myModal',
            'title'   => '系统提示',
            'message' => '确认删除此'.$resourceName.'？',
            'footer'  =>
                Form::open(array('id' => 'real-delete', 'method' => 'delete')).'
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-danger">确认删除</button>'.
                Form::close(),
        );
    ?>
    @include('w.modal', $modalData)

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


