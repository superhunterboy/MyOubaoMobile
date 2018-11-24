@extends('l.base')
@section ('metas')
@parent
<meta http-equiv="Expires" CONTENT="0">
<meta http-equiv="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Pragma" CONTENT="no-cache">
@stop

@section ('styles')

@parent
    {{ style('game') }}
    <link rel="stylesheet" media="print" href="/assets/images/ucenter/print.css">
@stop

@section ('container')
<div class="body hidden-when-printed">
    @include('w.top-header')

    @include('w.nav')

    <div class="main-content wrap">
        <div class="wrap-inner clearfix">

            <div id="content" class="left">
            @include('w.game-info')
                <div class="game-board">
                    @include('w.play-select')
                    <div class="number-section">
                        <div class="section-label"><span>选择幸运号码</span></div>
                        <div class="section-inner">
                            <div class="game-method-prize" id="J-method-prize">单注最高奖金<span class="c-highlight" >0.00</span>元</div>
                            @section ('centerGame')
                            @show
                            @include('w.ball-statistics-panel')
                        </div>
                    </div>
                    @include('w.lottery-box')
                    @include('w.game-record')
                </div>
            </div>
            @include('w.game-left')
        </div>
    </div>
    @include('w.trace-panel')
    @include('w.footer')
</div>
<div style="display:none;width:48mm" id="print-project-panel"></div>
@stop


@section('scripts')
@parent


	{{ script('dsgame.Tab')}}
	{{ script('dsgame.Hover')}}
	{{ script('dsgame.Select')}}
	{{ script('dsgame.Timer')}}
    {{ script('dsgame.Message')}}
    {{ script('dsgame.MiniWindow')}}
    {{ script('dsgame.SliderBar')}}
	{{ script('dsgame.Tip')}}
@stop


@section('end')
@parent
    {{ script('dsgame.Gamesall.min') }}


    @include('w.notification')
    <script type="text/javascript">
	(function(){
        if ($('#popWindow').length) {
            // $('#myModal').modal();
            var popWindow = new dsgame.Message();
            var data = {
                title          : '提示',
                content        : $('#popWindow').find('.pop-bd > .pop-content').html(),
                closeIsShow    : true,
                closeButtonText: '关闭',
                closeFun       : function() {
                    this.hide();
                }
            };
            popWindow.show(data);
        }
	})();



    $('[data-dropbox]').on({
        mousedown: function(e){
            if( $(this).hasClass('open') ) return false;
            $(this).addClass('open');
            // return false;
        }
        // 点击
        , click: function( e ){
            e.preventDefault();
        }
        // 失去焦点
        , blur: function( e ){
            // console.log('失去焦点');
            $(this).removeClass('open');
        }
    });


    </script>

@stop


