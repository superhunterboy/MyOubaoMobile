function ws_cube(e,t,o){function n(e,t,o,n){return"inset "+-n*e*1.2/90+"px "+o*t*1.2/90+"px "+(e+t)/20+"px rgba("+(n>o?"0,0,0,.6":o>n?"255,255,255,0.8":"0,0,0,.0")+")"}var r=jQuery,s=r("ul",o),i=e.perspective||2e3;fullContCSS={position:"absolute",backgroundSize:"cover",left:0,top:0,width:"100%",height:"100%",backfaceVisibility:"hidden"};var a={domPrefixes:" Webkit Moz ms O Khtml".split(" "),testDom:function(e){for(var t=this.domPrefixes.length;t--;)if("undefined"!=typeof document.body.style[this.domPrefixes[t]+e])return!0;return!1},cssTransitions:function(){return this.testDom("Transition")},cssTransforms3d:function(){var e="undefined"!=typeof document.body.style.perspectiveProperty||this.testDom("Perspective");if(e&&/AppleWebKit/.test(navigator.userAgent)){var t=document.createElement("div"),o=document.createElement("style"),n="Test3d"+Math.round(99999*Math.random());o.textContent="@media (-webkit-transform-3d){#"+n+"{height:3px}}",document.getElementsByTagName("head")[0].appendChild(o),t.id=n,document.body.appendChild(t),e=3===t.offsetHeight,o.parentNode.removeChild(o),t.parentNode.removeChild(t)}return e},webkit:function(){return/AppleWebKit/.test(navigator.userAgent)&&!/Chrome/.test(navigator.userAgent)}},d=a.cssTransitions()&&a.cssTransforms3d(),c=a.webkit();if(!d&&e.fallback)return new e.fallback(e,t,o);var u;this.go=function(a,l){function p(t,o,s,a,d,u,l,p,h){t.parent().css("perspective",i);var f=t.width(),g=t.height(),m=r(t.children().get(1));m.css({transform:"rotateY(0deg) rotateX(0deg)",boxShadow:n(f,g,0,0)});var v=r(t.children().get(0));v.css({opacity:1,transform:"rotateY("+u+"deg) rotateX("+d+"deg)",boxShadow:n(f,g,d,u)}),c&&t.css({transform:"translateZ(-"+o+"px)"});var b=setTimeout(function(){var t="all "+e.duration+"ms cubic-bezier(0.645, 0.045, 0.355, 1.000)";m.css({transition:t,boxShadow:n(f,g,l,p),transform:"rotateX("+l+"deg) rotateY("+p+"deg)"}),v.css({transition:t,boxShadow:n(f,g,0,0),transform:"rotateY(0deg) rotateX(0deg)"}),b=setTimeout(h,e.duration)},20);return{stop:function(){clearTimeout(b),h()}}}if(d){u&&u.stop();var h=o.width(),f=o.height(),g=r('<div class="ws_effect">').css(fullContCSS).css({transformStyle:"preserve-3d",perspective:c?"none":i,zIndex:8}).appendTo(o.parent()),m={left:[h/2,h/2,0,0,90,0,-90],right:[h/2,-h/2,0,0,-90,0,90],down:[f/2,0,-f/2,90,0,-90,0],up:[f/2,0,f/2,-90,0,90,0]}[e.direction||["left","right","down","up"][Math.floor(4*Math.random())]];r("<div>").css(fullContCSS).appendTo(g).css({backgroundImage:"url("+t.get(a).src+")",transformOrigin:"50% 50% -"+m[0]+"px"}),r("<div>").css(fullContCSS).appendTo(g).css({backgroundImage:"url("+t.get(l).src+")",transformOrigin:"50% 50% -"+m[0]+"px"}),s.hide(),u=new p(g,m[0],m[1],m[2],m[3],m[4],m[5],m[6],function(){s.css({left:-a+"00%"}).show(),g.remove(),u=0})}else{var v=r("<div></div>").css({position:"absolute",display:"none",zIndex:2,width:"100%",height:"100%"}).appendTo(o);v.stop(1,1);var b=!!((a-l+1)%t.length)^e.revers?"left":"right",w=r(t[l]).clone().css({position:"absolute",left:"0%",right:"auto",top:0,width:"100%",height:"100%"}).appendTo(v).css(b,0),x=r(t[a]).clone().css({position:"absolute",left:"100%",right:"auto",top:0,width:"0%",height:"100%"}).appendTo(v).show();v.css({left:"auto",right:"auto",top:0}).css(b,0).show(),s.hide(),x.animate({width:"100%",left:0},e.duration,"easeInOutExpo",function(){r(this).remove()}),w.animate({width:0},e.duration,"easeInOutExpo",function(){s.css({left:-a+"00%"}).show(),v.remove()})}return a}}jQuery("#wowslider-container").wowSlider({effect:"cube",prev:"",next:"",duration:2e3,delay:2e3,width:695,height:345,autoPlay:!0,playPause:!0,stopOnHover:!1,loop:!1,bullets:!0,caption:!0,captionEffect:"slide",controls:!0,onBeforeStep:0,images:0});