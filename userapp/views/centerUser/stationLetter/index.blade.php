@extends('l.home')

@section('title')
   站内信
@parent
@stop


@section('main')
<div class="nav-bg">
    <div class="title-normal">站内信</div>
</div>

<div class="content">
    <table width="100%" class="table-info table-toggle">
        <thead>
            <tr>
                <th>标题</th>
                <th>消息类型</th>
                <th>发送时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <!-- TODO 判断已读和未读状态, 根据消息记录中的某个字段 -->
                <tr>
                    <td class="text-left"><a href="{{ route('station-letters.view', $data->id) }}">
                        <i class="{{ !!$data->readed_at ? 'ico-mail-read' : 'ico-mail' }}"></i>
                        {{ $data->msg_title }}</a>
                    </td>
                    <td>{{ $aMsgTypes[$data->type_id] }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                        <a href="{{ route('station-letters.view', $data->id) }}">阅读</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
</div>
@stop
