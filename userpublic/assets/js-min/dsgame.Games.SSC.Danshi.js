!function(t,e,a){var i={name:"wuxing.zhixuan.danshi",editorobj:".content-text-balls",uploadButton:"#file",exampleText:"12345 33456 87898 <br />12345 33456 87898 <br />12345 33456 87898 ",tips:"五星直选单式玩法提示",exampleTip:"这是单式弹出层提示",checkFont:/[\u4E00-\u9FA5]|[/\n]|[/W]/g,filtration:/[\s]|[,]|[;]|[<br>]|[，]|[；]/i,checkNum:/^[0-9]*$/,normalTips:["说明：","1、每一注号码之间的间隔符支持 回车  空格[ ]    逗号[,]   分号[;]","2、文件格式必须是.txt格式,大小不超过200KB。","3、将文件拖入文本框即可快速实现文件上传,大文件拖拽上传效果更佳。","4、导入文本内容后将覆盖文本框中现有的内容。","5、一次投注支持100,000注！"].join("\n")},n="SSC",r=t.Games,o=t.Games[n],s={init:function(){var t=this;t.ieRange="",t.vData=[],t.aData=[],t.tData=[],t.errorData=[],t.sameData=[],t.firstfocus=!0,t.ranNumTag=!1,t.isFirstAdd=!0,r.getCurrentGameOrder().addEvent("beforeAdd",function(e,a){t.tData;a.type==t.defConfig.name&&(t.isFirstAdd?t.ranNumTag||(a.lotterys=[],t.isFirstAdd=null,t.updateData(),r.getCurrentGameOrder().add(r.getCurrentGameStatistics().getResultData())):((""!=t.errorData.join("")||""!=t.sameData.join(""))&&t.ballsErrorTip(),t.isFirstAdd=!0))})},initTextarea:function(){var t=this,e="content-textarea-balls-def",a=t.defConfig,i=$.trim(a.normalTips);t.importTextarea=$('<textarea class="content-textarea-balls '+e+'">'+i+"</textarea>"),t.container.find(".panel-select").html("").append(t.importTextarea),t.importTextarea.focus(function(){var a=$.trim(this.value);a==i&&(this.value="",t.importTextarea.removeClass(e))}).blur(function(){var e=$.trim(this.value);""==e&&(t.removeOrderAll(),t.showNormalTips())}).keyup(function(){t.updateData()})},initFrame:function(){var t=this;t.initTextarea(),t.bindPressTextarea(),t.dragUpload()},getExampleText:function(){return this.defConfig.exampleText},rebuildData:function(){var t=this;t.balls=[[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]]},buildUI:function(){var t=this;t.container.html(t.getHTML())},reSelect:function(){},batchSetBallDom:function(){},getNormalTips:function(){return this.defConfig.normalTips},showNormalTips:function(){var t=this,e="content-textarea-balls-def";t.importTextarea&&t.importTextarea.addClass(e),t.replaceText(t.getNormalTips.call(t))},_bulidEditDom:function(){var t=this,e="";t.doc.designMode="On",t.doc.contentEditable=!0,t.doc.open(),e='<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />',e+="<style>*{margin:0;padding:0;font-size:14px;}</style>",e+="</head>",t.doc.writeln("<html>"+e+'<body style="word-break: break-all">'+t.getNormalTips()+"</body></html>"),t.doc.close(),t.bindPress(),document.all&&(t.doc.onkeypress=function(){return t._ieEnter()}),t.dragUpload()},dragUpload:function(){var t=this,e=t.importTextarea;window.FileReader&&(e.bind("dragover",function(t){t.preventDefault(),t.stopPropagation()}),e.get(0).addEventListener("drop",function(e){e.preventDefault(),e.stopPropagation();var a=e.dataTransfer.files,i=a[0],n=new FileReader,r=i.type?i.type:"n/a";"text/plain"==r&&(n.onload=function(e){var a=e.target.result;""!=$.trim(a)&&(t.replaceText(a),t.updateData())},n.readAsText(i))},!1))},_ieEnter:function(){var t=this,e=t.win.event;return 13==e.keyCode?(this._saveRange(),this._insert("<br/>"),!1):void 0},_insert:function(t){var e=this;if(e.ieRange)e.ieRange.pasteHTML(t),e.ieRange.select(),e.ieRange=!1;else if(e.win.focus(),document.all)e.doc.body.innerHTML+=t;else{var a=win.getSelection(),i=a.getRangeAt(0),n=i.createContextualFragment(t);i.insertNode(n)}},_saveRange:function(){if(document.all&&!me.ieRange){var t=me.doc.selection;if(me.ieRange=t.createRange(),"Control"!=t.type){var e=me.ieRange.parentElement();("INPUT"==e.tagName||e==document.body)&&(me.ieRange=!1)}}},getHtml:function(){var t=this,e=t.importTextarea?t.importTextarea.val():"";return e},replaceText:function(t){var e=this;e.importTextarea&&e.importTextarea.val(t)},bindPressTextarea:function(){{var t=this,e=t.container.find(t.defConfig.uploadButton);window.navigator.userAgent.toLowerCase()}e.bind("change",function(){var e=$(this).parent();t.checkFile(this,e)})},bindPress:function(){var t=this,e=t.container.find(t.defConfig.uploadButton),a=window.navigator.userAgent.toLowerCase();$(t.doc).bind("input",function(){t.updateData()}),a.indexOf("msie")>0&&($(t.doc.body).bind("keyup",function(){t.updateData()}),$(t.doc.body).bind("blur",function(){t.updateData()})),$(t.doc).bind("focus",function(){t.firstfocus&&(t.replaceText(" "),t.firstfocus=!1)}),$(t.doc).bind("blur",function(){var e=t.getText();""==$.trim(e)?t.showNormalTips():t.updateData()}),$(t.doc.body).bind("focus",function(){t.firstfocus&&(t.replaceText(" "),t.firstfocus=!1)}),$(t.doc.body).bind("blur",function(){var e=t.getText();""==$.trim(e)?t.showNormalTips():t.updateData()}),e.bind("change",function(){var e=$(this).parent();t.checkFile(this,e)})},iterator:function(t){for(var e=this,a=e.defConfig,i=[],n=0,r=0;r<t.length;r++)a.filtration.test(t.charAt(r))&&(i.push(t.substr(n,r-n)),n=r+1);return i},checkResult:function(t,e){for(var a=e.length-1;a>=0;a--)if(e[a].join("")==t)return!1;return!0},filterLotters:function(t){var e=this,a="";return a=t.replace(/<br>+|&nbsp;+/gi," "),a=a.replace(/\s\s|[\s]|[,]+|[;]+|[，]+|[；]+/gi," "),a=a.replace(/<(?:"[^"]*"|'[^']*'|[^>'"]*)+>/g," "),a=a.replace(e.defConfig.checkFont,"")+" "},checkSingleNum:function(t){var e=this;return e.defConfig.checkNum.test(t)&&t.length==e.balls.length},checkBallIsComplete:function(t){var e=this;e.aData=[],e.vData=[],e.sameData=[],e.errorData=[],e.tData=[],result=[],result=e.iterator(e.filterLotters(t)).sort()||[];for(var a=result.length;a--;){if(e.checkSingleNum(result[a])){var i=result[a];i==result[a+1]?e.sameData.push(result[a].split("")):e.tData.push(result[a].split("")),e.vData.push(result[a].split(""))}else e.errorData.push(result[a].split(""));e.aData.push(result[a].split(""))}return e.tData.length>0?(e.isBallsComplete=!0,e.isFirstAdd?e.vData:e.tData):(e.isBallsComplete=!1,[])},countInstances:function(t,e){var a=[],i=0;do i=t.indexOf(e,i),-1!=i&&(a.push(i),i+=e.length);while(-1!=i);return a},removeOrderError:function(){var t=this,e=[],a=0,i=t.tData.length;for(a=0;i>a;a++)e[a]=t.tData[a].join("");e=$.trim(e.join(" ")),t.errorDataTips(),t.replaceText(e),t.errorData=[],t.sameData=[],""==e&&t.showNormalTips()},removeOrderSame:function(){var t=this,e=[],a=0,i=t.tData.length;for(a=0;i>a;a++)e[a]=t.tData[a].join("");e=$.trim(e.join(" ")),t.sameDataTips(),t.replaceText(e),t.errorData=[],t.sameData=[],""==e&&t.showNormalTips()},removeOrderAll:function(){var t=this;t.replaceText(" "),t.sameData=[],t.aData=[],t.tData=[],t.vData=[],r.getCurrentGameStatistics().reSet(),t.showNormalTips()},checkFile:function(t,e){var a=t.value,i=a.substring(a.lastIndexOf("."),a.length),i=i.toLowerCase();return".txt"!=i?(alert("对不起，导入数据格式必须是.txt格式文件哦，请您调整格式后重新上传，谢谢 ！"),!1):void e[0].submit()},getFile:function(t){var e=this,a=e.container.find(":reset");t&&(e.replaceText(t),e.firstfocus=!1,e.updateData(),a.click())},errorTip:function(){var t=this;alert(t.errorData.join())},sameDataTips:function(){var t=this,e=t.sameData,a="",i=r.getCurrentGameMessage(),n=[];if(""!=e.join("")){for(var o=0;o<e.length;o++)$.trim(e[o].join(""))&&n.push(e[o].join(""));a='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">'+n.join(", ")+"</p>",i.show({mask:!0,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+a+"</div>","</div>","</div>"].join(""),closeIsShow:!0,closeFun:function(){this.hide()}})}},errorDataTips:function(){var t=this,e=t.errorData,a="",i=r.getCurrentGameMessage(),n=[];if(""!=e.join("")){for(var o=0;o<e.length;o++)$.trim(e[o].join(""))&&n.push(e[o].join(""));a='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">'+n.join(", ")+"</p>",i.show({mask:!0,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+a+"</div>","</div>","</div>"].join(""),closeIsShow:!0,closeFun:function(){this.hide()}})}},ballsErrorTip:function(){var t=this,e=t.errorData,a=t.sameData,i="",n="",o=r.getCurrentGameMessage(),s=[],l=[];if(""!=a.join("")){for(var c=0;c<a.length;c++)$.trim(a[c].join(""))&&l.push(a[c].join(""));n='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码重复，已进行自动过滤</h4><p class="pop-text" style="display:block">'+l.join(", ")+"</p>"}if(""!=e.join("")){for(var c=0;c<e.length;c++)$.trim(e[c].join(""))&&s.push(e[c].join(""));i='<h4 class="pop-text" style="display:block;font-weight:bold">以下号码错误，已进行自动过滤</h4><p class="pop-text" style="display:block">'+s.join(", ")+"</p>"}o.show({mask:!0,content:['<div class="bd text-center">','<div class="pop-waring">','<i class="ico-waring <#=icon-class#>"></i>','<div style="display:inline-block;*zoom:1;*display:inline;vertical-align:middle">'+n+i+"</div>","</div>","</div>"].join(""),closeIsShow:!0,closeFun:function(){this.hide()}})},reSet:function(){var t=this;t.isBallsComplete=!1,t.rebuildData(),t.updateData(),t.ranNumTag||t.showNormalTips(),t.removeRanNumTag()},formatViewBalls:function(t){for(var e=[],a=t.length,i=0;a>i;i++)e[i]=t[i].join("");return e.join("|")},makePostParameter:function(t,e){for(var a=[],t=e.lotterys,i=t.length,n=0;i>n;n++)a[n]=t[n].join("");return a.join("|")},getLottery:function(){var t=this,e=t.getHtml();if(""!=e)return t.checkBallIsComplete(e)},removeSameNum:function(t){var e,a=0,i=this,n=this.getBallData()[0].length;for(len=t.length,e=Math.floor(Math.random()*n);a<t.length;a++)if(e==t[a])return arguments.callee.call(i,t);return e},emptySameData:function(){this.sameData=[]},emptyErrorData:function(){this.errorData=[]},addRanNumTag:function(){var t=this;t.ranNumTag=!0,t.emptySameData(),t.emptyErrorData()},getTdata:function(){return this.tData},getOriginal:function(){return this.getTdata()},removeRanNumTag:function(){this.ranNumTag=!1},checkRandomBets:function(t,e){var a=this,i="undefined"==typeof t?!0:!1,t=t||{},n=[],e=e||0,o=(a.getBallData().length,a.getBallData()[0].length,r.getCurrentGameOrder().getTotal().orders);if(n=a.createRandomNum(),Number(e)>Number(a.getRandomBetsNum()))return n;if(i)for(var s=0;s<o.length;s++)if(o[s].type==a.defConfig.name){var l=o[s].original.join("").replace(/,/g,"");t[l]=l}return t[n.join("")]?(e++,arguments.callee.call(a,t,e)):n},randomNum:function(){var t=this,e=[],a=null,i=(t.getBallData(),t.defConfig.name,r.getCurrentGame().getCurrentGameMethod().getGameMethodName()),n=[],o=[];return t.addRanNumTag(),e=t.checkRandomBets(),o=e,n=t.combination(o),a={type:i,original:o,lotterys:n,moneyUnit:r.getCurrentGameStatistics().getMoneyUnit(),multiple:r.getCurrentGameStatistics().getMultip(),onePrice:r.getCurrentGame().getGameConfig().getInstance().getOnePrice(i),num:n.length},a.amountText=r.getCurrentGameStatistics().formatMoney(a.num*a.moneyUnit*a.multiple*a.onePrice),a},getHTML:function(){var t=r.getCurrentGame().getGameConfig().getInstance().getUploadPath(),e=r.getCurrentGame().getGameConfig().getInstance().getToken(),a=[];return a.push('<div class="number-select-title balls-type-title clearfix"><div class="number-select-link"><a href="#" class="pick-rule">选号规则</a><a href="#" class="win-info">中奖说明</a></div></div>'),a.push('<div class="balls-import clearfix">'),a.push('<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="'+t+'" target="check_file_frame" style="position:relative;padding-bottom:10px;">'),a.push('<input name="betNumber" type="file" id="file" size="40" hidefocus="true" value="导入" style="outline:none;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:alpha(opacity=0);opacity: 0;position:absolute;top:0px; left:0px; width:115px; height:30px;z-index:1;background:#000;cursor: pointer;" />'),a.push('<input name="_token" type="hidden" value="'+e+'" />'),a.push('<input type="button" class="btn balls-import-input" style="cursor: pointer;" value="导入注单" onclick=document.getElementById("form1").file.click()>&nbsp;&nbsp;&nbsp;&nbsp;<a style="display:none;" class="balls-example-danshi-tip" href="#">查看标准格式样本</a>'),a.push('<input type="reset" style="outline:none;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:alpha(opacity=0);opacity: 0;width:0px; height:0px;z-index:1;background:#000" />'),a.push('<iframe src="'+t+'" name="check_file_frame" style="display:none;"></iframe>'),a.push("</form>"),a.push('<div class="panel-select"><iframe style="width:100%;height:100%;border:0 none;background-color:#F9F9F9;" class="content-text-balls"></iframe></div>'),a.push('<div class="panel-btn">'),a.push('<a class="btn remove-error" href="javascript:void(0);">删除错误项</a>'),a.push('<a class="btn remove-same" href="javascript:void(0);">删除重复项</a>'),a.push('<a class="btn remove-all" href="javascript:void(0);">清空文本框</a>'),a.push("</div>"),a.push("</div>"),a.join("")}},l=t.Class(s,a);l.defConfig=i,o[e]=l}(dsgame,"Danshi",dsgame.GameMethod);