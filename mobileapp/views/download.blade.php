@extends('l.base')

@section('title')
欧豹娱乐
@parent
@stop

@section('styles')
  @parent
  {{ style('download') }}
@stop

@section ('container')
<div class="main-page show-page">
  <div id="section">
    <div class="logo">
      <img src="/assets/dist/images/apple-touch/icon-60@3x.png" alt="欧豹娱乐">
      <h3>欧豹娱乐</h3>
    </div>
    <div class="text-center">
      <h3>手机端下载</h3>
      <p>提供最全，最佳，最酷的在线互动娱乐服务</p>
    </div>
    <div class="text-center">
      <a class="btn btn-dsbtn" data-download>
        <span class="glyphicon glyphicon-download"></span>
        <span>下载游戏</span>
      </a>
    </div>
  </div>
</div>
@stop

@section('scripts')
@parent
<script type="text/template" id="weixin-tpl">
<div class="weixin-tips">
  <div>
    <span class="span1"><img src="/assets/dist/images/download/arrow.png"></span>
    <span class="span2"><em>1</em> 点击右上角<img src="/assets/dist/images/download/menu.png">打开菜单</span>
    <span class="span2"><em>2</em> 选择<img src="/assets/dist/images/download/safari.png">用Safari打开下载</span>
  </div>
</div>
</script>
<script type="text/template" id="weixin-android-tpl">
<div class="weixin-tips">
  <div>
    <span class="span1"><img src="/assets/dist/images/download/arrow.png"></span>
    <span class="span2"><em>1</em> 点击右上角<img src="/assets/dist/images/download/menu-android.png">打开菜单</span>
    <span class="span2 android_open"><em>2</em> 选择<img src="/assets/dist/images/download/android.png"></span>
  </div>
</div>
</script>

<script>
$(function(){
  var isWeixin = function(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
      return true;
    } else {
      return false;
    }
  };
  var browsers = function() {
    var u = navigator.userAgent;
    return {
      trident: u.indexOf('Trident') > -1,
      presto: u.indexOf('Presto') > -1,
      webKit: u.indexOf('AppleWebKit') > -1,
      gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
      mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/),
      ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
      android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
      iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
      iPad: u.indexOf('iPad') > -1,
      webApp: u.indexOf('Safari') == -1
    };
  }();
  var touchEvent = window.DSGLOBAL['touchEvent'];
  var $weixin;
  $('[data-download]').on(touchEvent, function(){
    if( isWeixin() ){
      if( !$weixin ){
        $weixin = $('<div weixin-tips class="fade hide"></div>').appendTo('.main-page');
        if(browsers.ios || browsers.iPhone || browsers.iPad){
          $weixin.replaceWith( $('#weixin-tpl').html() );
        }else{
          $weixin.replaceWith( $('#weixin-android-tpl').html() );
        }
      }
      $weixin.add('in').removeClass('hide');
    }else{
      window.location.href = '{{Request::root()}}';
    }
    return false;
  });
});
</script>
@stop
