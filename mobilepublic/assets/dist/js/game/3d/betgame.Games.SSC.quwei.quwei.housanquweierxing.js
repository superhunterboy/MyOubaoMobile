/*‮*/!function(a,n,t){var l={name:"quwei.quwei.housanquweierxing"},s=a.Games,o=s.SSC.getInstance(),e={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(u.join(""))},formatViewBalls:function(a){for(var n=[],t=a.length,l=0,s=[],o=["小","大"];l<t;l++)l<1?(s=[],$.each(a[l],function(n){s[n]=o[Number(a[l][n])]}),n=n.concat(s.join(""))):n=n.concat(a[l].join(""));return n.join("|")},exeEvent_cancelCurrentButton:function(a,n,t){var l=this,s=l.container;s.find(".ball-control").each(function(){"undefined"!=typeof a?s.find(".ball-control").each(function(){$(this).attr("row")==a&&$(this).find("a").removeClass("current")}):s.find(".ball-control").find("a").removeClass("current")})}},i=[],c=[];c.push('<div class="ball-section">'),c.push('<div class="ball-section-top">'),c.push('<div class="ball-control">'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),c.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),c.push("</div>"),c.push('<h2 class="decimal-name"><#=title#></h2>'),c.push("</div>"),c.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9],function(a){c.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+a+'&row=<#=row#>">'+this+"</label>")}),c.push("</div>"),c.push("</div>");var r=[];r.push('<div class="ball-section">'),r.push('<div class="ball-section-top">'),r.push('<h2 class="decimal-name"><#=title#></h2>'),r.push("</div>"),r.push('<div class="ball-section-content">'),$.each(["小(0-4)","大(5-9)"],function(a){r.push('<label class="ball-number ball-number-long" data-value="'+this+'" data-param="action=ball&value='+a+'&row=<#=row#>">'+this+"</label>")}),r.push("</div>"),r.push("</div>");var p=[],u=[];rowStr=c.join(""),rowStr1=r.join(""),u.push(i.join("")),$.each(["百位"],function(a){u.push(rowStr1.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),$.each(["十位","个位"],function(a){u.push(rowStr.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a+1))}),u.push(p.join(""));var h=a.Class(e,n);h.defConfig=l,o.setLoadedHas(l.name,new h)}(betgame,betgame.GameMethod);