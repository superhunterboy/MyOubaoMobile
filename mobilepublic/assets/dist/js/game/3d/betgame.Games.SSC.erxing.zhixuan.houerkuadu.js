/*‮*/!function(a,t,e){var n={name:"erxing.zhixuan.houerkuadu",tips:"后二直选跨度玩法提示",exampleTip:"后二直选跨度范例"},s=a.Games,l=s.SSC.getInstance(),r={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(o.join(""))},mathResult:function(a){for(var t=0,e=0,n=[];t<10;t++)for(e=0;e<10;e++)e-t==a&&(n.push([t,e]),t!=e&&n.push([e,t]));return n},getLottery:function(a){var t=this,e=t.getBallData()[0],n=0,s=e.length,l=!0,r=[],i=[];for(n=0;n<s;n++)e[n]>0&&(l=!1,r.push(n));if(l)return t.isBallsComplete=!1,[];for(t.isBallsComplete=!0,n=0,s=r.length;n<s;n++)i=i.concat(t.mathResult(r[n],0,9));return i},randomNum:function(){var t=this,e=[],n=[],l=null,r=(t.getBallData(),t.getBallData()[0].length),i=s.getCurrentGame().getCurrentGameMethod().getName(),u=s.getCurrentGame().getCurrentGameMethod().getId();t.defConfig.name;return e[0]=Math.floor(Math.random()*r),n=t.mathResult(e[0],0,9),l={mid:u,type:i,original:[e],lotterys:n,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePriceById(u),num:n.length},l.amountText=a.util.formatMoney(l.num*l.moneyUnit*l.multiple*l.onePrice),l},miniTrend_createHeadHtml:function(){var a=this,t=[];return t.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+a.getId()+'">'),t.push("<thead><tr>"),t.push('<th><span class="number">奖期</span></th>'),t.push('<th><span class="balls">开奖</th>'),t.push("<th><span >跨度</th>"),t.push("</tr></thead>"),t.push("<tbody>"),t.join("")},miniTrend_createRowHtml:function(){var a,t=this,e=t.miniTrend_getBallsData(),n=e.length,s="",l="curr",r=[],i="";return $.each(e,function(t){a=this,s="",s=0==t?"first":s,s=t==n-1?"last":s;var e=a.wn_number.split("");r.push('<tr class="'+s+'">'),r.push('<td><span class="number">'+a.issue.substr(2)+" 期</span></td>"),r.push('<td><span class="balls">'),$.each(e,function(a){l=a>2?"curr":"",r.push("<i class="+l+">"+this+"</i>")}),r.push("</span></td>"),i=Math.max(parseInt(e[3]),parseInt(e[4]))-Math.min(parseInt(e[3]),parseInt(e[4])),r.push("<td>"+(isNaN(i)?"-":i)+"</td>"),r.push("</tr>")}),r.join("")}},i=[],u=[];u.push('<div class="ball-section">'),u.push('<div class="ball-section-top">'),u.push('<div class="ball-control">'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),u.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),u.push("</div>"),u.push('<h2 class="decimal-name decimal-name-empty"><#=title#></h2>'),u.push("</div>"),u.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9],function(a){u.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),u.push("</div>"),u.push("</div>");var p=[],o=[],h=u.join("");o.push(i.join("")),$.each([""],function(a){o.push(h.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),o.push(p.join(""));var m=a.Class(r,t);m.defConfig=n,l.setLoadedHas(n.name,new m)}(betgame,betgame.GameMethod);