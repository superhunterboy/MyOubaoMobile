$(function(){dsgame.Games.K3.getInstance({jsNameSpace:"dsgame.Games.K3."}),dsgame.GameTypes.getInstance(),dsgame.GameStatistics.getInstance(),dsgame.GameOrder.getInstance(),dsgame.GameTrace.getInstance(),dsgame.GameSubmit.getInstance(),dsgame.Games.K3.Message.getInstance();var e,t,n=dsgame.Games,a=n.getCurrentGame().getGameConfig().getInstance(),r=a,i=a.getCurrentGameNumber(),s=!0,o=new dsgame.Tip({cls:"j-ui-tip-alert j-ui-tip-b j-ui-tip-showrule",text:"使用厘模式进行投注，单注注单最小金额为0.02元"}),d=(new dsgame.MiniWindow({cls:"lottery-board-pop",effectShow:function(){var e=this;e.dom.css({display:"block",left:"50%",marginLeft:-e.dom.outerWidth()/2,top:2*-e.dom.outerHeight()}).animate({top:206})},effectHide:function(){var e=this;e.dom.animate({top:2*-e.dom.outerHeight()},function(){e.dom.hide()})}}),function(e){this.$dices=e||$(".dice"),this.rands=["a","b","c","d"],this.randLen=this.rands.length,this.timeout=150,this.animation=function(e,t){var n=this;n.$dices.each(function(a,r){var i=$(r),s=n.randomBelle(n.randLen,n.randLen-1,0);i.attr("class","dice").delay(n.timeout).animate({opacity:"show"},100,function(){i.addClass("dice_"+n.rands[s[0]])}).delay(n.timeout).animate({opacity:"show"},100,function(){i.removeClass("dice_"+n.rands[s[0]]).addClass("dice_"+n.rands[s[1]])}).delay(n.timeout).animate({opacity:"show"},600,function(){i.removeClass("dice_"+n.rands[s[1]]).addClass("dice_"+n.rands[s[2]])}).delay(n.timeout).animate({opacity:"show"},600,function(){i.removeClass("dice_"+n.rands[s[2]]).addClass("dice_"+n.rands[s[3]])}).delay(n.timeout).animate({opacity:"show"},100,function(){i.removeClass("dice_"+n.rands[s[3]]).addClass("dice_"+e[a]),t&&"function"==typeof t&&t()})})},this.randomBelle=function(e,t,n){function a(e,t,n){for(;s.length<e;){var a=r(t,n);i(s,a)||s.push(a)}return s}function r(e,t){return Math.round(Math.random()*(e-t))+t}function i(e,t){for(var n=0;n<e.length;n++)if(e[n]==t)return!0;return!1}var s=new Array;return a(e,t,n)}}),m=function(e,n){var a=$("#lottery-numbers-board");if($("#J-ernie-issue").html(e),n&&n.length){t||(a.find("[data-lottery-ernie-numbers]").replaceWith(u(n.length)),t=new d(a.find(".dice"))),$("#J-lottery-ernie-numbers").show(),$(".J-loading-lottery").hide();var r=0,i="大",s="双";$.each(n,function(e,t){r+=parseInt(t)}),9>=r&&(i="小"),r%2&&(s="单"),t.animation(n,function(){$("#J-lottery-property-hz").html(r),$("#J-lottery-property-dx").html(i),$("#J-lottery-property-ds").html(s)})}else $("#J-lottery-ernie-numbers").hide(),$(".J-loading-lottery").show()},u=function(e){for(var t=['<div style="display:none;" id="J-lottery-ernie-numbers" class="lottery-ernie-numbers lottery-ernie-numbers-'+e+'">'],n=0;e>n;n++)t.push('<div class="dice"></div>');return t.push('<div class="lottery-property">和值：<b id="J-lottery-property-hz">?</b><br/>形态：<span id="J-lottery-property-dx">?</span><i id="J-lottery-property-ds">?</i></div>'),t.push("</div>"),t.join("")},c=function(){s&&(i=a.getLastGameNumber(),s=!1),$.ajax({url:a.getLoadIssueUrl(),dataType:"JSON",success:function(t){t.last_number.issue-i>0&&(i=t.last_number.issue),t.last_number.issue==i?(e.stop(),r=t,m(t.last_number.issue,(""+t.last_number.wn_number).split("")),r.issues[0].issue==r.last_number.issue&&""==r.issues[0].wn_number&&(r.issues[0].wn_number=r.last_number.wn_number),gameConfigData.issueHistory.issues=r.issues,n.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend()):m(i)}})},l=function(){var e,t,r=a.getCurrentLastTime(),i=a.getCurrentTime(),s=r-i,o=""+a.getCurrentGameNumber(),d=$(".J-lottery-countdown li em"),m=$("#J-trace-statistics-countdown"),u=n.getCurrentGameMessage();t=function(){if(0>s)return e.stop(),void n.getCurrentGame().getServerDynamicConfig(function(){var e,t=""+a.getCurrentGameNumber(),r=2;u.hide(),n.getCurrentGameTrace().autoDeleteTrace(),n.getCurrentGameTrace().hide(),o!=t&&(u.showTip('<div class="tipdom-cont">当前已进入第<div class="row" style="color:#F60;font-size:18px;">'+t+' 期</div><div class="row">请留意期号变化 (<span id="J-gamenumber-change-s-num">3</span>)</div></div>'),e=setInterval(function(){$("#J-gamenumber-change-s-num").text(r),r-=1,-1>r&&(clearInterval(e),u.hideTip())},1e3))});var t=[],r=Math.floor(s/3600),i=Math.floor(s%3600/60),c=s%3600%60;r=10>r?"0"+r:""+r,i=10>i?"0"+i:""+i,c=10>c?"0"+c:""+c,t.push(r),t.push(i),t.push(c),d.each(function(e){$(this).text(t[e])}),m.html(t.join(":")),s--},e=new dsgame.Timer({time:1e3,fn:t}),$("#J-header-currentNumber").html(o)},g=function(){$("div.game-record-section>ul>li").click(function(){var e=$(this);$("div.game-record-section>ul>li").removeClass("current"),e.addClass("current"),$("#record-iframe").attr("src",e.attr("srclink"))})},f=function(){var t=r.last_number?r.last_number.issue:r.getLastGameNumber(),n=r.last_number?(""+r.last_number.wn_number).split(""):(""+r.getLotteryBalls()).split("");return""==r.getLotteryBalls()?e=new dsgame.Timer({time:5e3,isNew:!0,fn:c}):m(t,n),!1};l(),g(),f(),n.getCurrentGame().addEvent("changeDynamicConfig",function(){e=new dsgame.Timer({time:5e3,isNew:!0,fn:c}),l()}),n.getCurrentGameTypes().addEvent("beforeChange",function(e,t){var a,r=$("#J-panel-gameTypes li"),i=$("#J-gametyes-menu-panel"),s=i.find('[data-id="'+t+'"]'),o=(n.getCurrentGame().getGameConfig().getInstance().getMethodCnNameById(t),"current");s.size()>0&&(i.find("dd").removeClass(o).end(),s.addClass(o),a=s.parents("li").addClass("current").show(),r.removeClass("current").eq(a.index()).addClass("current"))});var h=new dsgame.Tip({cls:"j-ui-tip-b j-ui-tip-showrule"});$("#J-balls-main-panel").on("mouseover",".pick-rule, .win-info",function(){var e=$(this),t=n.getCurrentGame().getCurrentGameMethod().getId(),a=n.getCurrentGame().getGameConfig().getInstance().getMethodById(t),r=e.hasClass("pick-rule")?a.bet_note:a.bonus_note;h.setText(r),h.show(h.getDom().width()/2*-1+e.width()/2,-1*h.getDom().height()-20,e)}),$("#J-balls-main-panel").on("mouseleave",".pick-rule, .win-info",function(){h.hide()}),$("#J-balls-main-panel").on("click",".pick-rule, .win-info",function(){return!1});var p=0;n.getCurrentGame().addEvent("afterSwitchGameMethod",function(e,t){var t=n.getCurrentGame().getCurrentGameMethod().getId(),a=n.getCurrentGameStatistics().getMoneyUnit(),r=n.getCurrentGame().getGameConfig().getInstance().getLimitByMethodId(t,a),i=n.getCurrentGame().getGameConfig().getInstance().getPrizeById(t),s=n.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),o=n.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,d=n.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[o-1].prize_group,m=0,u=!1;p=Number(i.prize),u=i.display_prize,m=d>s?p*a*s/d:p*a,n.getCurrentGameStatistics().getMultipleDom().setMaxValue(r),u?($("#J-method-prize").show(),$("#J-method-prize").find("span").html(dsgame.util.formatMoney(m))):$("#J-method-prize").hide(),n.getCurrentGame().getCurrentGameMethod().miniTrend_updateTrend()}),n.getCurrentGameTypes().addEvent("endShow",function(){this.changeMode(n.getCurrentGame().getGameConfig().getInstance().getDefaultMethodId())}),$("#J-add-order").click(function(){var e=n.getCurrentGameStatistics().getResultData();!e.mid||e.amount<"0.02"||n.getCurrentGameOrder().add(e)}),n.getCurrentGameStatistics().addEvent("afterUpdate",function(e,t,a){var r=this,i=$("#J-add-order"),s=n.getCurrentGame().getGameConfig().getInstance().getMaxPrizeGroup(),d=n.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes().length,m=n.getCurrentGame().getGameConfig().getInstance().getOptionalPrizes()[d-1].prize_group;if(t>0)if(a>="0.02"){i.removeClass("btn-disable");var u=r.getPrizeGroupRate()||0;r.setRebate(a,u),o.hide()}else o.show(o.getDom().width()/2*-1+i.width()/2,-1*o.getDom().height()-20,i),i.addClass("btn-disable"),r.setRebate(0);else i.addClass("btn-disable"),r.setRebate(0),o.hide();var c=p*Number(r.getMoneyUnit());m>s&&(c=p*Number(r.getMoneyUnit())*s/m),$("#J-method-prize").find("span").html(dsgame.util.formatMoney(c))});var C,b=$("#J-panel-order-list-cont");b.jScrollPane(),C=b.data("jsp"),n.getCurrentGameOrder().addEvent("afterChangeLotterysNum",function(e,t){var n=$("#J-submit-order"),a=$("#J-trace-switch"),r=e.data.orderData,i=!1,s=$(".J-cart-empty");if(t>0){for(var o=0;o<r.length;o++).001==r[o].moneyUnit?i=!0:"";i?(n.removeClass("btn-bet-disable"),a.addClass("btn-bet-disable")):n.add(a).removeClass("btn-bet-disable"),s.hide(),C.reinitialise()}else n.add(a).addClass("btn-bet-disable"),s.show()}),$("body").on("click",".remove-error",function(){n.getCurrentGame().getCurrentGameMethod().removeOrderError()}).on("click",".remove-same",function(){n.getCurrentGame().getCurrentGameMethod().removeOrderSame()}).on("click",".remove-all",function(){n.getCurrentGame().getCurrentGameMethod().removeOrderAll()}),n.getCurrentGameStatistics().setMultiple(n.getCurrentGame().getGameConfig().getInstance().getDefaultMultiple()),n.getCurrentGameStatistics().setMoneyUnitDom(n.getCurrentGame().getGameConfig().getInstance().getDefaultCoefficient()),$("body").on("click","#J-submit-order",function(){n.getCurrentGameTrace().deleteTrace(),n.getCurrentGameSubmit().submitData()}),$("#J-trace-switch").click(function(){for(var e=n.getCurrentGameOrder().orderData,t=!1,a=0;a<e.length;a++)"0.001"==e[a].moneyUnit?t=!0:"";return t?!1:($("#J-trace-statistics-balance").html($("[data-user-account-balance]").html()),n.getCurrentGameTrace().show(),!1)}),$("#J-trace-panel").on("click",".closeBtn",function(){n.getCurrentGameTrace().hide(),n.getCurrentGameTrace().deleteTrace()}),$("#J-button-trace-confirm").click(function(){n.getCurrentGameTrace().getIsTrace()&&(n.getCurrentGameTrace().hide(),n.getCurrentGameSubmit().submitData(),n.getCurrentGameTrace().deleteTrace())}),n.getCurrentGameSubmit().addEvent("beforeSend",function(e,t){{var n=t.win.dom.find(".pop-control"),a=n.find("a.confirm");n.find("a.cancel")}a.addClass("btn-disabled"),a.text("提交中..."),t.win.hideCancelButton()}),n.getCurrentGameSubmit().addEvent("afterSubmit",function(e,t){{var n=t.win.dom.find(".pop-control"),a=n.find("a.confirm");n.find("a.cancel")}a.removeClass("btn-disabled"),a.text("确 认"),$("#record-iframe").attr("src",$(".game-record-section >ul.tabs >li.current").attr("srclink")),$("[data-refresh-balance]:eq(0)").trigger("click")}),setTimeout(function(){$("html,body").animate({scrollTop:140},400)},1e3),$(".play-section").addClass("play-section-kuai3"),$("#J-gametyes-menu-panel").hide()});