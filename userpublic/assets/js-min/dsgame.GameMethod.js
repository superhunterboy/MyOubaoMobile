!function(e,t,a,n){var r={id:-1,name:"",UIContainer:"#J-balls-main-panel",ballsDom:".ball-number",ballCurrentCls:"ball-number-current",methodMassageDom:".prompt .method-tip",methodExampleDom:".prompt .example-tip",randomBetsNum:500},i=e.Games,l={init:function(e){var t=this;t.id=e.id,t.name=e.name,t.UIContainer=$(e.UIContainer),t.container=$("<div></div>").appendTo(t.UIContainer),t.buildUI(),t.hide(),t.balls=[],t.rebuildData(),t.ballsDom=t.getBallsDom(),t.isBallsComplete=!1,t.addEvent("updateData",function(e,t){var a=this,t=a.isBallsComplete?t:{lotterys:[],original:[]};i.getCurrentGameStatistics().updateData(t,a.getName()),a.batchSetBallDom()}),t.addEvent("afterReset",function(){t.exeEvent_cancelCurrentButton()}),t.addEvent("afterSetBallData",function(e,a,n,r){t.exeEvent_cancelCurrentButton(a,n,r)})},getId:function(){return this.id},setId:function(e){this.id=Number(e)},getBallsDom:function(){var e=this,t=e.defConfig,a=e.balls;return a.length<1?[]:e.ballsDom||function(){var n,r=e.container.find(t.ballsDom),i=0,l=[];return $.each(a,function(e){n=this,l[e]=[],$.each(n,function(t){l[e][t]=r[i],i++})}),l}()},updataGamesInfo:function(){var e=this,t=e.getGameMethodName(),a=i.getCurrentGame(),n=t+"lostcurrentFre",r="simulatedata/getBetAward.php?type="+t+"&extent=currentFre&line=5&lenth=30&lotteryid=99101&userid=31";i.cacheData.gameBonus||(i.cacheData.gameBonus={}),i.cacheData.gameTips||(i.cacheData.gameTips={}),i.cacheData.frequency||(i.cacheData.frequency={}),i.cacheData.gameBonus[r]&&a.addDynamicBonus(t,i.cacheData.gameBonus[r]),i.cacheData.gameTips[r]&&e.methodTip(i.cacheData.gameTips[r]),i.cacheData.frequency[n]&&e.getHotCold(t,"currentFre","lost"),i.cacheData.gameBonus[r]&&i.cacheData.frequency[n]&&i.cacheData.gameTips[r]||$.ajax({url:r,dataType:"json",success:function(l){1==Number(l.isSuccess)&&(data=l.data,"undefined"!=typeof data.gameTips&&(i.cacheData.gameTips[r]=data.gameTips,e.methodTip(data.gameTips)),"undefined"!=typeof data.frequency&&(i.cacheData.frequency[n]=data.frequency,e.getHotCold(t,"currentFre","lost")),"undefined"!=typeof data.bonus&&(i.cacheData.gameBonus[r]=data.bonus,a.addDynamicBonus(t,data.bonus)))}})},methodTip:function(e){var t=this,a=t.defConfig;$(a.methodMassageDom).html(e.tips),$(a.methodExampleDom).html(e.example)},formatViewBalls:function(e){for(var t=[],a=e.length,n=0;a>n;n++)t=t.concat(e[n].join(""));return t.join("|")},makePostParameter:function(e){for(var t=[],a=e.length,n=0;a>n;n++)t=t.concat(e[n].join(""));return t.join("|")},arrIndexOf:function(e,t){for(var a=0,n=0;n<t.length;n++)t[n]==e&&(a+=1);return a||-1},rebuildData:function(){},getBallData:function(){return this.balls},setBallData:function(e,t,a){var n=this,r=n.getBallData();n.fireEvent("beforeSetBallData",e,t,a),e>=0&&e<r.length&&t>=0&&(r[e][t]=a),n.fireEvent("afterSetBallData",e,t,a)},setBallAidData:function(e,t,a,n){var r=this,i="ball-aid",l=r.getBallsAidDom(),n=n?i+" "+n:i;e>=0&&e<l.length&&t>=0&&t<l[0].length&&(l[e][t].innerHTML=a,l[e][t].className=n)},reSet:function(){var e=this;e.isBallsComplete=!1,e.rebuildData(),e.updateData(),e.fireEvent("afterReset")},getName:function(){return this.name},setName:function(e){this.name=e},show:function(){var e=this;e.fireEvent("beforeShow"),e.container.show(),e.fireEvent("afterShow")},hide:function(){var e=this;e.fireEvent("beforeHide"),e.container.hide(),e.fireEvent("afterHide")},exeEvent:function(e,t){var a=this;$.isFunction(a["exeEvent_"+e.action])&&a["exeEvent_"+e.action].call(a,e,t)},exeEvent_batchSetBall:function(e,t){var a=this,n=a.balls,r=Number(e.row),i=e.bound,l=n[r],o=0,s=l.length,u="undefined"==typeof e.start?0:Number(e.start);for(halfLen=Math.ceil((s-u)/2+u),dom=$(t),o=u;s>o;o++)a.setBallData(r,o,-1);switch(i){case"all":for(o=u;s>o;o++)a.setBallData(r,o,1);break;case"big":for(o=halfLen;s>o;o++)a.setBallData(r,o,1);break;case"small":for(o=u;halfLen>o;o++)a.setBallData(r,o,1);break;case"odd":for(o=u;s>o;o++)(o+1)%2!=1&&a.setBallData(r,o,1);break;case"even":for(o=u;s>o;o++)(o+1)%2==1&&a.setBallData(r,o,1);break;case"none":}dom.addClass("current"),a.updateData()},exeEvent_cancelCurrentButton:function(e){var t=this,a=t.container,n="undefined"!=typeof e?a.find(".ball-control").eq(e):a.find(".ball-control");n.find("a").removeClass("current")},exeEvent_ball:function(e,t){var a=this,r=$(t),i=a.defConfig.ballCurrentCls;if(e.value!=n&&e.row!=n)r.hasClass(i)?a.setBallData(Number(e.row),Number(e.value),-1):(a.fireEvent("beforeSelect",e),a.setBallData(Number(e.row),Number(e.value),1));else try{}catch(l){}a.updateData()},batchSetBallDom:function(){for(var e=this,t=e.defConfig,a=t.ballCurrentCls,n=e.balls,r=0,i=0,l=n.length,o=0,s=e.getBallsDom(),u="";l>r;r++)for(o=n[r].length,i=0;o>i;i++)1==n[r][i]?(u=s[r][i].className,u=(" "+u+" ").replace(" "+a,""),u+=" "+a,s[r][i].className=u.replace(/\s+/g," ")):(u=s[r][i].className,u=(" "+u+" ").replace(" "+a,""),s[r][i].className=u.replace(/\s+/g," "))},updateData:function(){var e=this,t=e.getLottery();e.fireEvent("updateData",{lotterys:t,original:e.getOriginal()})},editSubmitData:function(){},getOriginal:function(){for(var e=this,t=e.getBallData(),a=t.length,n=0,r=0,i=0,l=[],o=[];a>r;r++){for(l=[],n=t[r].length,i=0;n>i;i++)t[r][i]>0&&l.push(i);o.push(l)}return o},reSelect:function(e){var t,a,n,r,i,l,o=this,s=(o.getName(),e),u=!1;for(o.reSet(),t=0,a=s.length;a>t;t++)for(n=0,r=s[t].length;r>n;n++)i=t,l=s[t][n],o.setBallData(i,l,1),u=!0;u&&o.updateData()},getLottery:function(e){for(var t,a=this,n=a.getBallData(),r=0,i=n.length,l=!0,o=0,s=0,u=[],c=1,m=0;i>r;r++){for(u[r]=[],t=n[r],s=t.length,l=!0,m=0,o=0;s>o;o++)t[o]>0&&(l=!1,e||u[r].push(o),m++);if(l)return a.isBallsComplete=!1,[];c*=m}return a.isBallsComplete=!0,e?c:a.isBallsComplete?a.combination(u):[]},removeSame:function(e){{var t,a=0,n=this,r=this.getBallData()[0].length;e.length}for(t=Math.floor(Math.random()*r);a<e.length;a++)if(t==e[a])return arguments.callee.call(n,e);return t},removeArraySame:function(e){{var t,a=this,n=0,r=a.getBallData()[0].length;data.length}for(t=Math.floor(Math.random()*r);n<e.length;n++)if(t==e[n])return arguments.callee.call(a,e);return t},getRandomBetsNum:function(){return this.defConfig.randomBetsNum},createRandomNum:function(){for(var e=this,t=[],a=e.getBallData().length,n=e.getBallData()[0].length,r=0;a>r;r++)t[r]=[Math.floor(Math.random()*n)],t[r].sort(function(e,t){return e>t?1:-1});return t},checkRandomBets:function(e,t){var a=this,n="undefined"==typeof e?!0:!1,e=e||{},r=[],t=t||0,l=(a.getBallData().length,a.getBallData()[0].length,i.getCurrentGameOrder().getTotal().orders);if(r=a.createRandomNum(),Number(t)>Number(a.getRandomBetsNum()))return r;if(n)for(var o=0;o<l.length;o++)if(l[o].type==a.defConfig.name){var s=l[o].original.join("");e[s]=s}return e[r.join("")]?(t++,arguments.callee.call(a,e,t)):r},randomNum:function(){var e=this,t=[],a=null,n=(e.getBallData(),e.defConfig.name,i.getCurrentGame().getCurrentGameMethod().getGameMethodName()),r=[],l=[];return t=e.checkRandomBets(),l=t,r=e.combination(l),a={type:n,original:l,lotterys:r,moneyUnit:i.getCurrentGameStatistics().getMoneyUnit(),multiple:i.getCurrentGameStatistics().getMultip(),onePrice:i.getCurrentGame().getGameConfig().getInstance().getOnePrice(n),num:r.length},a.amountText=i.getCurrentGameStatistics().formatMoney(a.num*a.moneyUnit*a.multiple*a.onePrice),a},randomLotterys:function(e){var t=this,a=0;for(i.getCurrentGameOrder().cancelSelectOrder();e>a;a++)i.getCurrentGameOrder().add(t.randomNum())},ballsErrorTip:function(){},countBallsNum:function(){for(var e=this,t=0,a=e.getBallData(),n=a.length-1;n>=0;n--)if("[object Array]"==Object.prototype.toString.call(a[n])&&a[n].length>0)for(var r=a[n].length-1;r>=0;r--)1==a[n][r]&&t++;else 1==a[n]&&t++;return t},countBallsNumInLine:function(e){var t=this,a=0,n=t.getBallData();if("[object Array]"==Object.prototype.toString.call(n[e])&&n[e].length>0)for(var r=n[e].length-1;r>=0;r--)1==n[e][r]&&a++;else 1==n[e]&&a++;return a||-1},LimitMaxBalls:function(e){{var t=this,a=0;t.getBallData(),Number(a)}return a=t.countBallsNum(),a>e?!0:!1},checkBallIsComplete:function(){for(var e,t=this,a=t.getBallData(),n=0,r=a.length,i=!0,l=0,o=0;r>n;n++){for(e=a[n],o=e.length,i=!0,l=0;o>l;l++)e[l]>0&&(i=!1);if(i)return t.isBallsComplete=!1,!1}return t.isBallsComplete=!0},combine:function(e,t,a){var n=[],r=0;if(a=a||[],0==t)return[a];for(;r<=e.length-t;r++)n=n.concat(arguments.callee(e.slice(r+1),t-1,a.slice(0).concat(e[r])));return n},combination:function(e){if(e.length<1)return[];var t,a,n,r=(e[0].length,e.length),i=[],l=[],o=[];for(i[t=r]=1;t--;)i[t]=i[t+1]*e[t].length;for(n=i[0],t=0;n>t;t++){for(o=[],a=0;r>a;a++)o[a]=e[a][~~(t%i[a]/i[a+1])];l[t]=o}return l},miniTrend_create:function(){var e,t=this,a=[];return a.push(t.miniTrend_createHeadHtml()),a.push(t.miniTrend_createRowHtml()),a.push(t.miniTrend_createFootHtml()),e=$(a.join("")),t.miniTrend_getContainer().prepend(e),e},miniTrend_createHeadHtml:function(){var e=this,t=[];return t.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+e.getId()+'">'),t.push("<thead><tr>"),t.push('<th><span class="number">奖期</span></th>'),t.push('<th><span class="balls">开奖</th>'),t.push("</tr></thead>"),t.push("<tbody>"),t.join("")},miniTrend_createRowHtml:function(){var e,t=this,a=t.miniTrend_getBallsData(),n=a.length,r="",i="curr",l=[];return $.each(a,function(t){e=this,r="",r=0==t?"first":r,r=t==n-1?"last":r;var a=e.wn_number.split(-1==e.wn_number.indexOf(" ")?"":" ");l.push('<tr class="'+r+'">'),l.push('<td><span class="number">'+e.issue.substr(2)+" 期</span></td>"),l.push('<td><span class="balls">'),$.each(a,function(){l.push("<i class="+i+">"+this+"</i>")}),l.push("</span></td>"),l.push("</tr>")}),l.join("")},miniTrend_createFootHtml:function(){var e=[];return e.push("</tbody>"),e.push("</table>"),e.join("")},miniTrend_updateTrend:function(){var e=this,t=e.miniTrend_getTrendTable().find("tbody");t.html(e.miniTrend_createRowHtml()),e.miniTrend_getContainer().find(".bet-table-trend").hide(),e.miniTrend_getTrendTable().show()},miniTrend_getTrendTable:function(){var e=this,t=this.getId(),a=$("#J-minitrend-trendtable-"+t);return a.size()>0?a:e.miniTrend_create()},miniTrend_getContainer:function(){return this.miniTrendContainer||(this.miniTrendContainer=$("#J-minitrend-cont"))},miniTrend_getBallsData:function(){var e=gameConfigData.issueHistory,t=e.issues;return t[0].issue==e.last_number.issue&&(""==t[0].wn_number&&""!=e.last_number.wn_number?t[0].wn_number=e.last_number.wn_number:""!=t[0].wn_number&&""==e.last_number.wn_number&&(e.last_number.wn_number=t[0].wn_number)),t},miniTrend_updateTrendUrl:function(){}},o=e.Class(l,a);o.defConfig=r,e[t]=o}(dsgame,"GameMethod",dsgame.Event);