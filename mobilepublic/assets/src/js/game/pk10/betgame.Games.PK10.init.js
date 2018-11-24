$(function(){
  var gameName = GAMECONFIG['name'];
  // 游戏实例
  betgame.Games[gameName].getInstance({
    'jsNameSpace': 'betgame.Games.' + gameName + '.'
  });
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
  betgame.Games[gameName].Message.getInstance();

  // 游戏相关变量
  var Games = betgame.Games;
  var gameConfig = Games.getCurrentGame().getGameConfig().getInstance();
  var message = Games.getCurrentGameMessage();

  // 当前期号
  var currentIssue = gameConfig.getCurrentGameNumber();
  // 开奖定时器
  var timer;
  // 初次加载
  var isFirst = true;
  var issueCached = {
    issue: gameConfig.getCurrentGameNumber(),
    wn_number: gameConfig.getLotteryBalls()
  };
  var minAmountTip = new betgame.Tip({
    cls: 'j-ui-tip-alert j-ui-tip-b j-ui-tip-showrule',
    text: '使用厘模式进行投注，单注注单最小金额为0.02元'
  });
  var miniTrend_data;

  var $timeDom = $('.J-lottery-countdown'); // 倒计时
  var $traceTimeDom = $('#J-trace-statistics-countdown'); // 追号面板倒计时
  var $currentNumber = $('#J-header-currentNumber'); // 当前期期号
  var $lotteryBoard = $('[data-lottery-ernie-numbers]'); // 开奖号码容器
  var $lotteryLoad = $('.J-loading-lottery'); // 等待开奖容器
  var $issue = $('#J-ernie-issue'); // 最近开奖号码奖期容器

  var number_strs = GAMECONFIG['balls']; // 开奖号码格式字符串
  var number_digit = GAMECONFIG['zeros'] ? 2 : 1; // 开奖号码位数
  var timeout = GAMECONFIG['timeout'] || 15;

  /* 开奖动画 */
  var number_steps = function(now, tween){
    now = '' + parseInt(now);
    now = number_strs.substr(0, number_strs.length - now.length) + now;
    now = now.split('');
    $('span', $lotteryBoard).each(function(i){
      var _num = now.substr(i*number_digit, number_digit);
      $(this).text( _num );
    });
  };
  var number_options = {
    numberStep: number_steps,
    easing: 'easeInQuad'
  };

  // 处理开奖号码
  var showLottery = GAMECONFIG['showLottery'] || function(number, ballsArr){
    $issue.html(number);
    if( ballsArr && ballsArr.length ){
      $lotteryBoard.show();
      $lotteryLoad.hide();
      number_options['number'] = parseInt( ballsArr.join('') );
      $lotteryBoard.animateNumber(number_options, 2000);
    }else{
      $lotteryBoard.hide();
      $lotteryLoad.show();
    }
  };

  // 生成开奖号码html
  var createLotteryHtml = function(){
    var html = [];
    var step = number_strs.length / number_digit;
    var cl = 'lottery-' + gameName.toLowerCase();
    while( step-- ){
      var str = number_digit > 1 ? '0' + step : step;
      html.push('<span>' +str+ '</span>');
    }
    return $lotteryBoard.html(html.join('')).addClass(cl);
  };

  // 更新开奖视图
  var updateView = function(){
    // 如果是第一次开奖则使用上一期的开奖奖期
    if( isFirst ){
      currentIssue = gameConfig.getLastGameNumber();
      isFirst = false;
    }
    $.ajax({
      url: gameConfig.getLoadIssueUrl(),
      dataType: 'JSON',
      success: function(data){
        var issues = data['issues'];
        var lastNumber = issues[0];
        miniTrend_data = issues;
        // 奖期或者开奖号码发生变化，都视为有新的开奖结果出来
        if( lastNumber['issue'] != issueCached['issue'] || lastNumber['wn_number'] != issueCached['wn_number'] ){
          issueCached['issue'] = lastNumber['issue'];
          issueCached['wn_number'] = lastNumber['wn_number'];
          // 开奖号码为空时，直接显示待开奖
          if( !lastNumber['wn_number'] ){
            // 等待开奖中...
            showLottery(lastNumber['issue']);
          }else{
            timer.stop();
            showLottery(lastNumber['issue'], lastNumber['wn_number'].split(''));
          }
        }
        // (每次获取数据后都)重绘走势图（以解决跳期开奖的情况）
        // if( Games.getCurrentGame().getCurrentGameMethod() ){
        //   Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend(miniTrend_data);
        // }
      }
    });
  };

  // 倒时器
  var countdown = function(){
    var lastTime = gameConfig.getCurrentLastTime();
    var nowTime  = gameConfig.getCurrentTime();
    var surplusTime = lastTime - nowTime;
    var fn;
    var currentNumber = '' + gameConfig.getCurrentGameNumber();
    var count = timeout;

    fn = function(){
      if(surplusTime < 0 || count < 0){
        timer && timer.stop && timer.stop();
        Games.getCurrentGame().getServerDynamicConfig(function(){
          var newCurrentNumber = '' + gameConfig.getCurrentGameNumber();
          var timer2;
          var seconds = 3;
          // 关闭未下单弹窗
          message.hide();
          // 清空追号数据
          Games.getCurrentGameTrace().autoDeleteTrace();
          Games.getCurrentGameTrace().hide();

          // 当前期期号发生变化时,提示用户期号变化
          if(currentNumber != newCurrentNumber){
            message.showTip('<div class="tipdom-cont">' +
              '<p class="row">当前已进入第<big class="row c-highlight">'+ newCurrentNumber +' 期</big></p>' +
              '<p class="row">请留意期号变化 (<big data-tip-second-left class="c-highlight">' +seconds+ '</big>)</p>' +
            '</div>');
            timer2 = setInterval(function(){
              seconds -= 1;
              $('[data-tip-second-left]').text(seconds);
              if(seconds <= 0){
                clearInterval(timer2);
                message.hideTip();
              }
            }, 1 * 1000);
          };
        });
        count = timeout;
        return;
      }
      var timeStr = '';
      var h = Math.floor(surplusTime / 3600); // 小时数
      var m = Math.floor(surplusTime % 3600 / 60); // 分钟数
      var s = surplusTime%3600%60;

      h = h < 10 ? '0' + h : '' + h;
      m = m < 10 ? '0' + m : '' + m;
      s = s < 10 ? '0' + s : '' + s;

      timeStr = h + ':' + m + ':' + s;

      $timeDom.find('[data-hour]').html(h).end()
        .find('[data-minute]').html(m).end()
        .find('[data-second]').html(s);
      $traceTimeDom.html(timeStr);
      surplusTime--;
      count--;
    };
    timer = new betgame.Timer({
      time: 1000,
      fn: fn
    });
    $currentNumber.html(currentNumber);
  };

  // 登陆超时提醒
  var loginTimeout = function(data){
    // if(data['type'] == 'loginTimeout'){
    message.hide();
    message.show({
      mask: true,
      confirmIsShow: true,
      confirmText: '关 闭',
      confirmFun: function(){
        location.href = "/";
      },
      closeFun: function(){
        location.href = "/";
      },
      content: '<div class="pop-waring"><i class="ico-waring"></i><h4 class="pop-text">登录超时，请重新登录平台！</h4></div>'
    });
    // }
  };

  // 初始化加载
  createLotteryHtml();
  countdown();
  $('body').addClass('game-page-' + gameName.toLowerCase());

  // 当最新的配置信息和新的开奖号码出现后，进行界面更新
  Games.getCurrentGame().addEvent('changeDynamicConfig', function(e, cfg){
    // 跑定时器
    timer = new betgame.Timer({
      time: 5000,
      isNew: true,
      fn: updateView
    });
    countdown();
  });

  // 玩法菜单区域的高亮处理
  Games.getCurrentGameTypes().addEvent('beforeChange', function(e, id){
    var $tabs = $('#J-panel-gameTypes li'),
      $panel = $('#J-gametyes-menu-panel'),
      dom = $panel.find('[data-id="'+ id +'"]'),
      li,
      name_cn = gameConfig.getMethodCnNameById(id),
      cls = 'current';
    if(dom.size() > 0){
      $panel.find('dd').removeClass(cls).end();
      dom.addClass(cls);
      li = dom.parents('li').addClass('current').show();
      $tabs.removeClass('current').eq(li.index()).addClass('current');
    }
  });

  // 玩法规则，中奖说明的tips提示
  var tipRule = new betgame.Tip({cls:'j-ui-tip-b j-ui-tip-showrule'});
  $('#J-balls-main-panel').on('mouseover', '.pick-rule, .win-info', function(){
    var el = $(this),
      currentMethodId = Games.getCurrentGame().getCurrentGameMethod().getId(),
      methodCfg = gameConfig.getMethodById(currentMethodId),
      text = el.hasClass('pick-rule') ? methodCfg['bet_note'] : methodCfg['bonus_note'] ;
    tipRule.setText(text);
    tipRule.show(tipRule.getDom().width()/2 * -1 + el.width()/2, tipRule.getDom().height() * -1 - 20, el);
  });
  $('#J-balls-main-panel').on('mouseleave', '.pick-rule, .win-info', function(){
    tipRule.hide();
  });
  $('#J-balls-main-panel').on('click', '.pick-rule, .win-info', function(){
    return false;
  });
  // 选球区域的玩法名称显示
  var methodPrize = 0;
  Games.getCurrentGame().addEvent('afterSwitchGameMethod', function(e, id) {
    var id = Games.getCurrentGame().getCurrentGameMethod().getId();
    var unit = Games.getCurrentGameStatistics().getMoneyUnit();
    var maxv = gameConfig.getLimitByMethodId(id, unit);
    var methodCfg = gameConfig.getPrizeById(id);
    var MaxPrizeGroup = gameConfig.getMaxPrizeGroup();
    var maxUserPrizeLength =  gameConfig.getOptionalPrizes().length;
    var maxUserPrize = gameConfig.getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'];
    var prize = 0;
    var showPrize=false;

    methodPrize = Number(methodCfg['prize']);
    showPrize = methodCfg['display_prize'];
    if(maxUserPrize>MaxPrizeGroup){
      prize = methodPrize * unit*MaxPrizeGroup /maxUserPrize;
    }else{
      prize = methodPrize * unit ;
    };
    // console.log(prize)
    Games.getCurrentGameStatistics().getMultipleDom().setMaxValue(maxv);
    if(showPrize){
      $('#J-method-prize').show();
      $('#J-method-prize').find('span').html( betgame.util.formatMoney(prize) );
    }else{
      $('#J-method-prize').hide();
    }

    // 更新小走势图
    // Games.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend(miniTrend_data);

    // 任选方案
    if( GAMECONFIG['hasRenxuan'] ){
      if( Games.getCurrentGame().getCurrentGameMethod().defConfig.digitConf ){
        var defConfig = Games.getCurrentGame().getCurrentGameMethod().defConfig,
          digitNeed = defConfig.digitNeed || 0,
          digitStatus = defConfig.digitConf;
        Games.getCurrentGame().initDigitStatus(digitNeed, digitStatus);
      }else{
        Games.getCurrentGameStatistics().setProjectNum(1);
        Games.getCurrentGameStatistics().setDigitChoose([]);
      }
      if( Games.getCurrentGame().getCurrentGameMethod().defConfig.orderSplitType ){
        var type = Games.getCurrentGame().getCurrentGameMethod().defConfig.orderSplitType;
        Games.getCurrentGame().getCurrentGameMethod().setOrderSplitType( type );
      }else{
        Games.getCurrentGame().getCurrentGameMethod().setOrderSplitType( '' );
      }
    }

  });
  // 加载默认玩法
  Games.getCurrentGameTypes().addEvent('endShow', function() {
    this.changeMode(gameConfig.getDefaultMethodId());
  });
  // 将选球数据添加到号码篮
  $('#J-add-order').on('click', function(){
    var result = Games.getCurrentGameStatistics().getResultData();
    // console.log(result)
    if(!result['mid'] || result['amount']<'0.02'){
      return;
    }
    Games.getCurrentGameOrder().add(result);
  });
  // 立即投注
  $('#J-fast-submit').on('click', function(){
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
    Games.getCurrentGameOrder().fastOrder(result)
  });
  // 根据选球内容更新添加按钮的状态样式
  Games.getCurrentGameStatistics().addEvent('afterUpdate', function(e, num, money){
    var me = this;
    var button = $('#J-add-order');
    var button2 = $('#J-fast-submit');
    var MaxPrizeGroup = gameConfig.getMaxPrizeGroup();
    var maxUserPrizeLength = gameConfig.getOptionalPrizes().length;
    var maxUserPrize = gameConfig.getOptionalPrizes()[maxUserPrizeLength-1]['prize_group'];

    if(num > 0){
      if(money>='0.02'){
        button.add(button2).removeClass('btn-disable');
        // 计算返点
        var rate = me.getPrizeGroupRate() || 0;
        me.setRebate(money, rate);
        minAmountTip.hide();
      }else{
        minAmountTip.show(
          -button2.parent().width()/2,
          minAmountTip.getDom().height() * -1 - 20,
          button2
        );
        button.add(button2).addClass('btn-disable');
        me.setRebate(0);
      }
    }else{
      button.add(button2).addClass('btn-disable');
      me.setRebate(0);
      minAmountTip.hide();
    };

    var prize = methodPrize * Number( me.getMoneyUnit());
    // 计算最低单注奖金
    if(maxUserPrize>MaxPrizeGroup){
      prize = methodPrize * Number( me.getMoneyUnit() ) * MaxPrizeGroup /maxUserPrize;
    };
    $('#J-method-prize').find('span')
      .html( betgame.util.formatMoney(prize) );
  });

  // 号码蓝模拟滚动条(该滚动条初始化使用autoReinitialise: true参数也可以达到自动调整的效果，但是是用的定时器检测)
  var gameOrderScroll = $('#J-panel-order-list-cont');
  var gameOrderScrollAPI;
  gameOrderScroll.jScrollPane();
  gameOrderScrollAPI = gameOrderScroll.data('jsp');

  // 注单提交按钮的禁用和启用
  // 数字改变闪烁动画
  Games.getCurrentGameOrder().addEvent('afterChangeLotterysNum', function(e, lotteryNum){
    var me = this;
    var subButton = $('#J-submit-order');
    var traceButton = $('#J-trace-switch');
    var rederData = e.data['orderData'];
    var unitType = false;
    var cartEmpty = $('.J-cart-empty');
    if(lotteryNum > 0){
      for(var i = 0 ;i<rederData.length; i++){
        (rederData[i]['moneyUnit'] == 0.001 ) ? unitType = true : '';
      }
      if(unitType ){
        subButton.removeClass('btn-bet-disable');
        traceButton.addClass('btn-bet-disable');
      }else{
        subButton.add(traceButton).removeClass('btn-bet-disable');
      }
      cartEmpty.hide();
      gameOrderScrollAPI.reinitialise();
    }else{
      subButton.add(traceButton).addClass('btn-bet-disable');
      cartEmpty.show();
    }
  });

  // 单式上传的删除、去重、清除功能
  $('body')
    .on('click', '.remove-error', function(){
      Games.getCurrentGame().getCurrentGameMethod().removeOrderError();
    })
    .on('click', '.remove-same', function(){
      Games.getCurrentGame().getCurrentGameMethod().removeOrderSame();
    })
    .on('click', '.filter-order', function(){
      Games.getCurrentGame().getCurrentGameMethod().filterOrder();
    })
    .on('click', '.remove-all', function(){
      Games.getCurrentGame().getCurrentGameMethod().removeOrderAll();
    });

  // 设置倍数&&模式
  Games.getCurrentGameStatistics().setMultiple(gameConfig.getDefaultMultiple());
  Games.getCurrentGameStatistics().setMoneyUnitDom((gameConfig.getDefaultCoefficient()));

  // 投注按钮操作
  $('body').on('click', '#J-submit-order', function(){
    Games.getCurrentGameTrace().deleteTrace();
    Games.getCurrentGameSubmit().submitData();
  });

  // 追号区域的显示
  $('#J-trace-switch').on('click', function(){
    var orderData = Games.getCurrentGameOrder().orderData, moneyUnit = false;
    for(var i = 0 ; i<orderData.length; i++){
      (orderData[i].moneyUnit == '0.001')? moneyUnit = true : '';
    }
    if(moneyUnit){
      return false;
    }
    // 更新追号区的余额显示
    $('#J-trace-statistics-balance').html($('[data-user-account-balance]').html());
    // 弹出追号窗口
    Games.getCurrentGameTrace().show();
    return false;
  });
  // 追号窗口关闭
  $('#J-trace-panel').on('click', '.closeBtn', function(){
    // 由关闭和取消按钮触发，恢复原来号码篮原来的倍数
    Games.getCurrentGameTrace().hide();
    Games.getCurrentGameTrace().deleteTrace();
  });
  // 追号投注
  $('#J-button-trace-confirm').on('click', function(){
    if( Games.getCurrentGameTrace().getIsTrace() ){
      Games.getCurrentGameTrace().hide();
      Games.getCurrentGameSubmit().submitData();
      Games.getCurrentGameTrace().deleteTrace();
    };
  });
  // submit loading
  Games.getCurrentGameSubmit().addEvent('beforeSend', function(e, msg){
    var panel = msg.win.dom.find('.pop-control'),
    comfirmBtn = panel.find('a.confirm'),
    cancelBtn = panel.find('a.cancel');
    comfirmBtn.addClass('btn-disabled');
    comfirmBtn.text('提交中...');
    msg.win.hideCancelButton();

  });
  Games.getCurrentGameSubmit().addEvent('afterSubmit', function(e, msg){
    var panel = msg.win.dom.find('.pop-control'),
    comfirmBtn = panel.find('a.confirm'),
    cancelBtn = panel.find('a.cancel');
    comfirmBtn.removeClass('btn-disabled');
    comfirmBtn.text('确 认');
    // 刷新投注记录
    // $('#record-iframe').attr("src",$(".game-record-section >ul.tabs >li.current").attr("srclink"));
    // 刷新余额
    $('[data-refresh-balance]:eq(0)').trigger('click');
  });

  // 任选玩法相关
  if( GAMECONFIG['hasRenxuan'] ){

    $('body').on('click', '[digit-status]', function(e){
      var idx = $(this).parent().index();
      if(!Games.getCurrentGame().digitStatusToggle(idx)){
        return false;
      }
    });

    Games.getCurrentGame().addEvent('afterDigitStatusChange', function(e, digitStatus){
      $('.J-digit-num-choosed').text(Games.getCurrentGame().getDigitChoosed().length);
      $('.J-digit-project-num').text(Games.getCurrentGame().getProjectNum());
    });

    Games.getCurrentGame().addEvent('digitLabelsEvent', function(i, flag){
      var $digitLabels = $('[digit-status]', Games.getCurrentGame().getCurrentGameMethod().container);
      if( $digitLabels.eq(i).length ){
        $digitLabels.eq(i).prop('checked', flag);
      }
    });

    // 任选玩法切换
    Games.getCurrentGameTypes().addEvent('afterGametypesChange', function(e, handler){
      var $handler = $(handler), cl = 'renxuan-is-visible';
      if( $handler.hasClass(cl) ){
        $handler.removeClass(cl).text('任选玩法')
          .siblings().show()
          .filter('.gametypes-menu-renxuan').hide();
      }else{
        $handler.addClass(cl).text('普通玩法')
          .siblings().hide()
          .filter('.gametypes-menu-renxuan').show();
      }
    });
  }
});
