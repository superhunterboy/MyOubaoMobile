@extends('l.home')

@section('title')
   平台公告
@parent
@stop


@section('main')
<div class="nav-bg">
    <div class="title-normal">平台公告</div>
</div>

<div class="content">
    <table width="100%" class="table-info">
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td class="text-left"><a href="{{route('announcements.view', $data->id)}}">{{ $data->title }}</a></td>
                    <td class="text-right">{{ $data->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
</div>
@stop
