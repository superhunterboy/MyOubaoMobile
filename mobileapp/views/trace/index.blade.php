@extends('l.base')

@section('title')
追号记录
@parent
@stop

@section('styles')
@parent
{{ style('ucenter') }}
@stop

@section ('container')

<div class="main-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <a href="{{ route('mobile-users.index') }}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">追号记录</h1>
  </div>

  <div id="section">

    <div class="ds-tabs">
      <ul class="nav nav-tabs nav-tabs2">
        <li><a href="{{ route('mobile-projects.index') }}">投注记录</a></li>
        <li class="active"><a href="{{ route('mobile-traces.index') }}">追号记录</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active record-table">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>游戏</th>
                <th>开奖号码</th>
                <th>总金额</th>
                <th>状态</th>
              </tr>
            </thead>
            <tbody>
            @if (count($datas))
              @foreach ($datas as $data)
              <tr data-table-link="{{ route('mobile-traces.view', $data->id) }}">
                <td>
                  <span class="c-highlight">{{ $aLotteries[$data->lottery_id] }}</span><br>
                  <small>{{ $data->title }}</small>
                </td>
                <td class="text-left">
                  <span class="label label-default">期号</span> {{ $data->start_issue }}<br>
                  <span class="label label-default">追号</span> {{ $data->finished_issues }} / {{ $data->total_issues }}  期
                </td>
                <td>{{ $data->amount_formatted }}</td>
                <td><a href="{{ route('mobile-traces.view', $data->id) }}">{{ $data->formatted_status }}</a></td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="4">
                <br>
                <p class="text-center">对不起，没有符合条件的记录</p>
              </td></tr>
            @endif
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>
</div>
@stop
