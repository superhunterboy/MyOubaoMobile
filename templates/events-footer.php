<div id="footer" class="wrap">
	<div class="wrap-inner">
		<a class="logo left" href="{{route('home')}}">CC彩票</a>
		<div class="right ft-cont">
			<p>® CC彩票版权所有</p>
			<p>2015 Copyright © Genting Palace Interactive Network Technology Co., Ltd.</p>
		</div>
	</div>
</div>

<div class="call-center">
	<a data-call-center class="kf53">在线客服</a>
	<!--<a href="http://wpa.qq.com/msgrd?v=3&uin=316045809&site=qq&menu=yes" class="qqkf" target="_blank">QQ客服</a>-->
</div>
<script type="text/javascript">
$(function(){
	var url ="http://kefu.qycn.com/vclient/chat/?websiteid=121683";
	if(b){
		role = '&user_level=tester'
	}else if(a && !c){
		role = '&user_level=agent'
	}else if(a && c){
		role = '&user_level=topAgent'
	}else if(d){
		role = '&user_level=player'
	}else{
		role = '&user_level=login'
	};
	var name = "nicksb" ? "&user_name=nicksb" : '&user_name=Visitor';
	var callData = name+role;
	$('[data-call-center]').click(function(event) {
		window.open(url+callData,"","height=550,width=800,top=0,left=0,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no");
		return false;
	});
});
</script>
