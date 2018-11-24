@extends('l.base')

@section('title')
资金明细
@parent
@stop

@section('styles')
@parent
{{ style('ucenter') }}
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <a href="{{route('mobile-users.index')}}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">资金明细</h1>
  </div>

  <div id="section">

    <div class="ds-tabs funds-detail-tabs">
      <ul class="nav nav-tabs nav-tabs4">
        <li class="{{Route::current()->getName() == 'mobile-transactions.index' ? 'active': ''}}"><a href="{{ route('mobile-transactions.index') }}">所有</a></li>
        <li class="{{Route::current()->getName() == 'mobile-transactions.mytransfer' ? 'active': ''}}"><a href="{{ route('mobile-transactions.mytransfer') }}">转账</a></li>
        <li class="{{Route::current()->getName() == 'mobile-transactions.mydeposit' ? 'active': ''}}"><a href="{{ route('mobile-transactions.mydeposit',Session::get('user_id')) }}">充值</a></li>
        <li class="{{Route::current()->getName() == 'mobile-transactions.mywithdraw' ? 'active': ''}}"><a href="{{ route('mobile-transactions.mywithdraw',Session::get('user_id')) }}">提现</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active">
          <table class="table table-striped">
            <tbody>
              @if (count($datas))
              @foreach ($datas as $data)
              <tr>
                <td>{{ $data->friendly_description }}<br><small>{{$data->created_at}}</small></td>
                <td><span class="{{ $data->amount_formatted < 0 ? 'c-green' : 'c-red' }}">{{ $data->amount_formatted }}</span></td>
              </tr>
              @endforeach
              @else
              <tr><td colspan="2">
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

@section('scripts')
@parent
<script>
</script>
@stop