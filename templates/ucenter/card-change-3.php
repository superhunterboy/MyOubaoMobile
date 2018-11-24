<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>确认新银行卡信息 -- 增加绑定 -- CC彩票</title>
<link type="text/css" rel="stylesheet" href="../images/global/global.css" />
<link type="text/css" rel="stylesheet" href="../images/ucenter/ucenter.css" />

<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/dsgame.base.js"></script>
<script type="text/javascript" src="../js/dsgame.Select.js"></script>
<script type="text/javascript" src="../js/dsgame.Tip.js"></script>

</head>

<body>

<?php include_once("../header.php"); ?>


<div class="g_33 main clearfix">
	<div class="main-sider">
		
		<?php include_once("../uc-sider.php"); ?>
		
	</div>
	<div class="main-content">
		
		<div class="nav-bg">
			<div class="title-normal">
				修改银行卡
			</div>
		</div>
		
		<div class="content">
		
		
			<div class="step">
				<table class="step-table">
					<tbody>
						<tr>
							<td class="clicked"><div class="con"><i>1</i>验证老银行卡</div></td>
							<td class="clicked"><div class="tri"><div class="con"><i>2</i>输入新银行卡信息</div></div></td>
							<td class="current"><div class="tri"><div class="con"><i>3</i>确认银行卡信息</div></div></td>
							<td><div class="tri"><div class="con"><i>4</i>绑定结果</div></div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<form action="card-change-4.php">
			<table width="100%" class="table-field">
				<tr>
					<td align="right">开户银行：</td>
					<td>中国农业银行</td>
				</tr>
				<tr>
					<td align="right">开户银行区域：</td>
					<td>广西&nbsp;&nbsp;北海</td>
				</tr>
				<tr>
					<td align="right">支行名称：</td>
					<td>中华街支行</td>
				</tr>
				<tr>
					<td align="right">开户人姓名：</td>
					<td>张麻子</td>
				</tr>
				<tr>
					<td align="right">银行账号：</td>
					<td>6225758303225555</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td>
						<input type="submit" value="确认提交" class="btn" id="J-submit">
						<input type="button" value="返回上一步" class="btn btn-normal" id="J-button-back">
					</td>
				</tr>
			</table>
			</form>
		
		
		</div>
	</div>
</div>

<?php include_once("../footer.php"); ?>


<script>
	(function($){
		
		$('#J-button-back').click(function(){
			history.back(-1);
		});
			
	})(jQuery);
</script>

</body>
</html>
