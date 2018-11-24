@extends('l.base')

@section('title')
精彩推荐
@parent
@stop

@section('styles')
  @parent
  {{ style('home') }}
  <link media="all" type="text/css" rel="stylesheet" href="/assets/dist/css/select.css">
@stop

@section('bodyClass')
<body class="home">
@stop

@section ('container')
<div class="main-page show-page">
    <div id="section">
        <div id="myCarousel" class="carousel slide" data-carousel>
            <div class="carousel-inner">
            <div class="item">
                <a href="javascript:void(0);"><img src="/ad/ad1.png"></a>
            </div>
            <div class="item">
                <a href="javascript:void(0);"><img src="/ad/ad2.png"></a>
            </div>
            <div class="item">
                <a href="javascript:void(0);"><img src="/ad/ad3.png"></a>
            </div>
            <div class="item">
                <a href="javascript:void(0);"><img src="/ad/ad4.png"></a>
            </div>
            </div>
        </div>
        <!--最新开奖-->
        <div class="newest-prize">
            <p>最新开奖</p>
            <div class="game-content">
                <div class="latest-balls">
                    <span>重庆时时彩 第<span class="c-highlight">{{$aLastIssue['issue']}}</span>期</span>
                    <p class="balls">
                        <span>{{substr($aLastIssue['wn_number'],0,1)}}</span>
                        <span>{{substr($aLastIssue['wn_number'],1,1)}}</span>
                        <span>{{substr($aLastIssue['wn_number'],2,1)}}</span>
                        <span>{{substr($aLastIssue['wn_number'],3,1)}}</span>
                        <span>{{substr($aLastIssue['wn_number'],4,1)}}</span>
                    </p>
                    <a href="{{route('mobile-bets.betform', 1)}}" class="bet">立即投注</a>
                </div>
            </div>
        </div>

        <!--热门彩种-->
        <div class="self-setted">
            <div class="self-setted-title">
                <h2>热门彩票</h2>
                <span id="startSet">自定义</span>
            </div>
            <div class="self-set-list">
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
                <div data-settedNum="false" class="result-setted"><a href="###"></a></div>
            </div>
        </div>
    </div>
</div>



<div class="pop-up-page show-page" id="popUpPage">
    <div class="top-nav ">
        <div class="media-left">
            <a href="javascript:;" class="backbtn"  id="popBack"><span class="unicode-icon-prev"></span></a>
        </div>
        <h1 class="media-body">自定义彩种</h1>

    </div>

    <div class="select-result">
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
        <div data-settedNum="false" class="result-setted"><span>x</span></div>
    </div>
    <p>请选择感兴趣的彩种</p>
    <div class="select-all-list">
        @foreach($aLotteryData as $oLottery)
        <div data-settedNum="{{$oLottery['id']}}" class="result-setted setted-num{{$oLottery['id']}}"><span>+</span></div>
        @endforeach
	</div>
  </div>

  @include('w.bottom-nav')
@stop

@section('scripts')
@parent
<script>
$('.carousel-inner .item:eq(0)').addClass('active');
(function($){
    var customMenu = {
        $popBox : $('#popUpPage'),
        $popBack : $('#popBack'),
        $start: $('#startSet'),
        $list: $('.select-all-list'),
        $result: $('.select-result'),
        $showList: $('.self-set-list'),
        modelMenu: {
            "0": 1,
            "1": 53,
            "2": 23,
            "3": 12,
            "4": 2,
            "5": 21
        },
        gamePath: "/buy/bet/",
        nowEditN: 0,
        //初始化
        init: function(){

            this.getLocal()
            if(!this.getLocal()){
                this.updataLocal(this.modelMenu);
            }else{
                this.updataLocal(this.getLocal());
            }

            var me = this;
            this.$start.click(function(){
                me.$popBox.addClass('in');
                me.updataResult();
            });
            me.$popBack.click(function(){
                me.$popBox.removeClass('in');
                me.updateMenu();
            });
            this.setClickBind();
            this.bindDefault();
        },
        bindDefault: function(){
            var me = this;
            var $div = this.$showList.find('.result-setted');
            $div.on('click',function(){
                var n = $(this).data('settednum');
                if(!n){
                    me.$popBox.addClass('in');
                    me.updataResult();
                    return false;
                }
            });
        },
        modelToMenu: function(arr){
            var _this = this;
            $.each(arr,function(n,value){
                _this.addNewlink(n,value);
                _this.addNewImg(n,value);
            });
        },
        updataLocal: function(data){
            var me = this;
            var $div = this.$result.find('.result-setted');
            $.each(data,function(num,val){
                var n = val;
                if(!n){
                    me.$showList.find('.result-setted').eq(Number(num)).attr('class','result-setted default').data("settednum",false).find('a').attr('href',"javascript:;");
                }else {
                    me.$showList.find('.result-setted').eq(Number(num)).attr('class','result-setted').addClass('setted-num'+n).data("settednum",n).find('a').attr('href',me.gamePath+n);
                }
            });
        },
        updataResult: function(){
            var me = this;
            var $div = this.$showList.find('.result-setted');
            $.each($div,function(num,val){
                var n = $(val).data('settednum');

                if(!n){
                    me.$result.find('.result-setted').eq(num).attr('class','result-setted default').data("settednum",false);
                }else {
                    me.$result.find('.result-setted').eq(num).attr('class','result-setted').addClass('setted-num'+n).data("settednum",n);
                }
            });
        },
        updateMenu: function(){
            var me = this;
            var $div = this.$result.find('.result-setted');
            $.each($div,function(num,val){
                var n = $(val).data('settednum');

                me.modelMenu[num] =n;
                if(!n){
                    me.$showList.find('.result-setted').eq(num).attr('class','result-setted default').data("settednum",false).find('a').attr('href',me.gamePath+n);
                }else {
                    me.$showList.find('.result-setted').eq(num).attr('class','result-setted').addClass('setted-num'+n).data("settednum",n).find('a').attr('href',me.gamePath+n);
                }
            });
            this.setLocal(me.modelMenu);
        },

        //设置按钮 点击
        setClickBind: function(){
            var _this = this;
            var $btn = this.$list.find('.result-setted');
            var $del = this.$result.find('.result-setted');
            $btn.click(function(){
                _this.addToMenu($(this));
            });
            $del.click(function(){
                _this.delFromMenu($(this));
            });
        },

        addToMenu: function(obj){
            var num = obj.data('settednum');
            if(this.$result.find('.setted-num'+num).length) return;
            if(this.$result.find('.default').length){
                this.$result.find('.default').eq(0).attr('class','result-setted').addClass('setted-num'+num).data("settednum",num);
            }else {
                this.$result.find('.result-setted').eq(this.nowEditN).attr('class','result-setted').addClass('setted-num'+num).data("settednum",num);
                this.nowEditN++;
                if(this.nowEditN>5){
                    this.nowEditN=0;
                }
            }
        },
        delFromMenu: function(obj){
            obj.attr('class','result-setted default').data("settednum",false);
        },
        getLocal: function(){
            var result = localStorage.getItem('userSetList');
            return result != 'undefined' ? JSON.parse(result) : false;
        },
        setLocal: function(data){
            var data = JSON.stringify(data);
            localStorage.setItem('userSetList',data);
        }

    }

    customMenu.init();



})(jQuery);

</script>
@stop
