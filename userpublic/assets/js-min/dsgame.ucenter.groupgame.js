!function(t){var e={},a={},i={},n=t("#J-user-type-switch-panel").find("a");n.click(function(e){var a=n.index(this),i=t.trim(t(this).attr("data-userTypeId"));e.preventDefault(),n.removeClass("current"),n.eq(a).addClass("current"),t("#J-input-userType").val(i),s(i)});var u=new dsgame.Tab({par:"#J-panel-cont",triggers:".tab-title > li",panels:".tab-panels > li",eventType:"click"});u.addEvent("afterSwitch",function(e,a){t("#J-input-group-type").val(a+1)}),t("#J-panel-group").on("click",".button-selectGroup",function(){var e=t(this),a=t.trim(e.attr("data-groupid"));t("#J-input-groupid").val(a),t("#J-panel-group").find("li").removeClass("current"),t("#J-panel-group").find('input[type="button"]').val("选 择"),e.parent().addClass("current"),e.val("已选择")}),t("#J-group-gametype-panel").on("click",".item-game",function(e){var a=t(this),i=t.trim(a.attr("data-itemtype")),n=t.trim(a.attr("data-id"));l(i,n),t("#J-group-gametype-panel").find("li").removeClass("current"),a.parent().addClass("current"),e.preventDefault()});var l=function(e,a){var i,n,u=t("#J-input-custom-type"),l=t("#J-input-custom-id"),s=[];"all"==e?(i=o(a),u.val("1")):(i=m(a),u.val("2")),l.val(i.id),n=i.info,p.reSet({minBound:n.min,maxBound:n.max,step:n.step,value:n.bonus}),s=r(n.proxyBonus,n.bonus,n.minMethodBonus,n.maxMethodBonus),t("#J-custom-feedback-value").text(s[0]+"% - "+s[1]+"%")},r=function(t,e,a,i){var n=[];return n.push(((t-e)/i).toFixed(2)),n.push(((t-e)/a).toFixed(2)),n},s=function(n){t.ajax({url:t.trim(t("#J-loadGroupData-url").val())+"?usertype="+n,cache:!1,dataType:"json",success:function(n){if(1==Number(n.isSuccess)){var u=n.data.defaultGroup,r=t("#J-template-group").html(),s=[];t.each(u,function(t){e[""+this.id]=this,this.feedback=100*this.feedback,s[t]=dsgame.util.template(r,this)}),t("#J-panel-group").html(s.join(""));var d=n.data.gameTypes,o=t("#J-template-gametype").html(),m=t("#J-template-gamesitem").html(),p=[],c=[],f=[];t.each(d,function(e){a[""+this.id]=this,p=this.games,c=['<li class="item-all"><a class="item-game" href="#" data-id="'+this.id+'" data-itemType="all"><span class="name">全部'+this.name+"</span></a></li>"],t.each(p,function(){c.push(dsgame.util.template(m,this)),i[""+this.id]=this}),f[e]=dsgame.util.template(o,{listloop:c.join("")})}),t("#J-group-gametype-panel").html(f.join("")),1==n.data.defaultGameType?(l("all",n.data.defaultGameId),t("#J-group-gametype-panel").find('a[data-id="'+n.data.defaultGameId+'"]').filter('[data-itemType="all"]').parent().addClass("current")):(l("",n.data.defaultGameId),t("#J-group-gametype-panel").find('a[data-id="'+n.data.defaultGameId+'"]').filter('[data-itemType!="all"]').parent().addClass("current"))}else alert("加载奖金组信息失败")},eoror:function(){}})},d=function(){var e=t("#J-user-type-switch-panel").find(".current"),a=t.trim(e.attr("data-userTypeId"));s(a)},o=function(t){return a[t]},m=function(t){return i[t]},p=new dsgame.SliderBar({minDom:"#J-slider-minDom",maxDom:"#J-slider-maxDom",contDom:"#J-slider-cont",handleDom:"#J-slider-handle",innerDom:"#J-slider-innerbg",minNumDom:"#J-slider-num-min",maxNumDom:"#J-slider-num-max",isUpOnly:!0});p.addEvent("change",function(){var e,a,i=this,n=t("#J-input-custom-type"),u=t("#J-input-custom-id"),e=[];t("#J-input-custom-bonus-value").val(i.getValue()),a="1"==t.trim(n.val())?o(t.trim(u.val())):m(t.trim(u.val())),a&&(e=r(a.info.proxyBonus,i.getValue(),a.info.minMethodBonus,a.info.maxMethodBonus),t("#J-custom-feedback-value").text(e[0]+"% - "+e[1]+"%"))}),t("#J-input-custom-bonus-value").blur(function(){var e=t.trim(this.value),a=1,i=50;e=e.replace(/[^\d]/g,""),e=Number(e),a=Math.ceil(e/i),e=a*i,this.value=e,p.setValue(e)}).keyup(function(){this.value=this.value.replace(/[^\d]/g,"")}),d()}(jQuery);