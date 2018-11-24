@extends('l.home')

@section('title')
   链接管理 -- 已开户用户
@parent
@stop

@section('scripts')
@parent
    {{ script('jquery.jscrollpane') }}
    {{ script('dsgame.DatePicker') }}
@stop

@section('main')
<div class="nav-bg nav-bg-tab">
    <div class="title-normal">用户管理</div>
    <ul class="tab-title clearfix">
        <li><a href="{{ route('users.accurate-create') }}" ><span>精准开户</span></a></li>
        <li><a href="{{ route('user-links.create') }}"><span>链接开户</span></a></li>
        <li><a href="{{ route('users.index') }}"><span>用户列表</span></a></li>
        <li class="current"><a href="{{ route('user-links.index') }}"><span>链接管理</span></a></li>
    </ul>
</div>

<div class="content">

    <table width="100%" class="table table-toggle" id="J-table">
        <thead>
            <tr>
                <th>用户名</th>
                <th>注册时间</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class=" table-tr-item ">
                <td>{{ $data->username }}</td>
                <td>{{ $data->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
</div>
@stop