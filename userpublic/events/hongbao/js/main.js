function tempRender(temp, data){
	if( data ){
		$.each(data, function(key,value){
			var reg = new RegExp('#' + key + '#', 'ig');
			temp = temp.replace( reg, value);
		});
	}
	return temp;
}
function formatMoney(num){
	var num = Number(num),
	re = /(-?\d+)(\d{3})/;
	if (Number.prototype.toFixed) {
		num = (num).toFixed(2)
	} else {
		num = Math.round(num * 100) / 100
	}
	num = '' + num;
	while (re.test(num)) {
		num = num.replace(re, "$1,$2")
	}
	return num
}
function createRecords(data){
	var html = '',
		num = count = 0;
	$.each(data, function(i,n){
		html += '<tr>';
		html += '<td>' + n['date'] + '</td>';
		html += '<td>' + n['tasktime'] + '</td>';
		html += '<td>' + formatMoney(n['recharge']) + '</td>';
		html += '<td>' + formatMoney(n['bet']) + '</td>';
		html += '<td>' + formatMoney(n['hongbao']) + '</td>';
		html += '</tr>';
		num++;
		count += n['hongbao'] * 100000;
	});
	if( !html || !num ){
		html = '<tr><td colspan="6" style="text-align:center;line-height:60px;">呦～大爷，您第一次来啊！赶快去开启今日任务吧，以免红包与您擦肩而过哦～</td></tr>'
	}
	$('#J-table').html(html);
	$('#J-times').html(num);
	$('#J-hongbao').html( formatMoney(count/100000) );
}

function countdown(start, end){
	end = new Date(end);
	start = new Date(start);
	var t = end - start;
	if( t > 0 ){
		t = t / 1000;
		h = Math.floor( t / (60 * 60) );
		m = Math.floor( t % ( 60 * 60 ) / 60 );
		s = t % 60;
		return [h,m,s];
	}else{
		return [];
	}
}

$(function(){

	var number_step = function(now, tween){
		$(tween.elem).text(formatMoney(now));
	};
	$('.J-prize').animateNumber({
		number: poolMoney,
		numberStep: number_step
	}, 2000);

	var $template = $('#J-temp-cont'),
		$taskOpen = $('.check-record a');

	// 活动已结束
	if( eventIsEnd ){
		$template.html( tempRender($('.J-temp-step4').html()) );
		$taskOpen.text('活动已结束').prop('data-action', '').addClass('disabled');
	}
	// 今日任务未开启
	else if( !taskIsOpen ){
		$template.html( tempRender($('.J-temp-step1').html()) );
	}
	// 今日充值额为0
	else if( rechargeMoney <= 0 ){
		$template.html( tempRender($('.J-temp-step2').html()) );
		$taskOpen.text('已开启今日活动').prop('data-action', '').addClass('disabled');
	}
	else{
		$taskOpen.text('已开启今日活动').prop('data-action', '').addClass('disabled');
		var amount = betMoney || 0
			multiple = Math.floor( amount / rechargeMoney ),
			width = multiple / 48,
			need = 0,
			get = 0,
			isMax = false;
		width = width > 1 ? '100%' : (width * 100) + '%';
		$.each(multipleBack, function(i,n){
			if( multiple < parseInt(i) ){
				need = rechargeMoney * ( i - multiple );
				get = n * rechargeMoney;
				return isMax = false;
			}
		});
		var data = {
			rechargeMoney: formatMoney(rechargeMoney),
			amount: formatMoney(amount),
			multiple: multiple,
			need: formatMoney(need),
			get : formatMoney(get)
		};
		$template.html( tempRender( $('.J-temp-step3').html(), data ) );

		$template.find('#J-progress-bar').animate({
			width: width
		}, 1200);
		
		if( multiple >= 48 ){
			$template.find('.J-task-finished').show();
		}else{
			$template.find('.J-task-goon').show();
		}
	}

	// 生成红包记录
	createRecords(eventRecords || {});

	var $overlay = $('.overlay').fadeOut(0),
		$dialogs = $('.dialog').fadeOut(0),
		$record = $('#record'),
		$eventBoard = $('#event-board');

	// 显示活动参与记录
	$('body').on('click', '[data-dialog="record"]', function(e){
		e.preventDefault();
		$overlay.fadeIn();
		$record.fadeIn();
	});

	// 关闭弹窗
	$dialogs.find('[data-action="close"]').on('click', function(e){
		e.preventDefault();
		$overlay.fadeOut();
		$(this).parents('.dialog:eq(0)').fadeOut();
	});

	// 今日活动事件绑定
	// 开启今日任务
	$template.on('click', '[data-action="task-open"]', function(e){
		e.preventDefault();
		var cd = countdown(currentTime, eventStart);
		if( cd.length ){
			return alert('活动暂未开启，开启时间2015年6月8日0时');
		}
		openTask();
	});
	$('.check-record').on('click', '[data-action="task-open"]', function(e){
		e.preventDefault();
		var cd = countdown(currentTime, eventStart);
		if( cd.length ){
			return alert('活动暂未开启，开启时间2015年6月8日0时');
		}
		openTask();
	});

	var openTask = function(){
		$.ajax({
			type: 'GET',
			url:  signUrl,
			success: function(resp){
				// resp = $.parseJSON(resp);
				if( resp.msgType == 'error' ){
					alert(resp.msg);
				}else{
					$overlay.fadeIn();
					$eventBoard.fadeIn();
					$taskOpen.text('已开启今日活动').prop('data-action', '').addClass('disabled');
					$template.html( tempRender($('.J-temp-step2').html()) );
				}
			}
		});
		// $overlay.fadeIn();
		// $eventBoard.fadeIn();
		// $taskOpen.text('已开启今日活动').prop('data-action', '').addClass('disabled');
		// $template.html( tempRender($('.J-temp-step2').html()) );
	}

});