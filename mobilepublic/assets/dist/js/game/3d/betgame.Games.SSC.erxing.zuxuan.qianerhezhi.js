/*‮*/!function(t,e,n){var a={name:"erxing.zuxuan.qianerhezhi",tips:"前二组选和值玩法提示",exampleTip:"前二组选和值范例"},s=t.Games,r=s.SSC.getInstance(),i={init:function(t){},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var t=this;t.container.html(o.join(""))},makePostParameter:function(t){for(var e=0,n=t.length,a=[];e<n;e++)a.push(t[e].join("|"));return a.join("")},mathResult:function(t,e,n){var a,s,r=[],i=[],l={},u="",h=function(t,e){return t-e};for(a=e;a<=n;a++)for(s=e;s<=n;s++)a+s==t&&(i=[a,s],u=i.sort(h).join(","),l[u]||a==s||(r.push([a,s]),l[u]=!0));return r},getLottery:function(t){var e=this,n=e.getBallData()[0],a=0,s=n.length,r=!0,i=[],l=[];for(a=0;a<s;a++)n[a]>0&&(r=!1,i.push(a));if(r)return e.isBallsComplete=!1,[];for(e.isBallsComplete=!0,a=0,s=i.length;a<s;a++)l=l.concat(e.mathResult(i[a],0,9));return l},randomNum:function(){var e=this,n=[],a=[],r=null,i=(e.getBallData(),e.getBallData()[0].length),l=s.getCurrentGame().getCurrentGameMethod().getName(),u=s.getCurrentGame().getCurrentGameMethod().getId();e.defConfig.name;return n[0]=Math.floor(Math.random()*i),a=e.mathResult(n[0],0,9),r={mid:u,type:l,original:[n],lotterys:a,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePriceById(u),num:a.length},r.amountText=t.util.formatMoney(r.num*r.moneyUnit*r.multiple*r.onePrice),r},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("<th><span >和值</th>"),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,n=e.miniTrend_getBallsData(),a=n.length,s="",r="curr",i=[],l="";return $.each(n,function(e){t=this,s="",s=0==e?"first":s,s=e==a-1?"last":s;var n=t.wn_number.split("");i.push('<tr class="'+s+'">'),i.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),i.push('<td><span class="balls">'),$.each(n,function(t){r=t<2?"curr":"",i.push("<i class="+r+">"+this+"</i>")}),i.push("</span></td>"),l=parseInt(n[0])+parseInt(n[1]),i.push("<td>"+(isNaN(l)?"-":l)+"</td>"),i.push("</tr>")}),i.join("")}},l=[],u=[];u.push('<div class="ball-section">'),u.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],function(t){u.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),u.push("</div>"),u.push("</div>");var h=[],o=[],c=u.join("");o.push(l.join("")),$.each([""],function(t){o.push(c.replace(/<#=title#>/g,this).replace(/<#=row#>/g,t))}),o.push(h.join(""));var m=t.Class(i,e);m.defConfig=a,r.setLoadedHas(a.name,new m)}(betgame,betgame.GameMethod);