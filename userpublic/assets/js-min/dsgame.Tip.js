!function(t,e,i,n,s){var o,f={cls:"j-ui-tip-l",target:"body",text:"",effectShow:function(){this.dom.show()},effectHide:function(){this.dom.hide()}},c="j-ui-tip",a=500,d={init:function(t){var e=this;e.dom=n('<div class="'+c+" "+t.cls+'" style="display:none;position:absolute;left:0;top:0;z-index:'+a++ +';"><i class="sj sj-t"></i><i class="sj sj-r"></i><i class="sj sj-b"></i><i class="sj sj-l"></i><span class="ui-tip-text">'+t.text+"</span></div>").appendTo(n("body")),e.effectShow=t.effectShow,e.effectHide=t.effectHide},getTextContainer:function(){var t=this;return t._textContainer||(t._textContainer=t.dom.find(".ui-tip-text"))},getDom:function(){return this.dom},setText:function(t){var e=this;e.getTextContainer().html(t)},show:function(t,e,i){var o=this,f=n(i==s?o.defConfig.target:i).offset();o.dom.css({left:f.left+t,top:f.top+e}),o.effectShow()},hide:function(){this.effectHide()},remove:function(){this.getDom().remove()}},u=t.Class(d,i);u.defConfig=f,t[e]=u,t[e].getInstance=function(){return o||(o=new t[e]({cls:"j-ui-tip-l j-ui-tip-info"}))}}(dsgame,"Tip",dsgame.Event,jQuery);