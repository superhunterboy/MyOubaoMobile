/*‮*/!function(t,e,a){var n={name:"k3.k3.hezhi",tips:"",exampleTip:""},s=t.Games,l=s.K3.getInstance(),i={init:function(t){},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var t=this;t.container.html(o.join(""))},makePostParameter:function(t){for(var e=0,a=t.length,n=[];e<a;e++)n.push(t[e].join("|"));return n.join("")},checkBallIsComplete:function(){for(var t=this,e=t.getBallData()[0],a=0,n=e.length,s=0;a<n;a++)e[a]>0&&s++;return s>=1?t.isBallsComplete=!0:t.isBallsComplete=!1},formatViewBalls:function(t){for(var e=[],a=t.length,n=0;n<a;n++)e=e.concat(t[n].join("|"));return e.join("|")},getLottery:function(t){var e=this,a=e.getBallData()[0],n=[];return e.checkBallIsComplete()&&$.each(a,function(t){this>-1&&n.push(t)}),n},randomNum:function(){var e=this,a=[],n=[],l=null,i=(e.getBallData(),e.getBallData()[0].length),r=s.getCurrentGame().getCurrentGameMethod().getName(),u=s.getCurrentGame().getCurrentGameMethod().getId();e.defConfig.name;return a[0]=Math.floor(Math.random()*i),n.push(a),l={mid:u,type:r,original:[a],lotterys:n,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePriceById(u),num:n.length},l.amountText=t.util.formatMoney(l.num*l.moneyUnit*l.multiple*l.onePrice),l},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("<th><span>和值</span></th>"),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,a=e.miniTrend_getBallsData(),n=a.length,s="",l=[],i=[];return $.each(a,function(e){t=this,i=[],s="",s=0==e?"first":s,s=e==n-1?"last":s;var a=t.wn_number.split("");l.push('<tr class="'+s+'">'),l.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),l.push('<td><span class="balls">'),$.each(a,function(t){l.push('<i class="curr">'+this+"</i>")}),l.push("</span></td>");var r=parseInt(a[0])+parseInt(a[1])+parseInt(a[2]);l.push("<td>"+(isNaN(r)?"-":r)+"</td>"),l.push("</tr>")}),l.join("")}},r=[],u=[];u.push('<div class="ball-section">'),u.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18],function(t){t<3?u.push('<label class="ball-number ball-number-hidden" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>"):u.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),u.push("</div>"),u.push("</div>");var h=[],o=[],c=u.join("");o.push(r.join("")),$.each([""],function(t){o.push(c.replace(/<#=title#>/g,this).replace(/<#=row#>/g,t))}),o.push(h.join(""));var p=t.Class(i,e);p.defConfig=n,l.setLoadedHas(n.name,new p)}(betgame,betgame.GameMethod);