/*‮*/!function(a,t,n){var s={name:"budingwei.sanxingbudingwei.housan",tips:"前二直选复式玩法提示",exampleTip:"前二直选复式范例"},l=a.Games,e=l.PK10.getInstance(),i={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},createRandomNum:function(){for(var a=this,t=[],n=a.getBallData().length,s=a.getBallData()[0].length,l=0;l<n;l++)t[l]=[Math.ceil(Math.random()*(s-1))],t[l].sort(function(a,t){return a>t?1:-1});return t},makePostParameter:function(a,t){for(var n=[],a=t.original,s=0;s<a.length;s++)n=n.concat(a[s].join("-"));return n.join("|")},editSubmitData:function(a){var t,n,s=a.ball.split("|"),l=0,e=s.length,i=0;for(l=0;l<e;l++){for(n=s[l].split("-"),t=n.length,i=0;i<t;i++)""!=n[i]&&(n[i]=Number(n[i])-1);s[l]=n.join("")}a.ball=s.join("|"),console.log(a)},buildUI:function(){var a=this;a.container.html(p.join(""))},setBallData:function(a,t,n){var s=this,l=s.getBallData();0!=t&&(s.fireEvent("beforeSetBallData",a,t,n),a>=0&&a<l.length&&t>=0&&(l[a][t]=n),s.fireEvent("afterSetBallData",a,t,n))},getLottery:function(a){for(var t,n=this,s=n.getBallData(),l=0,e=s.length,i=0,r=0,o=[],h=[],p=1,u=0;l<e;l++){for(o[l]=[],t=s[l],r=t.length,isEmptySelect=!0,u=0,i=0;i<r;i++)t[i]>0&&(n.isBallsComplete=!0,a||o[l].push(i),u++);p*=u}if(a)return p;if(n.isBallsComplete){for(l=0,e=o.length;l<e;l++)for(i=0,r=o[l].length;i<r;i++)h.push([o[l][i]]);return h}return[]},miniTrend_createHeadHtml:function(){var a=this,t=[];return t.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+a.getId()+'">'),t.push("<thead><tr>"),t.push('<th><span class="number">奖期</span></th>'),t.push('<th><span class="balls">开奖</th>'),t.push("</tr></thead>"),t.push("<tbody>"),t.join("")},miniTrend_createRowHtml:function(){var a,t=this,n=t.miniTrend_getBallsData(),s=n.length,l="",e=[];return $.each(n,function(t){a=this,l="",l=0==t?"first":l,l=t==s-1?"last":l;var n=a.wn_number.indexOf(" ")==-1?a.wn_number.split(""):a.wn_number.split(" ");e.push('<tr class="'+l+'">'),e.push('<td class="abel"><span class="number">'+a.issue+" 期</span></td>"),e.push('<td class="abel"><span class="balls">'),$.each(n,function(a){e.push("<i>"+this+"</i>")}),e.push("</span></td>"),e.push("</tr>")}),e.join("")}},r=[],o=[];o.push('<div class="ball-section">'),o.push('<div class="ball-section-top">'),o.push('<div class="ball-control">'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),o.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),o.push("</div>"),o.push('<h2 class="decimal-name"><#=title#></h2>'),o.push("</div>"),o.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10],function(a){0==a?o.push('<label class="ball-number ball-number-hidden" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>"):o.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),o.push("</div>"),o.push("</div>");var h=[],p=[],u=o.join("");p.push(r.join("")),$.each(["后三"],function(a){p.push(u.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),p.push(h.join(""));var c=a.Class(i,t);c.defConfig=s,e.setLoadedHas(s.name,new c)}(betgame,betgame.GameMethod);