@extends('l.home')

@section('title')
充值确认
@parent
@stop

@section('scripts')
@parent
    {{ script('ZeroClipboard')}}
    {{ script('dsgame.Mask')}}
    {{ script('dsgame.Message')}}
@stop

@section ('main')
<div class="nav-bg">
    <div class="title-normal">
        充值确认
    </div>
</div>
<form action="{{ route('user-recharges.quick', $oPlatform->id) }}" method="post" id="J-form" target="_blank">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    @if ($oPlatform->need_bank)
    <input type="hidden" name="bank" value="{{ $oBank->id }}" />
    @endif
    <input type="hidden" name="amount" value="{{ $fAmount }}" />
    <input type="hidden" name="dodespoit" value="1" />
    <div class="content recharge-confirm">
    <table width="100%" class="table-field" id="J-table">
        <tr>
            <td align="right">充值渠道：</td>
            <td align="left">{{ $oPlatform->display_name }}</td>
        </tr>
        @if ($oPlatform->need_bank)
        <tr>
            <td width="150" align="right" valign="top">银行：</td>
            <td>
                <label class="img-bank" for="J-bank-name-{{ $oBank->identifier }}" style="cursor:default;">
                    <input name="bank[]" id="J-bank-name-{{ $oBank->identifier }}" type="radio" style="visibility:hidden;" />
                    <span class="ico-bank {{ $oBank->identifier }}">{{$oBank->name}}</span>
                </label>
                <br />
            </td>
        </tr>
        @endif
        <tr>
            <td align="right" valign="top">充值金额：</td>
            <td>
                {{ $sDisplayAmount }} 元
            </td>
      </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td>
              <input id="J-submit" class="btn" type="submit" value="   立即充值   " />
          </td>
      </tr>
    </table>
</div>
</form>
@stop

@section('end')
@parent
 <script>
// (function($){
//   ZeroClipboard.setMoviePath('/assets/js/ZeroClipboard.swf');

//   var clip_name = new ZeroClipboard.Client(),
//     clip_card = new ZeroClipboard.Client(),
//     clip_money = new ZeroClipboard.Client(),
//     clip_msg = new ZeroClipboard.Client(),
//     table = $('#J-table'),
//     fn = function(client){
//       var el = $(client.domElement),value = $.trim(el.parent().find('.data-copy').text());
//       client.setText(value);
//       alert('复制成功:\n\n' + value);
//     };

//   clip_name.setCSSEffects( true );
//   clip_card.setCSSEffects( true );
//   clip_money.setCSSEffects( true );
//   clip_msg.setCSSEffects( true );

//   clip_name.addEventListener( "mouseUp", fn);
//   clip_card.addEventListener( "mouseUp", fn);
//   clip_money.addEventListener( "mouseUp", fn);
//   clip_msg.addEventListener( "mouseUp", fn);

//   clip_name.glue('J-button-name');
//   clip_card.glue('J-button-card');
//   clip_money.glue('J-button-money');
//   clip_msg.glue('J-button-msg');


//   var timeDom = $('#J-time-dom'),
//     timeNum = Number($('#J-time-second').val()),
//     timer = setInterval(function(){
//       var m = Math.floor(timeNum/60),
//         s = timeNum%60;
//       m = m < 10 ? '0' + m : m;
//       s = s < 10 ? '0' + s : s;
//       timeDom.text(m + ':' + s);
//       timeNum--;
//       if(timeNum < 0){
//         clearInterval(timer);
//         showTimeout();
//       }
//     }, 1000);



//   var showTimeout = function(){
//     location.href = '/';
//     /**
//     var win = dsgame.Message.getInstance();
//     win.show({
//       content:'<div class="pop-title"><i class="ico-waring"></i><h4 class="pop-text">该订单已失效，请重新发起</h4></div>',
//       confirmIsShow:true,
//       confirmFun:function(){
//         this.hide();
//       },
//       closeIsShow:true,
//       closeFun:function(){
//         this.hide();
//       },
//       mask:true
//     });
//     **/
//   };


// })(jQuery);
</script>
@stop

