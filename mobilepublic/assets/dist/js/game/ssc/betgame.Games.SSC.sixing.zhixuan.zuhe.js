/*‮*/!function(a,s,t){var n={name:"sixing.zhixuan.zuhe",tips:"四星直选组合玩法提示",exampleTip:"四星直选组合范例"},l=a.Games.SSC.getInstance(),e={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(h.join(""))},getLottery:function(a){for(var s,t=this,n=t.getBallData(),l=0,e=n.length,i=!0,p=0,r=0,h=[],o=[],u=[],c=[],d=0;l<e;l++){for(h[l]=[],s=n[l],r=s.length,i=!0,d=0,p=0;p<r;p++)s[p]>0&&(i=!1,a||h[l].push(p),d++);if(i)return t.isBallsComplete=!1,[]}if(t.isBallsComplete=!0,t.isBallsComplete){for(o=t.combination(h),e=o.length,l=0;l<e;l++)for(r=o[l].length,p=0;p<r;p++)c=o[l].slice(p),u.push(c);return u}return[]},miniTrend_createHeadHtml:function(){var a=this,s=[];return s.push('<table width="100%" class=" table bet-table-trend" id="J-minitrend-trendtable-'+a.getId()+'">'),s.push("<thead><tr>"),s.push('<th><span class="number">奖期</span></th>'),s.push('<th><span class="balls">开奖</th>'),s.push("</tr></thead>"),s.push("<tbody>"),s.join("")},miniTrend_createRowHtml:function(){var a,s=this,t=s.miniTrend_getBallsData(),n=t.length,l="",e="curr",i=[];return $.each(t,function(s){a=this,l="",l=0==s?"first":l,l=s==n-1?"last":l;var t=a.wn_number.split("");i.push('<tr class="'+l+'">'),i.push('<td><span class="number">'+a.issue.substr(2)+" 期</span></td>"),i.push('<td><span class="balls">'),$.each(t,function(a){e=a>0?"curr":"",i.push("<i class="+e+">"+this+"</i>")}),i.push("</span></td>"),i.push("</tr>")}),i.join("")}},i=[],p=[];p.push('<div class="ball-section">'),p.push('<div class="ball-section-top">'),p.push('<div class="ball-control">'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),p.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),p.push("</div>"),p.push('<h2 class="decimal-name"><#=title#></h2>'),p.push("</div>"),p.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9],function(a){p.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),p.push("</div>"),p.push("</div>");var r=[],h=[],o=p.join("");h.push(i.join("")),$.each(["千位","百位","十位","个位"],function(a){h.push(o.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),h.push(r.join(""));var u=a.Class(e,s);u.defConfig=n,l.setLoadedHas(n.name,new u)}(betgame,betgame.GameMethod);