/*‮*/!function(a,t,l){var n={name:"renxuanfushi.renxuanfushi.renxuanqi",UIContainer:"#J-balls-main-panel"},e="L115",s=(a.Games,a.Games[e].getInstance()),o={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(p.join(""))},setBallData:function(a,t,l){var n=this,e=n.getBallData();0!=t&&(n.fireEvent("beforeSetBallData",a,t,l),a>=0&&a<e.length&&t>=0&&(e[a][t]=l),n.fireEvent("afterSetBallData",a,t,l))},checkBallIsComplete:function(){for(var a=this,t=a.getBallData()[0],l=0,n=t.length,e=0;l<n;l++)t[l]>0&&e++;return e>=7?a.isBallsComplete=!0:a.isBallsComplete=!1},getLottery:function(){for(var a=this,t=a.getBallData()[0],l=0,n=t.length,e=[];l<n;l++)t[l]>0&&e.push(l);return a.checkBallIsComplete()?a.combine(e,7):[]},makePostParameter:function(a){var t,l=[],n=[],e=0;for($.each(a,function(t){n[t]=[],$.each(a[t],function(l){n[t][l]=a[t][l]<10?"0"+a[t][l]:""+a[t][l]})}),t=n.length,e=0;e<t;e++)l=l.concat(n[e].join(" "));return l.join("|")},formatViewBalls:function(a){return this.makePostParameter(a)}},i=[],r=[];r.push('<div class="ball-section">'),r.push('<div class="ball-section-top">'),r.push('<div class="ball-control">'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),r.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),r.push("</div>"),r.push('<h2 class="decimal-name"><#=title#></h2>'),r.push("</div>"),r.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10,11],function(a){var t=a<10?"0"+this:this;0==a?r.push('<label class="ball-number ball-number-hidden" data-value="'+t+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+t+"</label>"):r.push('<label class="ball-number" data-value="'+t+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+t+"</label>")}),r.push("</div>"),r.push("</div>");var c=[],p=[],u=r.join("");p.push(i.join("")),$.each(["选7中5"],function(a){p.push(u.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),p.push(c.join(""));var h=a.Class(o,t);h.defConfig=n,s.setLoadedHas(n.name,new h)}(betgame,betgame.GameMethod);