/*‮*/!function(a,t,l){var e={name:"sanma.zhixuan.fushi",tips:"",exampleTip:"",randomBetsNum:500},n="L115",s=a.Games[n].getInstance(),o={init:function(a){},rebuildData:function(){var a=this;a.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var a=this;a.container.html(c.join(""))},setBallData:function(a,t,l){var e=this,n=e.getBallData();0!=t&&(e.fireEvent("beforeSetBallData",a,t,l),a>=0&&a<n.length&&t>=0&&(n[a][t]=l),e.fireEvent("afterSetBallData",a,t,l))},makePostParameter:function(a){var t,l=[],e=[],n=0;for($.each(a,function(t){e[t]=[],$.each(a[t],function(l){e[t][l]=a[t][l]<10?"0"+a[t][l]:""+a[t][l]})}),t=e.length,n=0;n<t;n++)l=l.concat(e[n].join(" "));return l.join("|")},formatViewBalls:function(a){return this.makePostParameter(a)},checkBallIsComplete:function(){for(var a=this,t=a.getBallData(),l=0,e=t[0].length,n=0,s=0,o=0;l<e;l++)t[0][l]>0&&n++,t[1][l]>0&&s++,t[2][l]>0&&o++;return n>=1&&s>=1&&o>=1?a.isBallsComplete=!0:a.isBallsComplete=!1},filterErrorData:function(a,t,l,e){var n=this,e=e||[],l=l||0,t=t||a.length;return l==t?e:(a[l][0]!=a[l][1]&&a[l][0]!=a[l][2]&&a[l][1]!=a[l][2]&&e.push(a[l]),l++,n.filterErrorData(a,t,l,e))},getLottery:function(a){for(var t,l=this,e=l.getBallData(),n=0,s=e.length,o=!0,r=0,i=0,p=[],c=1,u=0;n<s;n++){for(p[n]=[],t=e[n],i=t.length,o=!0,u=0,r=0;r<i;r++)t[r]>0&&(o=!1,a||p[n].push(r),u++);if(o)return l.isBallsComplete=!1,[];c*=u}return l.isBallsComplete=!0,a?c:l.isBallsComplete?p=l.filterErrorData(l.combination(p)):[]}},r=[],i=[];i.push('<div class="ball-section">'),i.push('<div class="ball-section-top">'),i.push('<div class="ball-control">'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=all" class="all">全</span>'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=big" class="big">大</span>'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=small" class="small">小</span>'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=odd" class="odd">单</span>'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=even" class="even">双</span>'),i.push('<span data-param="action=batchSetBall&amp;row=<#=row#>&amp;bound=none" class="none">清</span>'),i.push("</div>"),i.push('<h2 class="decimal-name"><#=title#></h2>'),i.push("</div>"),i.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6,7,8,9,10,11],function(a){var t=a<10?"0"+this:this;0==a?i.push('<label class="ball-number ball-number-hidden" data-value="'+t+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+t+"</label>"):i.push('<label class="ball-number" data-value="'+t+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+t+"</label>")}),i.push("</div>"),i.push("</div>");var p=[],c=[],u=i.join("");c.push(r.join("")),$.each(["一位","二位","三位"],function(a){c.push(u.replace(/<#=title#>/g,this).replace(/<#=row#>/g,a))}),c.push(p.join(""));var h=a.Class(o,t);h.defConfig=e,s.setLoadedHas(e.name,new h)}(betgame,betgame.GameMethod);