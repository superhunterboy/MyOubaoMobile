/*‮*/!function(t,e,a){var n={name:"wuxing.qita.longhuhe",tips:"",exampleTip:""},s=t.Games,i=s.SSC.getInstance(),l={init:function(t){},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1]]},buildUI:function(){var t=this;t.container.html(o.join(""))},makePostParameter:function(t){for(var e=0,a=t.length,n=[];e<a;e++)n.push(t[e].join("|"));return n.join("")},checkBallIsComplete:function(){for(var t=this,e=t.getBallData()[0],a=0,n=e.length,s=0;a<n;a++)e[a]>0&&s++;return s>=1?t.isBallsComplete=!0:t.isBallsComplete=!1},formatViewBalls:function(t){for(var e=[],a=t.length,n=0,s=[],i=["龙","虎","和"];n<a;n++)s=[],$.each(t[n],function(e){s[e]=i[Number(t[n][e])]}),e=e.concat(s.join("|"));return e.join("")},getLottery:function(t){var e=this,a=e.getBallData()[0],n=[];return e.checkBallIsComplete()&&$.each(a,function(t){this>-1&&n.push(t)}),n},randomNum:function(){var e=this,a=[],n=[],i=null,l=(e.getBallData(),e.getBallData()[0].length),r=s.getCurrentGame().getCurrentGameMethod().getName(),u=s.getCurrentGame().getCurrentGameMethod().getId();e.defConfig.name;return a[0]=Math.floor(Math.random()*l),n=e.mathResult(a[0],0,9),i={mid:u,type:r,original:[a],lotterys:n,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePriceById(u),num:n.length},i.amountText=t.util.formatMoney(i.num*i.moneyUnit*i.multiple*i.onePrice),i},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("<th><span>形态</span></th>"),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,a=e.miniTrend_getBallsData(),n=a.length,s="",i=[],l=[];return $.each(a,function(e){t=this,l=[],s="",s=0==e?"first":s,s=e==n-1?"last":s;var a=t.wn_number.split("");if(i.push('<tr class="'+s+'">'),i.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),i.push('<td><span class="balls">'),$.each(a,function(t){0==t||4==t?i.push('<i class="curr">'+this+"</i>"):i.push("<i>"+this+"</i>")}),i.push("</span></td>"),5==a.length){var r="和";Number(a[0])>Number(a[4])?r="龙":Number(a[0])<Number(a[4])&&(r="虎"),i.push("<td>"+r+"</td>")}else i.push("<td>--</td>");i.push("</tr>")}),i.join("")}},r=[],u=[];u.push('<div class="ball-section">'),u.push('<div class="ball-section-content">'),$.each(["龙","虎","和"],function(t){u.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+t+'&row=<#=row#>">'+this+"</label>")}),u.push("</div>"),u.push("</div>");var h=[],o=[],c=u.join("");o.push(r.join("")),$.each([""],function(t){o.push(c.replace(/<#=title#>/g,this).replace(/<#=row#>/g,t))}),o.push(h.join(""));var m=t.Class(l,e);m.defConfig=n,i.setLoadedHas(n.name,new m)}(betgame,betgame.GameMethod);