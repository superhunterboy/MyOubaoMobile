!function(e,t,n){var r,u=gameConfigData,i={},a={},o={};!function(){var e,t,n,r=u.wayGroups;$.each(r,function(){e=this,e.fullname_en=[e.name_en],e.fullname_cn=[e.name_cn],a[""+e.id]=e,e.children&&$.each(e.children,function(){t=this,t.fullname_en=e.fullname_en.concat(t.name_en),t.fullname_cn=e.fullname_cn.concat(t.name_cn),a[""+t.id]=t,t.children&&$.each(t.children,function(){n=this,n.fullname_en=t.fullname_en.concat(n.name_en),n.fullname_cn=t.fullname_cn.concat(n.name_cn),o[""+n.id]=n})})})}();var s={init:function(){},getGameId:function(){return u.gameId},getGameNameEn:function(){return u.gameNameEn},getGameNameCn:function(){return u.gameNameCn},getTraceMaxTimes:function(){return Number(u.traceMaxTimes)},getCurrentLastTime:function(){return u.currentNumberTime},getCurrentTime:function(){return u.currentTime},getCurrentGameNumber:function(){return u.currentNumber},getLastGameNumber:function(){var e=u.issueHistory.last_number.issue,t=u.issueHistory.issues[0].issue;return t>e&&(e=t),e},getLotteryBalls:function(){var e=u.issueHistory.last_number.wn_number,t=u.issueHistory.last_number.issue,n=u.issueHistory.issues[0].issue;return n>t&&(e=u.issueHistory.issues[0].wn_number),e||""},getLotteryNumbers:function(){return u.issueHistory.issues||[]},getFormatLotteryNumbers:function(e,t){var n=this,r={};return t=t?t:n.getLotteryNumbers(),e=e||"hour",$.each(t,function(t,u){var i=n.getKeyByDateStr(""+u.offical_time,e);i&&(r[i]||(r[i]=[]),r[i].push(u))}),r},getKeyByDateStr:function(e,t){e=e||"0",t=t||"hour";var n=new Date;if(n.setTime(1e3*parseInt(e)),"[object Date]"===Object.prototype.toString.call(n)){if(isNaN(n.getTime()))return"";var r=n.getMonth()+1,u=n.getDate(),i=n.getHours(),a=n.getMinutes();return 10>r&&(r="0"+r),10>u&&(u="0"+u),10>i&&(i="0"+i),10>a&&(a="0"+a),"month"==t?r+"月":"day"==t?r+"月"+u+"日":"minute"==t?i+":"+a:i+":00"}return""},getGameNumbers:function(){return u.gameNumbers},getLimitByMethodId:function(e,t){var t=t||1,n=Number(this.getPrizeById(e).max_multiple);return n/t},getSubmitUrl:function(){return u.submitUrl},getUpdateUrl:function(){return u.loaddataUrl},getUploadPath:function(){return u.uploadPath},getJsPath:function(){return u.jsPath},getDefaultMethodId:function(){return u.defaultMethodId},getUserName:function(){return u.username},getDelayTime:function(){return 5},getLastGameBallsUrl:function(){return u.lastGameBallsUrl},getMethods:function(){return u.wayGroups},getMethodById:function(e){return o[""+e]},getPrizeById:function(e){return u.prizeSettings[""+e]},getMethodNodeById:function(e){return a[""+e]},getMethodNameById:function(e){var t=this.getMethodById(e);return t?t.name_en:""},getMethodCnNameById:function(e){var t=this.getMethodById(e);return t?t.name_cn:""},getMethodFullNameById:function(e){var t=this.getMethodById(e);return t?t.fullname_en:""},getMethodCnFullNameById:function(e){var t=this.getMethodById(e);return t?t.fullname_cn:""},getOnePriceById:function(e){return this.getMethodById(e).price},getToken:function(){return u._token},updateConfig:function(e){$.extend(!0,u,e)},getOptionalPrizes:function(){return u.optionalPrizes},setOptionalPrizes:function(){return $("#J-bonus-select-value").val()},getDefaultCoefficient:function(){return u.defaultCoefficient?u.defaultCoefficient:"1"},getDefaultMultiple:function(){return u.defaultMultiple?u.defaultMultiple:"1"},getLoadIssueUrl:function(){return u.loadIssueUrl},getMaxPrizeGroup:function(){return u.maxPrizeGroup}},c=e.Class(s,n);c.defConfig=i,c.getInstance=function(e){return r||(r=new c(e))},e.Games.SSC[t]=c}(dsgame,"Config",dsgame.Event);