/*‮*/!function(a,s,t){var n={name:"zhongsan.qita.hezhiweishu"},l=a.Games,e=l.SSC.getInstance(),p={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(o.join(""))},checkBallIsComplete:function(){for(var a=this,s=a.getBallData()[0],t=0,n=s.length,l=0;t<n;t++)s[t]>0&&l++;return l>=1?a.isBallsComplete=!0:a.isBallsComplete=!1},getLottery:function(){for(var a=this,s=a.getBallData()[0],t=0,n=s.length,l=[];t<n;t++)s[t]>0&&l.push(t);return a.checkBallIsComplete()?l:[]},miniTrend_createHeadHtml:function(){var a=this,s=[];return s.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+a.getId()+'">'),s.push("<thead><tr>"),s.push('<th><span class="number">奖期</span></th>'),s.push('<th><span class="balls">开奖</th>'),s.push("<th><span>和尾</span></th>"),s.push("</tr></thead>"),s.push("<tbody>"),s.join("")},miniTrend_createRowHtml:function(){var a,s=this,t=s.miniTrend_getBallsData(),n=t.length,l="",e="curr",p=[],i="";return $.each(t,function(s){a=this,l="",l=0==s?"first":l,l=s==n-1?"last":l;var t=a.wn_number.split("");p.push('<tr class="'+l+'">'),p.push('<td><span class="number">'+a.issue.substr(2)+" 期</span></td>"),p.push('<td><span class="balls">'),$.each(t,function(a){e=0<a&&a<4?"curr":"",p.push("<i class="+e+">"+this+"</i>")}),p.push("</span></td>"),i=parseInt(t[1])+parseInt(t[2])+parseInt(t[3]),i=(""+i).split(""),i=i[i.length-1],p.push("<td>"+(isNaN(i)?"-":i)+"</td>"),p.push("</tr>")}),p.join("")}},i=[],h=[];h.push('<div class="ball-section">'),h.push('<div class="ball-section-top">'),h.push('<div class="ball-control">'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),h.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),h.push("</div>"),h.push('<h2 class="decimal-name decimal-name-empty"><#=title#></h2>'),h.push("</div>"),h.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9],function(a){h.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),h.push("</div>"),h.push("</div>");var r=[],o=[],u=h.join("");o.push(i.join("")),$.each([""],function(a){o.push(u.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),o.push(r.join(""));var c=a.Class(p,s);c.defConfig=n,e.setLoadedHas(n.name,new c)}(betgame,betgame.GameMethod);