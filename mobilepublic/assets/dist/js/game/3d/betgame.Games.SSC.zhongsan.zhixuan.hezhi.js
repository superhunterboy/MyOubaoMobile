/*‮*/!function(t,e,a){var n={name:"zhongsan.zhixuan.hezhi"},r=t.Games,s=r.SSC.getInstance(),l={init:function(t){},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var t=this;t.container.html(u.join(""))},checkBallIsComplete:function(){for(var t=this,e=t.getBallData()[0],a=0,n=e.length,r=0;a<n;a++)e[a]>0&&r++;return r>=1?t.isBallsComplete=!0:t.isBallsComplete=!1},formatViewBalls:function(t){for(var e=[],a=t.length,n=0;n<a;n++)e=e.concat(t[n].join("|"));return e.join("|")},makePostParameter:function(t){for(var e=[],a=t.length,n=0;n<a;n++)e=e.concat(t[n].join("|"));return e.join("")},getLottery:function(){for(var t=this,e=t.getBallData()[0],a=0,n=e.length,r=[],s=[];a<n;a++)e[a]>0&&r.push(a);if(t.checkBallIsComplete()){for(var l=0;l<r.length;l++)s=s.concat(t.mathResult(r[l],0,9));return s}return[]},removeSame:function(t,e){var a,n=0,r=this,s=this.getBallData()[0].length;for(len=e.length,a=Math.floor(Math.random()*s+1);n<e.length;n++)if(a==e[n])return arguments.callee.call(r,t,e);return a},mathResult:function(t,e,a){var n,r,s,l=[];for(n=e;n<=a;n++)for(r=e;r<=a;r++)for(s=e;s<=a;s++)n+r+s==t&&l.push([n,r,s]);return l},originalData:function(t){for(var e=this,a=[],n=0;n<t.length;n++)for(var r=0;r<t[n].length;r++)a[r]=a[r]||[],e.arrIndexOf(t[n][r],a[r])||a[r].push(t[n][r]);return a},randomNum:function(){var e=this,a=[],n=[],s=null,l=(e.getBallData(),e.getBallData()[0].length),i=r.getCurrentGame().getCurrentGameMethod().getName(),o=r.getCurrentGame().getCurrentGameMethod().getId();e.defConfig.name;return a[0]=Math.floor(Math.random()*l),n=e.mathResult(a[0],0,9),s={mid:o,type:i,original:[a],lotterys:n,moneyUnit:r.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:r.getCurrentGame().getGameConfig().getInstance().getOnePriceById(o),num:n.length},s.amountText=t.util.formatMoney(s.num*s.moneyUnit*s.multiple*s.onePrice),s},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class=" table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("<th><span >和值</th>"),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,a=e.miniTrend_getBallsData(),n=a.length,r="",s="curr",l=[];return $.each(a,function(e){t=this,r="",r=0==e?"first":r,r=e==n-1?"last":r;var a=t.wn_number.split("");l.push('<tr class="'+r+'">'),l.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),l.push('<td><span class="balls">'),$.each(a,function(t){s=t>0&&t<4?"curr":"",l.push("<i class="+s+">"+(this?this:"-")+"</i>")}),l.push("</span></td>"),xtText=parseInt(a[1])+parseInt(a[2])+parseInt(a[3]),l.push("<td>"+(isNaN(xtText)?"-":xtText)+"</td>"),l.push("</tr>")}),l.join("")}},i=[],o=[];o.push('<div class="ball-section">'),o.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27],function(t){o.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),o.push("</div>"),o.push("</div>");var h=[],u=[],c=o.join("");u.push(i.join("")),$.each([""],function(t){u.push(c.replace(/<#=title#>/g,this).replace(/<#=row#>/g,t))}),u.push(h.join(""));var m=t.Class(l,e);m.defConfig=n,s.setLoadedHas(n.name,new m)}(betgame,betgame.GameMethod);