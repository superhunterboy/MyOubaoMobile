/*‮*/!function(t,e,n){var a={name:"erxing.zhixuan.houerdanshi",tips:"后二直选单式玩法提示",exampleTip:"后二直选单式弹出层22提示"},s=t.Games,i=s.SSC.getInstance(),r={init:function(t){var e=this;setTimeout(function(){e.initFrame()},25)},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},randomNum:function(){var t=this,e=0,n=[],a=[],i=null,r=(t.getBallData(),t.getBallData().length,t.getBallData()[0].length,t.defConfig.name,s.getCurrentGame().getCurrentGameMethod().getGameMethodName()),u=[];for(t.addRanNumTag();e<2;e++){var l=t.removeSameNum(n);n.push(l)}return n.sort(function(t,e){return t>e?1:-1}),u=[[n.join(",")],[]],a.push(n),i={type:r,original:u,lotterys:a,moneyUnit:s.getCurrentGameStatistics().getMoneyUnit(),multiple:s.getCurrentGameStatistics().getMultip(),onePrice:s.getCurrentGame().getGameConfig().getInstance().getOnePrice(r),num:a.length},i.amountText=s.getCurrentGameStatistics().formatMoney(i.num*i.moneyUnit*i.multiple*i.onePrice),i},miniTrend_createHeadHtml:function(){var t=this,e=[];return e.push('<table width="100%" class="table bet-table-trend" id="J-minitrend-trendtable-'+t.getId()+'">'),e.push("<thead><tr>"),e.push('<th><span class="number">奖期</span></th>'),e.push('<th><span class="balls">开奖</th>'),e.push("</tr></thead>"),e.push("<tbody>"),e.join("")},miniTrend_createRowHtml:function(){var t,e=this,n=e.miniTrend_getBallsData(),a=n.length,s="",i="curr",r=[];return $.each(n,function(e){t=this,s="",s=0==e?"first":s,s=e==a-1?"last":s;var n=t.wn_number.split("");r.push('<tr class="'+s+'">'),r.push('<td><span class="number">'+t.issue.substr(2)+" 期</span></td>"),r.push('<td><span class="balls">'),$.each(n,function(t){i=t>2?"curr":"",r.push("<i class="+i+">"+this+"</i>")}),r.push("</span></td>"),r.push("</tr>")}),r.join("")}},u=t.Class(r,e);u.defConfig=a,i.setLoadedHas(a.name,new u)}(betgame,betgame.Games.SSC.Danshi);