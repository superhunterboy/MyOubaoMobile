/*‮*/!function(e,t,n){var a={name:"erma.zuxuan.danshi",tips:"",exampleTip:"",exampleText:"03 04 06<br />04 05 06<br />01 04 05 <br />01 06 08 <br />01 03 06"},i="L115",s=(e.Games,e.Games[i].getInstance()),r={init:function(e){var t=this;setTimeout(function(){t.initFrame()},25)},rebuildData:function(){var e=this;e.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},checkSingleNum:function(e){var t=this,n=!0;return 2==e.length&&(e[0]!=e[1]&&($.each(e,function(){if(!t.defConfig.checkNum.test(this)||Number(this)<1||Number(this)>11)return n=!1,!1}),n))}},m=e.Class(r,t);m.defConfig=a,s.setLoadedHas(a.name,new m)}(betgame,betgame.Games.L115.Danshi);