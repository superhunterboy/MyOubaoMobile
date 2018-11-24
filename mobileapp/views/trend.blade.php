@extends('l.base')

@section('title')
开奖走势
@parent
@stop

@section('styles')
@parent
{{ style('trend') }}
@stop

@section('bodyClass')
<body class="trend">
@stop

@section ('container')
<div class="main-page show-page">
  <div data-fixed-top class="top-nav media">
    <h1 class="media-body">开奖走势</h1>
  </div>

  <div id="section">
    @foreach($aIssues as $iLotteryId => $aIssue)
    <?php
    $gameClassName = '';
    // 最近期期号
    $firstIssue = $aIssue[0]['number'];
    if( in_array($iLotteryId,[1,6,7,11,23,24]) ){
      $gameClassName = 'latest-lottery-ssc';
      // 最近期开奖号码
      $firstCodes = str_split( $aIssue[0]['code'], 1 );
    }else if( in_array($iLotteryId,[2,8,9,12]) ){
      $gameClassName = 'latest-lottery-l115';
      // 最近期开奖号码
      $firstCodes = explode( ' ', $aIssue[0]['code'] );
    }else if( in_array($iLotteryId,[53]) ){
      $gameClassName = 'latest-lottery-pk10';
      // 最近期开奖号码
      $firstCodes = explode( ',', $aIssue[0]['code'] );
    }else if( in_array($iLotteryId,[13,14,20,21,22]) ){
      $gameClassName = 'latest-lottery-other';
      // 最近期开奖号码
      $firstCodes = str_split( $aIssue[0]['code'], 1 );
    }else{
      continue;
    }
    ?>
    <div class="latest-lottery {{ $gameClassName }}">
      <div class="media">
        <div class="media-body">
          <div class="media-heading media">
            <h4 class="media-body">
              <strong>{{ $aLotteries[$iLotteryId] }}</strong>
              <small>&nbsp;&nbsp;第<span>{{ $firstIssue }}</span>期</small>
            </h4>
            <div class="media-right media-middle">
              <a href="{{route('mobile-bets.betform', $iLotteryId)}}" class="btn btn-link c-highlight">立即投注</a>
            </div>
          </div>
          <div
            data-page-tab=".trend-page"
            data-lottery-name="{{ $aLotteries[$iLotteryId] }}"
            data-lottery-id="{{ $iLotteryId }}"
          >
                        <ul class="lottery-number active">
                <?php $i=0;  ?>
              @foreach( $firstCodes as $code )
              <li>
                <div data-value="{{ $code }}" class="number-front"></div>
                <div data-value="0" class="number"></div>
              </li>
              @if($i==4)
              <br>
              @endif
              <?php  $i++;  ?>
              @endforeach
            </ul>
            <dl class="lottery-list clearfix">
            @foreach( $aIssue as $key => $issue )
              @if( $key > 0 )
              <dt>第<span>{{ $issue['number'] }}</span>期</dt>
              <dd>{{ $issue['code'] }}</dd>
              @endif
            @endforeach
            </dl>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @include('w.bottom-nav')
</div>

<div class="trend-page hide-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <div class="action-back" data-page-tab=".main-page"><span class="unicode-icon-prev"></span></div>
    </div>
    <h2 class="media-body" data-lottery-name-element></h2>
  </div>
  <div class="trend-content">
    <div data-lottery-issue-element></div>
  </div>
  <div data-fixed-bottom class="trend-nav">
    <a data-lottery-link class="ds-btn">立即投注</a>
  </div>
</div>

@stop

@section('scripts')
@parent
<script>
$(function(){

  $('.trend-content').css({
    height: $(window).height() - $('[data-fixed-top]:eq(0)').outerHeight() - $('[data-fixed-bottom]:eq(1)').outerHeight(),
    overflowY: 'auto'
  });

  $(document).on('dsPageAnimate:before', function(event, $hidden, $visible, $handler){
    var oldId;
    var lotteryId = $handler.data('lottery-id');
    var url = '{{route("mobile-lotteries.load-issues")}}';
    var beturl = '{{route("mobile-bets.betform")}}';
    var $loading;
    var getAjaxLoading = DSGLOBAL['getAjaxLoading'];
    var $title = $('[data-lottery-name-element]');
    var $target = $('[data-lottery-issue-element]');
    var $link = $('[data-lottery-link]');
    if( !lotteryId || !$handler.length || oldId == lotteryId ) return;
    $link.attr('href', beturl + '/' + lotteryId);
    $.ajax({
      url: url + '/' + lotteryId,
      method: 'GET',
      dataType: 'json',
      beforeSend:function(){
        $loading = $loading || getAjaxLoading();
        $target.html($loading);
      },
      success: function(resp){
        if( resp['isSuccess'] ){
          var data = resp['data'][lotteryId];
          var html = '<table class="table table-striped"><tbody';
          $.each(data, function(i, issue){
            var number = issue['number'];
            var code = issue['code'];
            if( code.indexOf(' ') < 0 ){
              code = code.split('').join(' ');
            }
            html += '<tr><td>' +
              '<span>第 ' +number+ ' 期开奖号码<br></span>' +
              '<big class="c-highlight issue-lottery-number">' +code+ '</big>' +
            '</td></tr>';
          });
          html += '</tbody></table>';
          $title.html( $handler.data('lottery-name') );
          $target.html( html );
          oldId = lotteryId;
        }
      },
      error: function(){
        $loading.remove();
      }
    })
  });
});
</script>
@stop
