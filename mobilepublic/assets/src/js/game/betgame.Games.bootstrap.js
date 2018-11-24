$(function(){
  // 游戏实例
  betgame.Games[GAMENAMESPACE].getInstance({
    'jsNameSpace': 'betgame.Games.' + GAMENAMESPACE + '.'
  });
  //测试自动更新
  // 游戏玩法切换
  betgame.GameTypes.getInstance();
  // 统计实例
  betgame.GameStatistics.getInstance();
  // 号码篮实例
  betgame.GameOrder.getInstance();
  // 追号实例
  betgame.GameTrace.getInstance();
  // 提交
  betgame.GameSubmit.getInstance();
  // 消息类
  betgame.Games[GAMENAMESPACE].Message.getInstance();

  // init
  var heightAdaption = function(){
    var $ballSection = $('.ball-select-panel'),
        $section = $('#section'),
        height = 0,
        winHeight = $(window).height();
    // $('.game-method-modal .modal-body').css({
    //   'max-height': winHeight * .7
    // });
    $ballSection.siblings().each(function(){
      height += parseFloat($(this).outerHeight());
    });
    $ballSection.height( parseFloat( $section.height() ) - height );

    // CART HEIGHT
    var $cartPanel = $('.cart-panel'),
        h  = $(window).height(),
        h1 = $cartPanel.find('.top-nav').outerHeight(),
        h2 = $cartPanel.find('.statistics-panel').outerHeight(),
        h3 = $cartPanel.find('.cart-top').outerHeight(),
        h4 = $cartPanel.find('.cart-bottom').outerHeight(),
        $inner = $cartPanel.find('.cart-inner'),
                _p = parseFloat($inner.css('padding-top')) + parseFloat($inner.css('padding-bottom')) + parseFloat($inner.css('border-top-width')) + parseFloat($inner.css('border-bottom-width'));
        $('.cart-content').height(h - h1 - h2 - h3 + 45);
        $inner.height(h - h1 - h2 - h3 - h4 - _p);
  };
  heightAdaption();

  var Games = betgame.Games;//初始化公共访问对象
  var gameConfig = Games.getCurrentGame().getGameConfig().getInstance();

  var $gameTypePanel = $('#J-gametyes-menu-panel'),
      $gameTypeTabs = $('#J-panel-gameTypes'),
      gameTypeClass = 'selected',
      $gameTypeShow = $('.game-method-choosed'),
      $topName = $('#topGameMethodName');

  // 切换游戏玩法
  Games.getCurrentGameTypes().addEvent('beforeChange', function(e, id){
    var dom = $gameTypePanel.find('[data-id="'+ id +'"]');
    if( dom.length ){
      $gameTypePanel.find('.'+gameTypeClass).removeClass(gameTypeClass);
      // 隐藏下拉玩法
      $('#methodModal').modal('hide');
      dom.addClass(gameTypeClass);
      $topName.html(dom.data('title'));
//            $gameTypeShow.find('.' + gameTypeClass).removeClass(gameTypeClass);
//            if ($gameTypeShow.find('[data-id="' + id + '"]').length) {
//                $gameTypeShow.find('[data-id="' + id + '"]').addClass(gameTypeClass);
//            } else {
//                $gameTypeShow.prepend('<label class="' + gameTypeClass + '" data-id="' + id + '">' + dom.data('title') + '</label>');
//            }
      }
  });

  $gameTypePanel.on(betgame.touchEvent, '.types-item', function(){
    if( $(this).hasClass(gameTypeClass) ) return false;
    $(this).parents('.game-method-list:eq(0)').find('.' +gameTypeClass+ '').removeClass(gameTypeClass);
    $(this).addClass(gameTypeClass);
  });
//    $gameTypeShow.on(betgame.touchEvent, 'label', function () {
//        if ($(this).hasClass(gameTypeClass))
//            return false;
//        var id = $(this).data('id');
//        $(this).addClass(gameTypeClass).siblings().removeClass(gameTypeClass);
//        $gameTypePanel.find('[data-id="' + id + '"]').trigger(betgame.touchEvent);
//    });

  // 加载默认玩法
  Games.getCurrentGameTypes().addEvent('endShow', function() {
    this.changeMode(Games.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId());
  });

    // 更新小走势图
    Games.getCurrentGame().addEvent('afterSwitchGameMethod', function (e, id) {
        Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();
    });

  var $buttonAddToCart  = $('[data-button-choose]'),
      $buttonFastSubmit = $('[data-button-fast-submit]'),
      $buttonSubmit     = $('[data-button-submit]'),
      $buttonClear      = $('[data-order-clear]'),
      $cartEmpty        = $('[data-order-empty]');
  var showCart = function(){
        $('.main-page').addClass('ds-hide');
        $('.cart-panel').addClass('ds-show');
      },
      hideCart = function(){
        $('.main-page').removeClass('ds-hide');
        $('.cart-panel').removeClass('ds-show');
      };
      showTrace = function(){
        $('.cart-panel').addClass('ds-hide');
        $('.trace-panel').addClass('ds-show');
      }
      hideTrace = function(){
        $('.cart-panel').removeClass('ds-hide');
        $('.trace-panel').removeClass('ds-show');
        Games.getCurrentGameTrace().deleteTrace();
        Games.getCurrentGameTrace().reSetTab();
      }

  $('.cart-panel').find('.action-back').on(betgame.touchEvent, function(){
    hideCart();
  });
  $('.trace-panel').find('.action-back').on(betgame.touchEvent, function(){
    hideTrace();
  });

  $("#J-advance-trace").on(betgame.touchEvent, function(){
    showTrace();
  });



  $('.cart-top button').on(betgame.touchEvent, function(){
    var action = $(this).data('action');
    if( action == 'randomone' ){
      Games.getCurrentGame().getCurrentGameMethod().randomLotterys(1);
    }else if( action == 'randomfive' ){
      Games.getCurrentGame().getCurrentGameMethod().randomLotterys(5);
    }else if( action == 'back' ){
      hideCart();
    }
    return false;
  });

  // 添加到号码篮
  $buttonAddToCart.on(betgame.touchEvent, function(){
    var result = Games.getCurrentGameStatistics().getResultData();
    if(!result['mid'] || result['amount']<'0.02'){
      return;
    }
    Games.getCurrentGameOrder().add(result);
    showCart();
  });
  // 立即投注
  $buttonFastSubmit.on(betgame.touchEvent, function(e){
    e.preventDefault();
    // 删除重复、错误项
    if( Games.getCurrentGame().getCurrentGameMethod().filterOrder ){
      Games.getCurrentGame().getCurrentGameMethod().filterOrder('hide');
      Games.getCurrentGame().getCurrentGameMethod().updateData();
    }

    var result = Games.getCurrentGameStatistics().getResultData();
    if(!result['mid'] || result['amount']<'0.02'){
      return;
    }
    // var SUBMIT = betgame.GameSubmit.getInstance();
    // SUBMIT.submitData( SUBMIT.getFastSubmitData(result) );
    Games.getCurrentGameOrder().fastOrder(result);
  });
  // 投注
  $buttonSubmit.on(betgame.touchEvent, function(e){
    e.preventDefault();
    // Games.getCurrentGameTrace().deleteTrace();
    Games.getCurrentGameSubmit().submitData();
  });

  // 购彩篮发生变化
  Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
    if( lotteryNum > 0 ){
      $buttonSubmit.removeClass('disabled');
      $buttonClear.show();
      $cartEmpty.hide();
      showCart();
    }else{
      $buttonSubmit.addClass('disabled');
      $buttonClear.hide();
      $cartEmpty.show();
      hideCart();
    }
  });
  // 清空购物篮
  $buttonClear.on(betgame.touchEvent, function(){
    Games.getCurrentGameOrder().reSet().cancelSelectOrder();
    Games.getCurrentGame().getCurrentGameMethod().reSet();
  });

  // 根据选球内容更新各按钮的状态样式
  Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
    var me = this,
        button = $buttonAddToCart.add($buttonFastSubmit);


    if(num > 0){
      if(money>='0.02'){
        var rate = me.getPrizeGroupRate() || 0;
        me.setRebate(money, rate);
        button.removeClass('disabled');
      }else{
        me.setRebate(0);
        button.addClass('disabled');
      }
    }else{
      me.setRebate(0);
      button.addClass('disabled');
    };

  });

  // 倒计时
  var countdown = function(){
    var lastTime = gameConfig.getCurrentLastTime(),
        nowTime  = gameConfig.getCurrentTime(),
        surplusTime = lastTime - nowTime,
        timer,
        fn,
        currentNumber = '' + gameConfig.getCurrentGameNumber(),
        message = Games.getCurrentGameMessage(),
        // 每15秒重新请求一次
        count = 15;

    fn = function(){
      if(surplusTime < 0 || count < 0){
        clearInterval(timer);
        Games.getCurrentGame().getServerDynamicConfig(function(){
          if( surplusTime < 0 ){
            var newCurrentNumber = '' + gameConfig.getCurrentGameNumber(),
                timer2,
                seconds = 3;
            // 关闭未下单弹窗
            message.hide();
            // 当前期期号发生变化时,提示用户期号变化
            if(currentNumber != newCurrentNumber){
              var dialog = message.getDialog();
              dialog.setTitle('温馨提示');
              dialog.setMessage('<p>当前已进入第<span class="c-highlight">'+ newCurrentNumber +' 期</span></p>' + '<p>请留意期号变化 (<span data-tip-second-left class="c-highlight">' +seconds+ '</span>)</p>');
              dialog.setButtons([]);
              dialog.open();
              timer2 = setInterval(function(){
                seconds -= 1;
                $('[data-tip-second-left]').text(seconds);
                if(seconds <= 0){
                  clearInterval(timer2);
                  message.getDialog().close();
                }
              }, 1 * 1000);
            };
          }
        });
        count = 15;
        return;
      }
      var timeStr,
        h = Math.floor(surplusTime / 3600), // 小时数
        m = Math.floor(surplusTime % 3600 / 60), // 分钟数
        s = surplusTime%3600%60;

      h = h < 10 ? '0' + h : '' + h;
      m = m < 10 ? '0' + m : '' + m;
      s = s < 10 ? '0' + s : '' + s;
      timeStr = h + ':' + m + ':' + s;

      $('[data-countdown]').html(timeStr);
      surplusTime--;
      count--;
    };
    timer = setInterval(fn, 1000);

    $('[data-current-issue]').html(currentNumber);
  }
  Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
    //跑定时器
    // timerNum = new betgame.Timer({time:5000,isNew:true,fn:newLotteryFun});
    countdown();
  });
  countdown();

    var gData = Games.getCurrentGame().getGameConfig().getInstance(); //config数据缓存
  var gConfig = gData;// 新配置数据会更新
  var gCNumber = gData.getCurrentGameNumber();//当前期号
  var timerNum;//开奖动作定时器名称
  var isFirstLottery = true; //一次标识

  var newLotteryFun = function(){
    var me = this;
    console.log(gCNumber);
    //如果是第一次开奖则使用上一期的开奖奖期
    if(isFirstLottery){
      gCNumber = gData.getLastGameNumber();
      isFirstLottery = false;
    }
    $.ajax({
      url:gData.getLoadIssueUrl(),
      dataType:'JSON',
      success:function(data){
        if(data['last_number']['issue'] - gCNumber >0 ){ //如果差居在2期以上进行修正
          gCNumber = data['last_number']['issue'];
        };
        timerNum.stop();
        if (data['last_number']['issue'] == gCNumber){
          gConfig = data;

          if(gConfig['issues'][0]['issue'] == gConfig['last_number']['issue'] && gConfig['issues'][0]['wn_number'] == '' ){
            gConfig['issues'][0]['wn_number'] = gConfig['last_number']['wn_number']
          }
          gameConfigData['issueHistory']['issues'] = gConfig['issues'];
          Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend();

        }else{

        }
      }
    });
  };


  // 游戏玩法说明、最高奖金、选号规则
  $('[data-method-instruction]').on(betgame.touchEvent, function(e){
    var mid            = Games.getCurrentGame().getCurrentGameMethod().getId(),
        methods        = gameConfig.getMethodById(mid),
        betnote        = methods['bet_note'],
        bonusnote      = methods['bonus_note'],
        prizes         = gameConfig.getPrizeById(mid),
        prize          = prizes['prize'],
        showPrize      = prizes['display_prize'],
        unit           = Games.getCurrentGameStatistics().getMoneyUnit(),
        maxMultiple    = gameConfig.getLimitByMethodId(mid, unit),
        // userPrizeGroup = gameConfig.getUserPrizeGroup(),
        methodName     = $gameTypeShow.find('.'+gameTypeClass).text(),
        dialog         = Games.getCurrentGameMessage().getDialog(),
        content        = '';

    content += '<p><label>当前玩法：</label><small>' +methodName+ '</small></p>';
    if( showPrize ){
      content += '<p><label>单注最高奖金:</label>&nbsp;&nbsp;<small><span class="c-highlight">' +betgame.util.formatMoney(prize*unit)+ '</span>&nbsp;元</small></p>'
    }
    content += '<p><label>选号规则：</label><br><small>' +betnote+ '</small></p>';
    content += '<p><label>中奖说明：</label><br><small>' +bonusnote+ '</small></p>';
    dialog.realize();
    dialog.getModalDialog().addClass('method-instruction-dialog');
    dialog.setTitle('玩法提示');
    dialog.setMessage( content );
    dialog.setButtons([{
      label: '知道了',
      action: function(dialogRef){
        dialogRef.close();
      }
    }]);
    dialog.open();
  });

  //单式上传的删除、去重、清除功能
  $('body').on('click', '.remove-error', function(){
    Games.getCurrentGame().getCurrentGameMethod().removeOrderError();
  }).on('click', '.remove-same', function(){
    Games.getCurrentGame().getCurrentGameMethod().removeOrderSame();
  }).on('click', '.remove-all', function(){
    Games.getCurrentGame().getCurrentGameMethod().removeOrderAll();
  });
  
    //游戏链接
    $('#gotoNewGame').on('change',function(){
        window.location= $(this).val()
    })

});







