!function(t,e,a){var n,i={lotteryClose:['<div class="bd text-center">','<p class="text-title text-left">非常抱歉，本彩种已休市。<br />请与<#=orderDate#>后再购买</p>','<div class="lottery-numbers text-left">','<div class="tltle"><#=lotteryName#> 第<strong class="color-green"><#=lotteryPeriods#></strong>期开奖号码：</div>','<div class="content">',"<#=lotterys#>",'<a href="#">查看更多&raquo;</a>',"</div>","</div>",'<dl class="lottery-list">',"<dt>您可以购买以下彩种</dt>","<#=lotteryType#>","</dl>","</div>"].join(""),checkLotters:['<div class="bd game-submit-confirm-cont">','<p class="game-submit-confirm-title">','<label class="ui-label">彩种：<#=lotteryName#></label>',"</p>",'<ul class="ui-form">',"<li>",'<div class="textarea">',"<#=lotteryInfo#>","</div>","</li>",'<li class="game-submit-confirm-tip">','<label class="ui-label">付款总金额：<span class="color-red"><#=lotteryamount#></span>元</label>',"</li>","</ul>","</div>"].join(""),nonSaleTime:['<div class="bd text-center">','<p class="text-title text-left">非常抱歉，本彩种未到销售时间。<br />请与<#=orderDate#>后再购买</p>','<dl class="lottery-list">',"<dt>您可以购买以下彩种</dt>","<#=lotteryType#>","</dl>","</div>"].join(""),normal:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>","</div>"].join(""),invalidtext:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>","</div>"].join(""),betExpired:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>","</div>"].join(""),multipleOver:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>","</div>"].join(""),pauseBet:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>","</div>"].join(""),successTip:['<div class="bd text-center">','<div class="pop-title">','<i class="ico-success <#=icon-class#>"></i>','<h4 class="pop-text"><#=msg#><br /></h4>',"</div>",'<p class="text-note" style="padding:5px 0;">您可以通过”<a href="<#=link#>" target="_blank">游戏记录</a>“查询您的投注记录！</p>',"</div>"].join(""),checkBalls:['<div class="bd text-center">','<div class="pop-title">','<i class="ico-waring <#=iconClass#>"></i>','<h4 class="pop-text">请至少选择一注投注号码！</h4>',"</div>",'<div class="pop-btn ">','<a href="javascript:void(0);" class="btn closeBtn">关 闭<b class="btn-inner"></b></a>',"</div>","</div>"].join(""),errorTip:['<div class="bd text-center">','<div class="pop-title">','<i class="ico-error"></i>','<h4 class="pop-text"><#=msg#></h4>',"</div>","</div>"].join(""),blockade:['<div class="bd panel-game-msg-blockade" id="J-blockade-panel-main">','<form id="J-form-blockade-detail" action="ssc-blockade-detail.php" target="_blank" method="post"></form>','<div class="game-msg-blockade-text">存在<#=blockadeType#>内容，系统已为您做出 <a href="#" data-action="blockade-detail">最佳处理</a> ，点击<span class="color-red">“确认”</span>完成投注</div>',"<div>",'<div class="game-msg-blockade-line-title">彩种：<#=gameTypeTitle#></div>','<div class="game-msg-blockade-line-title">期号：<#=currentGameNumber#></div>',"</div>",'<div id="J-game-panel-msg-blockade-0">','<div class="game-msg-blockade-cont" id="J-msg-panel-submit-blockade-error0"><#=blockadeData0#></div>',"</div>",'<div class="game-msg-blockade-panel-money">','<div><b>付款总金额：</b><span class="color-red"><b id="J-money-blockade-adjust"><#=amountAdjust#></b></span> 元&nbsp;&nbsp;&nbsp;&nbsp;<span style="display:<#=display#>"><b>减少投入：</b><span class="color-red"><b id="J-money-blockade-change"><#=amountChange#></b></span> 元</span></div>',"<div><b>付款账号：</b><#=username#></div>","</div>","<div>",'<p class="text-note">购买后请您尽量避免撤单，如撤单将收取手续费：￥<span class="handlingCharge">0.00</span>元</p>','<p class="text-note">本次投注，若未涉及到付款金额变化，将不再提示</p>',"</div>","</div>"].join(""),userTypeError:['<div class="bd text-center">','<div class="pop-title">','<i class="ico-error"></i>','<h4 class="pop-text">对不起，仅玩家允许投注</h4>',"</div>","</div>"].join("")},o=null,l=t.Games,s={init:function(){var e=this;e.win=new t.MiniWindow({cls:"pop w-9"}),e.mask=t.Mask.getInstance(),e.reSet(),e.win.addEvent("afterHide",function(){e.reSet()})},doAction:function(t){var e=this,a="rebuild"+t.type,n="getHtml"+t.type,i=function(){};n=n.replace("-","_"),a=a.replace("-","_"),e[a]&&$.isFunction(e[a])&&(i=e[a]),t.tpl="undefined"==typeof t.tpl?e[n]():""+t.tpl,delete t.type,i.call(e,t)},formatHtml:function(t,e){var a,n,i=e;for(a in i)i.hasOwnProperty(a)&&(n=RegExp("<#="+a+"#>","g"),t=t.replace(n,i[a]));return t},arrIndexOf:function(t,e){for(var a=0,n=0;n<e.length;n++)e[n]==t&&(a+=1);return a||-1},getHtmlerrorTip:function(){var t=this.defConfig;return t.errorTip},rebuilderrorTip:function(t){var e=this,a={};a.mask=!0,a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlWaring:function(){var t=this.defConfig;return t.normal},rebuildnormal:function(t){var e=this,a={};a.mask=!0,a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlnormal:function(){return this.getHtmlWaring()},rebuildlow_balance:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmllow_balance:function(){return this.getHtmlWaring()},rebuildissue_error:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlissue_error:function(){return this.getHtmlWaring()},rebuildbet_failed:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlbet_failed:function(){return this.getHtmlWaring()},rebuildcheckLotters:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.title="投注确认",a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlcheckLotters:function(){var t=this.defConfig;return t.checkLotters},rebuildlotteryClose:function(t){var e=this,a={};lotteryName=t.data.tplData.lotteryName,lotteryPeriods=t.data.tplData.lotteryPeriods,time=t.data.tplData.orderDate,lotterys=t.data.tplData.lotterys,typeArray=t.data.tplData.lotteryType,a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},t.data.tplData.lotteryName=function(){return lotteryName||""},t.data.tplData.lotteryPeriods=function(){return lotteryPeriods||""},t.data.tplData.orderDate=function(){return time.year+"年"+time.month+"月"+time.day+"日 "+time.hour+":"+time.min},t.data.tplData.lotterys=function(){var t="";if($.isArray(lotterys))for(var e=0;e<lotterys.length;e++)t+="<em>"+lotterys[e]+"</em>";return t},t.data.tplData.lotteryType=function(){var t="";if($.isArray(typeArray))for(var e=0;e<typeArray.length;e++)t+='<dd><span style="background:url('+typeArray[e].pic+')" class="pic" title="'+typeArray[e].name+'" alt="'+typeArray[e].name+'"></span><a href="'+typeArray[e].url+'" class="btn">去投注<b class="btn-inner"></b></a></dd>';return t},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmllotteryClose:function(){var t=this.defConfig;return t.lotteryClose},rebuildnonSaleTime:function(t){var e=this,a={};time=t.data.tplData.orderDate,typeArray=t.data.tplData.lotteryType,a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},t.data.tplData.orderDate=function(){return time.year+"年"+time.month+"月"+time.day+"日 "+time.hour+":"+time.min},t.data.tplData.lotteryType=function(){var t="";if($.isArray(typeArray))for(var e=0;e<typeArray.length;e++)t+='<dd><span style="background:url('+typeArray[e].pic+')" class="pic" title="'+typeArray[e].name+'" alt="'+typeArray[e].name+'"></span><a href="'+typeArray[e].url+'" class="btn">去投注<b class="btn-inner"></b></a></dd>';return t},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlnonSaleTime:function(){var t=this.defConfig;return t.nonSaleTime},rebuildno_right:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},rebuildmustChoose:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlmustChoose:function(){return this.getHtmlWaring()},rebuildnetAbnormal:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlnetAbnormal:function(){return this.getHtmlWaring()},rebuildsuccess:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlsuccess:function(){var t=this.defConfig;return t.successTip},rebuildloginTimeout:function(t){var e=this,a={};a.mask=!0,a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlloginTimeout:function(){return this.getHtmlWaring()},rebuildserverError:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlserverError:function(){return this.getHtmlWaring()},rebuildInsufficientbalance:function(t){var e=this,a={};a.mask=!0,a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlInsufficientbalance:function(){return this.getHtmlWaring()},rebuildpauseBet:function(t){var e=this,a={};a.mask=!0,a.confirmText="投 注",a.confirmIsShow=!0,a.confirmFun=function(){for(var e=l.getCurrentGameOrder(),a=0;a<t.data.tplData.balls.length;a++)e.removeData(t.data.tplData.balls[a].id);l.getCurrentGameSubmit().submitData()},a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},t.data.tplData.msg=function(){for(var a=[],n=l.getCurrentGame().getGameConfig().getInstance(),i=0;i<t.data.tplData.balls.length;i++){var o=t.data.tplData.balls[i].type,s=n.getTitleByName(o);-1==e.arrIndexOf(s.join(""),a)&&a.push(s.join(""))}return"您的投注内容中“"+a.join("")+"”已暂停销售，是否完成剩余内容投注？"},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlpauseBet:function(){var t=this.defConfig;return t.pauseBet},rebuildmultipleOver:function(t){var e=this,a={};a.mask=!0,a.iconClass="",a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},t.data.tplData.msg=function(){for(var a=[],n=l.getCurrentGame().getGameConfig().getInstance(),i=0;i<t.data.tplData.balls.length;i++){var o=t.data.tplData.balls[i].type,s=n.getTitleByName(o);-1==e.arrIndexOf(s.join(""),a)&&a.push(s.join(""))}return"您的投注内容中“"+a.join("")+"”超出倍数限制，请调整！"},a.content=e.formatHtml(t.tpl,t.data.tplData),e.show($.extend(a,t))},getHtmlmultipleOver:function(){var t=this.defConfig;return t.multipleOver},rebuildinvalidtext:function(t){var e=this,a={};a.mask=!0,a.confirmText="刷新页面",a.confirmIsShow=!0,a.confirmFun=function(){window.location.reload()},a.content=e.formatHtml(e.getHtmlinvalidtext(),t),e.show($.extend(a,t))},getHtmlinvalidtext:function(){var t=this.defConfig;return t.invalidtext},rebuildbetExpired:function(t){var e=this,a={};a.mask=!0,a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},t.data.tplData.msg=function(){return"您好，"+t.data.tplData.bitDate.expiredDate+"期 已截止销售，当前期为"+t.data.tplData.bitDate.current+"期 ，请留意！"},a.content=e.formatHtml(e.getHtmlbetExpired(),t.data.tplData),e.show($.extend(a,t))},getHtmlbetExpired:function(){var t=this.defConfig;return t.betExpired},rebuildillegalTools:function(t){var e=this,a={};a.mask=!0,a.confirmText="刷新页面",a.confirmIsShow=!0,a.confirmFun=function(){window.location.reload()},a.content=e.formatHtml(e.getHtmlbetExpired(),t.data.tplData),e.show($.extend(a,t))},getHtmlblockade:function(){return this.defConfig.blockade},rebuildblockade:function(e){var a=this,n={},i=e.data.tplData,o=e.data.orderData,s=e.data.blockadeInfo,r=o.balls,c={},d="",u="",m=l.getCurrentGameOrder().formatMoney,p=28,f=!1,h=['<ul class="game-msg-blockade-balls">'];n.mask=!0,n.closeIsShow=!0,n.closeText="关 闭",n.confirmIsShow=!0,n.confirmText="确 认",n.closeFun=function(){a.hide()},$.each(r,function(){c[""+this.id]=this,d=this.ball,d.length>p&&(d=d.substr(0,p)+"..."),u=l.getCurrentGame().getGameConfig().getInstance().getTitleByName(this.type).join("_"),h.push('<li data-id="'+this.id+'">['+u+"] "+d+"</li>")}),h.push("</ul>"),i.gameTypeTitle=l.getCurrentGame().getGameConfig().getInstance().getGameTypeCn(),i.blockadeData0=h.join(""),i.amount=m(o.amount),i.username=s.username,i.amountAdjust=m(s.amountAdjust),i.amountChange=m(o.amount-s.amountAdjust),i.display="",1==s.type?i.blockadeType="受限":2==s.type?(i.blockadeType="奖金变动",i.display="none"):i.blockadeType="奖金变动及受限",n.callback=function(){$.ajax({url:l.getCurrentGameSubmit().defConfig.handlingChargeURL+"?amout="+s.amountAdjust,dataType:"json",method:"GET",success:function(t){1==Number(t.isSuccess)&&a.getContentDom().find(".handlingCharge").html(t.data.handingcharge)}})},n.content=a.formatHtml(a.getHtmlbetExpired(),i),n.confirmFun=function(){var t=l.getCurrentGameMessage();return f?!1:void $.ajax({url:l.getCurrentGameSubmit().defConfig.URL,data:o,dataType:"json",method:"POST",beforeSend:function(){f=!0},success:function(e){1==Number(e.isSuccess)?(t.show(e),a.clearData(),a.fireEvent("afterSubmitSuccess")):t.show(e)},complete:function(){f=!1,a.fireEvent("afterSubmit")}})},a.show($.extend(n,e)),t.util.toViewCenter(a.win.dom),$("#J-blockade-panel-main").on("click","[data-action]",function(t){{var e=$(this),a=$.trim(e.attr("data-action"));$.trim(e.parent().attr("data-id"))}switch(t.preventDefault(),a){case"blockade-detail":var n=$("#J-form-blockade-detail"),i="-";n.html(""),$('<input type="hidden" value="'+o.gameType+'" name="gameType" />').appendTo(n),$.each(r,function(){var t=this;t.lockPoint&&(""!=$.trim(t.lockPoint.beforeBlockadeList)&&$.each(t.lockPoint.beforeBlockadeList,function(){var e=this;$('<input type="hidden" value="'+e.beishu+i+e.blockadeDetail+i+e.realBeishu+i+t.type+i+t.ball+'" name="beforeBlockadeList[]" />').appendTo(n)}),""!=$.trim(t.lockPoint.pointsList)&&$.each(t.lockPoint.pointsList,function(){var e=this;$('<input type="hidden" value="'+e.mult+i+e.point+i+e.retValue+i+t.type+i+t.ball+'" name="pointsList[]" />').appendTo(n)}))}),n.submit()}})},getHtmlillegalTools:function(){return this.getHtmlWaring()},rebuildsubFailed:function(t){var e=this,a={};a.mask=!0,a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(e.getHtmlbetExpired(),t.data.tplData),e.show($.extend(a,t))},getHtmlsubFailed:function(){return this.getHtmlWaring()},rebuildgroup_error:function(t){var e=this,a={};a.mask=!0,a.closeText="关 闭",a.closeIsShow=!0,a.closeFun=function(){e.hide()},a.content=e.formatHtml(e.getHtmlbetExpired(),t.data.tplData),e.show($.extend(a,t))},getHtmlgroup_error:function(){return this.getHtmlWaring()},getHtmlno_right:function(){return this.defConfig.userTypeError},setTitle:function(t){var e=this,a=e.win;a.setTitle(t)},setContent:function(t,e){var a=this,n=a.win;n.setContent(t,e)},hideClose:function(){var t=this,e=t.win;e.getCloseDom().hide()},hideTitle:function(){var t=this,e=t.win;e.getTitleDom().hide()},show:function(t){var e=this,a=e.win;if(e.reSet(),"undefined"==typeof t.data&&(t.data={}),t.data.tplData="undefined"==typeof t.data.tplData?{}:t.data.tplData,t){if(t.type)return void e.doAction(t);"undefined"!=typeof t.tpl&&(t.content=e.formatHtml(t.tpl,t.data.tplData)),o&&(clearTimeout(o),o=null),e.setTitle(t.title||"温馨提示"),e.setContent(t.content||""),t.confirmText&&a.setConfirmName(t.confirmText),t.cancelText&&a.setCancelName(t.cancelText),t.closeText&&a.setCloseName(t.closeText),t.normalCloseFun&&(a.doNormalClose=t.normalCloseFun),t.confirmFun&&(a.doConfirm=t.confirmFun),t.cancelFun&&(a.doCancel=t.cancelFun),t.closeFun&&(a.doClose=t.closeFun),t.confirmIsShow&&a.showConfirmButton(),t.cancelIsShow&&a.showCancelButton(),t.closeIsShow&&a.showCloseButton(),t.hideTitle&&e.hideTitle(),t.hideClose&&e.hideClose(),t.mask&&e.mask.show(),a.show(),t.callback&&t.callback.call(e),t.time&&(o=setTimeout(function(){e.hide(),clearTimeout(o),o=null},1e3*t.time))}},getContainerDom:function(){var t=this;return t.win.getContainerDom()},getContentDom:function(){var t=this;return t.win.getContentDom()},hide:function(){var t=this,e=t.win;e.hide(),t.reSet()},reSet:function(){var t=this,e=t.win;t.mask.hide(),t.setTitle("提示"),t.setContent(""),e.hideConfirmButton(),e.hideCancelButton(),e.hideCloseButton(),e.doConfirm=function(){},e.doCancel=function(){},e.doClose=function(){},e.doNormalClose=function(){},e.setConfirmName("确 认"),e.setCancelName("取 消"),e.setCloseName("关 闭")},showTip:function(t,e){var a=this;a.mask.show(),a.win.showTip(t,e)},hideTip:function(){var t=this;t.win.hideTip(),t.mask.hide()}},r=t.Class(s,a);r.defConfig=i,r.getInstance=function(t){return n||(n=new r(t))},t[e]=r}(dsgame,"GameMessage",dsgame.Event);