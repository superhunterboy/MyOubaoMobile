/*‮*/!function(s,n,t){var a={name:"qiansan.qita.teshuhaoma"},r=s.Games,e=r.SSC.getInstance(),h={init:function(s){},rebuildData:function(){var s=this;s.balls=[[-1,-1,-1]]},buildUI:function(){var s=this;s.container.html(o.join(""))},formatViewBalls:function(s){for(var n=[],t=s.length,a=0,r=[],e=["豹子","顺子","对子"];a<t;a++)r=[],$.each(s[a],function(n){r[n]=e[Number(s[a][n])]}),n=n.concat(r.join("|"));return n.join("")},checkBallIsComplete:function(){for(var s=this,n=s.getBallData()[0],t=0,a=n.length,r=0;t<a;t++)n[t]>0&&r++;return r>=1?s.isBallsComplete=!0:s.isBallsComplete=!1},getLottery:function(){for(var s=this,n=s.getBallData()[0],t=0,a=n.length,r=[];t<a;t++)n[t]>0&&r.push(t);return s.checkBallIsComplete()?r:[]},miniTrend_createHeadHtml:function(){var s=this,n=[];return n.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+s.getId()+'">'),n.push("<thead><tr>"),n.push('<th><span class="number">奖期</span></th>'),n.push('<th><span class="balls">开奖</th>'),n.push("<th><span>形态</span></th>"),n.push("</tr></thead>"),n.push("<tbody>"),n.join("")},miniTrend_createRowHtml:function(){var s,n=this,t=n.miniTrend_getBallsData(),a=t.length,r="",e="curr",h=[];return $.each(t,function(n){s=this,r="",r=0==n?"first":r,r=n==a-1?"last":r;var t=s.wn_number.split("");h.push('<tr class="'+r+'">'),h.push('<td><span class="number">'+s.issue.substr(2)+" 期</span></td>"),h.push('<td><span class="balls">'),$.each(t,function(s){e=s<3?"curr":"",h.push("<i class="+e+">"+this+"</i>")}),h.push("</span></td>"),shunArr=[],shunArr.push(parseInt(t[0])),shunArr.push(parseInt(t[1])),shunArr.push(parseInt(t[2])),shunArr.sort();var u="杂六";shunArr[0]==shunArr[1]&&shunArr[0]==shunArr[2]?u="豹子":0==shunArr[0]&&1==shunArr[1]&&9==shunArr[2]||shunArr[0]-shunArr[1]==-1&&shunArr[1]-shunArr[2]==-1?u="顺子":shunArr[0]!=shunArr[1]&&shunArr[1]!=shunArr[2]||(u="对子"),h.push("<td>"+u+"</td>"),h.push("</tr>")}),h.join("")}},u=[],l=[];l.push('<div class="ball-section">'),l.push('<div class="ball-section-content">'),$.each(["豹子","顺子","对子"],function(s){l.push('<label class="ball-number ball-number-long" data-value="'+this+'" data-param="action=ball&value='+s+'&row=<#=row#>">'+this+"</label>")}),l.push("</div>"),l.push("</div>");var i=[],o=[],c=l.join("");o.push(u.join("")),$.each([""],function(s){o.push(c.replace(/<#=title#>/g,this).replace(/<#=row#>/g,s))}),o.push(i.join(""));var p=s.Class(h,n);p.defConfig=a,e.setLoadedHas(a.name,new p)}(betgame,betgame.GameMethod);