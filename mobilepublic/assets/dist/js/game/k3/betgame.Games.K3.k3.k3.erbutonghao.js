/*‮*/!function(e,t,a){var n={name:"k3.k3.erbutonghao",tips:"",exampleTip:""},l=e.Games,i=l.K3.getInstance(),r={init:function(e){},rebuildData:function(){var e=this;e.balls=[[-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var e=this;e.container.html(h.join(""))},makePostParameter:function(e){for(var t=0,a=e.length,n=[];t<a;t++)n.push(e[t].join("|"));return n.join("")},checkBallIsComplete:function(){for(var e=this,t=e.getBallData()[0],a=0,n=t.length,l=0;a<n;a++)t[a]>0&&l++;return l>=2?e.isBallsComplete=!0:e.isBallsComplete=!1},formatViewBalls:function(e){for(var t=[],a=e[0].length,n={1:"1",2:"2",3:"3",4:"4",5:"5",6:"6"},l=0;l<a;l++)t.push(n[""+e[0][l]]);return t=t.join("")},getLottery:function(e){var t=this,a=t.getBallData()[0],n=[];return t.checkBallIsComplete()&&($.each(a,function(e){this>0&&n.push(e+1)}),n=t.combine(n,2)),n},randomNum:function(){for(var t=this,a=0,n=[],i=[],r=[],o=null,s=(t.getBallData(),t.getBallData()[0].length),u=l.getCurrentGame().getCurrentGameMethod().getName(),h=l.getCurrentGame().getCurrentGameMethod().getId(),a=(t.defConfig.name,s-1);a>=0;a--)a>0&&n.push(a);for(var m=0;m<2;m++){var c=Math.floor(Math.random()*n.length);i.push(n[c]),n.splice(c,1)}return i.sort(function(e,t){return e-t}),r.push([i[0],i[1]]),o={mid:h,type:u,original:[i],lotterys:r,moneyUnit:l.getCurrentGameStatistics().getMoneyUnit(),multiple:1,onePrice:l.getCurrentGame().getGameConfig().getInstance().getOnePriceById(h),num:r.length},o.amountText=e.util.formatMoney(o.num*o.moneyUnit*o.multiple*o.onePrice),o}},o=[],s=[];s.push('<div class="ball-section">'),s.push('<div class="ball-section-content">'),$.each([0,1,2,3,4,5,6],function(e){0==e?s.push('<label class="ball-number ball-number-hidden" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>"):s.push('<label class="ball-number" data-value="'+this+'" data-param="action=ball&value='+this+'&row=<#=row#>">'+this+"</label>")}),s.push("</div>"),s.push("</div>");var u=[],h=[],m=s.join("");h.push(o.join("")),$.each([""],function(e){h.push(m.replace(/<#=title#>/g,this).replace(/<#=row#>/g,e))}),h.push(u.join(""));var c=e.Class(r,t);c.defConfig=n,i.setLoadedHas(n.name,new c)}(betgame,betgame.GameMethod);