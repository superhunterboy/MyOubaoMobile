$(function(){var e=$("#J-panel-control"),a=($("#J-periods-data"),$("#J-time-periods")),t=($("#report-download"),$("#J-button-showcontrol")),s=$("#J-chart-table"),r=$("#J-chart-content");t.click(function(a){var s=t.parent().find("i"),r="arrow-down",n="arrow-up";e.toggle(),s.hasClass(r)?(s.removeClass(r).addClass(n),t.text("展开")):(s.removeClass(n).addClass(r),t.text("收起")),a.preventDefault()}),e.on("click","[data-action]",function(e){var a=$(e.target),t=a.attr("data-action"),n="";switch(t){case"temperature":n="table-temperature",s.hasClass(n)?s.removeClass(n):s.addClass(n);break;case"lost-post":n="table-lost-post",s.hasClass(n)?s.removeClass(n):s.addClass(n);break;case"guides":n="table-guides",r.hasClass(n)?r.removeClass(n):r.addClass(n);break;case"lost":n="table-lost",s.hasClass(n)?s.removeClass(n):s.addClass(n);break;case"trend":n="table-trend",$("body").hasClass(n)?$("body").removeClass(n):$("body").addClass(n)}}),$("#J-select-content").on("click","[data-action]",function(e){var a=$(e.target),t=a.attr("data-action");switch(t){case"addSelect":CHART.addSelectRow();break;case"delSelectRow":CHART.delSelectRow(a.parent().parent());break;case"selectBall":a.hasClass("ball-orange")?a.removeClass("ball-orange"):a.addClass("ball-orange")}}),a.click(function(){CHART.show()}),$("#J-date-star").focus(function(){var e=new dsgame.DatePicker({startYear:(new Date).getFullYear(),input:this,isShowTime:!0});e.show()}),$("#J-date-end").focus(function(){var e=new dsgame.DatePicker({startYear:(new Date).getFullYear(),input:this,isShowTime:!0});e.show()}),CHART&&CHART.sysConfig&&$("#J-periods-data").find("a").click(function(e){var a=$(this),t=$.trim(a.attr("data-type")),s=$.trim(a.attr("data-value")),r=CHART.sysConfig;switch(t){case"count":CHART.getDataUrl=function(){var e,a={lottery_id:r.lotteryId,num_type:r.wayId,count:s},t=[r.queryBaseUrl+"?"];for(e in a)a.hasOwnProperty(e)&&t.push(e+"="+a[e]);return t.join("&")};break;case"today":CHART.getDataUrl=function(){var e,a,t,s,n,o=new Date(Date.parse(r.nowTime.replace(/-/g,"/")));o.setHours(0),o.setMinutes(0),o.setMinutes(1),e=Date.parse(o)/1e3,o.setHours(23),o.setMinutes(59),o.setMinutes(59),a=Date.parse(o)/1e3,n={lottery_id:r.lotteryId,num_type:r.wayId,begin_time:e,end_time:a},t=[r.queryBaseUrl+"?"];for(s in n)n.hasOwnProperty(s)&&t.push(s+"="+n[s]);return t.join("&")};break;case"day":CHART.getDataUrl=function(){var e,a,t,n,o,l=new Date(Date.parse(r.nowTime.replace(/-/g,"/")));a=Date.parse(l)/1e3,l.setDate(l.getDate()-Number(s)),e=Date.parse(l)/1e3,o={lottery_id:r.lotteryId,num_type:r.wayId,begin_time:e,end_time:a},t=[r.queryBaseUrl+"?"];for(n in o)o.hasOwnProperty(n)&&t.push(n+"="+o[n]);return t.join("&")}}CHART.show(),a.parent().find("a").removeClass("current"),a.addClass("current"),e.preventDefault()})});