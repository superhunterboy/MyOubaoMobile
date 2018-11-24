@extends('l.base')

@section('title')
公告
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
      <a href="{{ route('mobile-users.index') }}" class="history-back"><span class="unicode-icon-prev"></span></a>
    </div>
    <h1 class="media-body">公告</h1>
  </div>

  <div id="section">

    <div class="ds-tabs">
      <ul class="nav nav-tabs nav-tabs2">
        <li><a href="{{route('mobile-station-letters.index')}}">站内信</a></li>
        <li class="active"><a href="{{ route('mobile-announcements.index') }}">公告</a></li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active">
          <table class="table table-striped">
            <tbody>
              @if(count($datas))
              @foreach ($datas as $data)
              <tr>
                <td data-page-tab=".article-page" data-href="{{ route('mobile-announcements.view', $data->id) }}">
                  <a>{{ $data->title }}</a><br>
                  <small>{{$data->created_at}}</small>
                </td>
              </tr>
              @endforeach
              @else
              <tr><td>
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

<div class="article-page hide-page">
  <div data-fixed-top class="top-nav media">
    <div class="media-left media-middle">
      <div data-page-tab=".main-page" class="history-back"><span class="unicode-icon-prev"></span></div>
    </div>
    <h1 class="media-body">公告内容</h1>
  </div>
  <div class="article-content" data-article-content></div>
</div>
@stop

@section('scripts')
@parent
<script>
$(function(){
  var $loading;
  $(document).on('dsPageAnimate:before', function(event, $hidden, $visible, $handler){

    var content = $(this).data('content');
    var $wrap = $('[data-article-content]');
    if( content ) return $wrap.html( html );

    var url = $handler.data('href');

    if( url ){
      $.ajax({
        url: url,
        dataType: 'html',
        method: 'GET',
        beforeSend:function(){
          $loading = $loading || DSGLOBAL.getAjaxLoading();
          $('body').append($loading);
        },
        success: function(resp){
          var html = resp.replace(/<p><br\/><\/p>/g, '').replace(/<p>&nbsp;<\/p>/g, '');
          $wrap.html( html );
          $handler.data('content', html).addClass('c-gray');
        },
        complete: function(){

        },
        error: function(){
          $loading.remove();
        }
      });
    }
  });
});
</script>
@stop
