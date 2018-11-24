var DSGLOBAL = window.DSGLOBAL || {};
$(function(){

  var touchEvent = ('ontouchstart' in window) ? 'tap' : 'click';
  var getAjaxLoading = function(){
    var html = '<div class="sk-double-bounce ds-load-loading"> \
                  <div class="sk-child sk-double-bounce1"></div> \
                  <div class="sk-child sk-double-bounce2"></div> \
                </div>';
    return $(html);
  };
  var getMoneyFormatHtml = function( money ){
    if( !money ) return '';
    var re = /(\d+)\.(\d+)/;
    return money.replace(re, '$1' + '.' + '<small>' + '$2' + '</small>');
  };
  // 头像相关
  var dsAvatars = ['sunwukong.jpg','guanyin.jpg','rulai.jpg','tangseng.jpg','shaheshang.jpg','yudi.jpg'];
  var dsAvatarPath = '/assets/dist/images/avatar/';

  DSGLOBAL['touchEvent']     = touchEvent;
  DSGLOBAL['getAjaxLoading'] = getAjaxLoading;
  DSGLOBAL['dsAvatars']      = dsAvatars;
  DSGLOBAL['dsAvatarPath']   = dsAvatarPath;
  DSGLOBAL['modaldelay']     = 3; // modal自动关闭时间
  DSGLOBAL['getMoneyFormatHtml'] = getMoneyFormatHtml;

  /*
  ** 高度设置
  */
  var $mainPage = $('.main-page'),
      $section = $('#section', $mainPage),
      $header = $('[data-fixed-top]:eq(0)'),
      $footer = $('[data-fixed-bottom]:eq(0)', $mainPage);
      $selectPanel = $('.bounsInfo', $mainPage)

  function heightAdaption(){
    // 重置高度
    // $section.height('auto');

    var topHeight = Number( $header.outerHeight() ),
        bottomHeight = Number( $footer.outerHeight() ),
        sectionHeight = Number( $section.outerHeight() ),
        height = $(window).height(),
        selectPanelHeight = Number($selectPanel.outerHeight()),
        tempHeight = height - topHeight - bottomHeight -selectPanelHeight;
    $section.height( tempHeight );
  }

  // init
  heightAdaption();
  $('.modal-body').css({
    'max-height': $(window).height() * .7,
    'overflow-y': 'auto'
  });

  // 头像
  $('[data-ds-avatar]').each(function(){
    var id = $(this).data('ds-avatar'),
      avatar = dsAvatarPath + (dsAvatars[id-1] || dsAvatars[0]);
    $(this).replaceWith('<img src="' + avatar + '" alt="">');
  });

  /*
  ** 全局金额重置
  */
  $('[data-money-format]').each(function() {
    var $this = $(this);
    var html = $this.html(),
    html = getMoneyFormatHtml(html);
    $this.html(html);
  });

  /*
  ** tooltip
  **
  */
  $('[data-toggle="tooltip"]').tooltip({
    trigger: touchEvent
  });

  /*
  ** modal
  ** 移动端触发modal事件
  */
  $('[data-toggle="modal"]').on(touchEvent, function(){
    var target = $(this).data('target');
    $(target).modal();
  });

  /*
  ** dropdown
  ** 移动端触发dropdown事件
  */
  $('[data-toggle="dropdown"]').dropdown();
  //   .on(touchEvent, function(){
  //     var target = $(this).parent().find('.dropdown-menu');
  //     $(target).dropdown('toggle');
  //   });

  /*
  ** 轮播图
  */
  // 利用jQuery swipe控制轮播图的左右切换播放
  $('[data-carousel]')
    .carousel({
      interval: 5000
    })
    .on({
      swiperight: function() {
        $(this).carousel('prev');
      },
      swipeleft: function() {
        $(this).carousel('next');
      }
    });

  /*
  ** tabs切换
  */
  $('.ds-tabs').each(function(){
    var $this = $(this),
        $tabs = $('a[data-toggle="tab"]', this),
        $tabContent = $('.tab-content', this),
        len = $tabs.length,
        idx = $tabs.filter('.active').index(),
        unit = 1;

    // 利用jQuery swipe控制轮播图的左右切换播放
    $tabContent.on({
      swiperight: function() {
        idx--;
        switchTabs(idx);
      },
      swipeleft: function() {
        idx++;
        switchTabs(idx);
      }
    });

    function switchTabs(i){
      if( i >= len || i < 0 ){
        return false;
      }
      /*if( i >= len ){
        i = 0;
      }
      if( i < 0 ){
        i = len - 1;
      }
      idx = i;*/
      $tabs.eq(i).tab('show');
    }

    // 设置slide效果
    $tabs.on('shown.bs.tab', function (e) {
      var _idx = $tabs.index(this),
          target = $(this).attr('href'),
          width = $(window).width();

      if( _idx < idx ){
        unit = -1;
      }else{
        unit = 1;
      }
      idx = _idx;

      $(target).css('left', unit * width);
      $(target).animate({left: 0});

      $(document).trigger('dsTabShown:callback', [$tabs, $(this)]);
    });
  });

  /*
  *** PAGE ANIMATION
  */
  var pageVisible = $mainPage, // 缓存当前显示层
      pageAnimation = function(hidden, visible, $handler){
        $(document).trigger('dsPageAnimate:before', [$(hidden), $(visible), $handler]);
        // show
        $(hidden).removeClass('ds-hide').addClass('ds-show');
        // 显示后才加载（放于textarea中）
        var $loadContent = $(hidden).find('[data-page-load-content]');
        if( $loadContent.length ){
          $loadContent.replaceWith( $loadContent.html() );
        }

        // hide
        $(visible).removeClass('ds-show').addClass('ds-hide');

        pageVisible = hidden;

        $(document).trigger('dsPageAnimate:after', [$(hidden), $(visible), $handler]);

      };

  $('body').on(touchEvent, '[data-page-tab]', function(e){
    e.preventDefault();
    var page = $(this).data('page-tab');
    pageAnimation(page, pageVisible, $(this));
  });


  /*
  *** DS TAB LOAD
  */
  $('[role="ds-tabload"]').each(function(e){
    var $toggle = $('[data-toggle="tabload"]', this);
    var _target = $(this).data('target');
    var $loading;
    $toggle.on(touchEvent, function(e){
      e.preventDefault();
      var $parent = $(this).parent();
      var href = $(this).attr('href');
      var target = $(this).data('target') || _target;
      if( $parent.hasClass('active') || !href ) return false;
      $parent.addClass('active').siblings().removeClass('active');
      $.ajax({
        url: href,
        dataType: 'html',
        method: 'GET',
        beforeSend:function(){
          $loading = $loading || getAjaxLoading();
          $(target).append($loading);
        },
        success: function(resp){
          $(document).trigger('dsTabLoad:success', [$(target), resp, $loading]);
        },
        complete: function(){

        },
        error: function(){
          $loading.remove();
        }
      });
    });
  });

  // 所有的链接使用javascript打开
  $('body').on(touchEvent, 'a[href]', function(e){
    var href = $(this).attr('href');
    var datas = $(this).data();
    if( href && href.indexOf('javascript:') < 0 ){
      if( 'pageTab' in datas || 'toggle' in datas || 'virtualMouseBindings' in datas ){
        // return false;
      }else{
        e.preventDefault();
        window.location.href = href;
      }
    }
    // 返回
    else if( $(this).hasClass('history-back') ){
      e.preventDefault();
      var referrer = document.referrer;
      if( referrer.indexOf(DSGLOBAL['domain']) != -1 ){
        window.location.href = referrer;
      }
    }
  });

  $('body').on(touchEvent, '[data-table-link]', function(e){
    var href = $(this).data('table-link');
    if( href ) window.location.href = href;
  });

  // 账户余额
  $('body').on(touchEvent, '[data-refresh-balance]', function() {
    var me = this;
    var balanceUrl = $(me).data('refresh-balance');
    if( $(me).hasClass('onhandled') || !balanceUrl ) return false;
    $(me).addClass('onhandled');

    var handler = function(resp){
      if (resp.isSuccess != 0 ) {
        if( resp.data.available ){
          var b = getMoneyFormatHtml( resp.data.available );
          $('[data-user-balance]').html( b );
        }
        if( resp.data.profit ){
          var p = getMoneyFormatHtml( resp.data.profit );
          $('[data-user-profit]').html( p );
        }
      }else if(resp.type == 'loginTimeout'){
        if( confirm(resp.Msg) ){
          window.location.reload();
        }
      }else{
        // alert(resp.Msg || '网络繁忙请稍后再试');
      }
      $(me).removeClass('onhandled');
    };

    $.ajax({
      url: balanceUrl,
      type: 'GET',
      success: function(resp){
        var resp = $.parseJSON(resp);
        handler(resp);
      },
      error: function(resp){
        // alert('网络出错，请检查您的网络！')
        $(me).removeClass('onhandled');
      }
    });
    return false;
  });

  // 定时刷新余额
  setInterval(function(){
    $('body').find('[data-refresh-balance]').eq(0).trigger(touchEvent);
  }, 15 * 1000);

  /*
  ** 表单下拉事件
  */
  $('[data-dsform-dropdown] > li, [data-dsform-dropdown] > .ds-cell')
    .on(touchEvent, function(e){
      // e && e.preventDefault();
      var $this = $(this);
      if( $this.hasClass('active') ) return false;
      var datas = $this.data();
      var $parent = $this.closest('.dropdown');
      $.each(datas, function(key, value){
        // console.log(key, value)
        var $chooseDom = $parent.find('[data-choose-' +key+ ']');
        if( !$chooseDom.length ) return;
        if( $chooseDom.is('input') ) return $chooseDom.val( value );
        $chooseDom.html( value );
      });
      $this.addClass('active').siblings().removeClass('active');
    }).filter('[data-init]').trigger(touchEvent);

});



