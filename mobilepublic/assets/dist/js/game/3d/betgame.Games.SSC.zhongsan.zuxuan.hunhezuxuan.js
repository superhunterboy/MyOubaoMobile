/*‮*/!function(t,e,a){var n={name:"zhongsan.zuxuan.hunhezuxuan",UIContainer:"#J-balls-main-panel"},s=t.Games,r=s.SSC.getInstance(),i={init:function(t){var e=this;setTimeout(function(){e.initFrame()},25)},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},checkSingleNum:function(t){var e=this;return t.length==e.balls.length&&((t[0]!=t[1]||t[0]!=t[2])&&(e.defConfig.checkNum.test(t.join(""))&&t.length==e.balls.length))},checkBallIsComplete:function(t){var e,a,n,s=this,r=0,i={},l=[];for(s.aData=[],s.vData=[],s.sameData=[],s.errorData=[],s.tData=[],l=s.iterator(t),e=l.length,r=0;r<e;r++)a=l[r].split(""),n=l[r].split("").sort(),s.checkSingleNum(a)?i[n]?s.sameData.push(a):(s.tData.push(a),i[n]=!0):s.errorData.push(a);return s.tData.length>0?(s.isBallsComplete=!0,s.tData):(s.isBallsComplete=!1,[])},randomNum:function(){var t=this,e=0,a=[],n=[],r=null,i=[],l=(t.getBallData(),t.getBallData().length),u=t.getBallData()[0].length,h=s.getCurrentGame().getCurrentGameMethod().getGameMethodName();t.defConfig.name;for(t.addRanNumTag();e<l;e++)2==e?a[e]=t.removeSameNum(a):a[e]=Math.floor(Math.random()*u);return a.sort(function(t,e){return t>e?1:-1}),i=[[a.join(",")],[],[]],n.push(a),r={type:h,original:i,lotterys:n,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:s.getCurrentGameStatistics().getMultip(),onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePrice(h),num:n.length},r.amountText=s.getCurrentGameStatistics().formatMoney(r.num*r.moneyUnit*r.multiple*r.onePrice),r},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("<th><span>形态</span></th>"),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,a=e.miniTrend_getBallsData(),n=a.length,s="",r="curr",i=[],l="";return $.each(a,function(e){t=this,s="",s=0==e?"first":s,s=e==n-1?"last":s;var a=t.wn_number.split("");i.push('<tr class="'+s+'">'),i.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),i.push('<td><span class="balls">'),$.each(a,function(t){r=t>0&&t<4?"curr":"",i.push("<i class="+r+">"+this+"</i>")}),i.push("</span></td>"),l=parseInt(a[1])==parseInt(a[2])||parseInt(a[1])==parseInt(a[3])||parseInt(a[2])==parseInt(a[3])?parseInt(a[1])==parseInt(a[2])&&parseInt(a[1])==parseInt(a[3])?"豹子":"组三":"组六",i.push("<td>"+l+"</td>"),i.push("</tr>")}),i.join("")}},l=t.Class(i,e);l.defConfig=n,r.setLoadedHas(n.name,new l)}(betgame,betgame.Games.SSC.Danshi);