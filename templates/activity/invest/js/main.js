$(function(){
	var dateInit = new Date(Date.parse('Wed May 13 2015 00:00:59') ),
		now = new Date(),
		maxDays = 30,
		day = maxDays;
	var time = now - dateInit;
	if( time < 0 ){
		day = maxDays;
	}else{
		day = maxDays - Math.floor( time / ( 24 * 60 * 60 * 1000 ) );
	}
	$('#J-time-remain').text(day);
});
//计算器
(function($){
	var data = [
		{'name':'ssc', 'cnname':'时时彩', 'list':[1950, 1940, 1930, 1920, 1800]},
		{'name':'l115', 'cnname':'11选5', 'list':[1890, 1880, 1870, 1860, 1782]}
	];
	var getDataByName = function(name){
		var i = 0,len = data.length;
		for(;i < len;i++){
			if(data[i]['name'] == name){
				return data[i];
			}
		}
	};
	var formatMoney = function(num) {
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
    };
	var gametype = $('#J-select-gametype'),group = $('#J-select-group'),
		textTip1 = $('#J-text-mkg'),textTip2 = $('#J-text-other');
	var sale = $('#J-num-sale'),
		profit = $('#J-num-profit'),
		point = $('#J-num-point'),
		lost = $('#J-num-lost'),
		button = $('#J-button-calc');
	var getCalculate = function(){
		//每月销售总额X最小点差+每月输额X分红比例
		var numSale = Number(sale.val()),
			numProfit = Number(profit.val())/100,
			numPoint = Number(point.val())/100,
			numLost = Number(lost.val()),
			other = (numSale * numPoint) + (numLost * numProfit),
			bound = [[100, 200, 0.3103], [200, 400, 0.3112], [400, 600, 0.3131], [600, 800, 0.3141], [800, 1000, 0.3172], [1000, 1200, 0.3213], [1200, 1400, 0.3223], [1400, 1600, 0.3232], [1600, 1800, 0.3241], [1800, 2000, 0.3253], [2000, 4000, 0.3272], [4000, 6000, 0.3282], [6000, 8000, 0.3293], [8000, 10000, 0.3312], [10000, 99999, 0.3320]],
			len = bound.length,
			i = 0,
			add = 0;
		for(;i < len;i++){
			if(numSale >= bound[i][0] && numSale <  bound[i][1]){
				add = bound[i][2];
				break;
			}
		}
		var mkg = other * (1 + add);
		return {'mkg':Number(mkg).toFixed(2), 'other':Number(other).toFixed(2)};
	};
	var maskMkg = $('#J-mask-mkg'),
		maskOther = $('#J-mask-other'),
		timer1,
		timer2,
		moneyMkg = $('#J-money-mkg'),
		moneyOther = $('#J-money-other'),
		less = $('#J-less-num'),
		isRunning = false;
	// var number_step = $.animateNumber.numberStepFactories.separator(',');
	var number_step = function(now, tween){
		$(tween.elem).text(formatMoney(now));
	};
	var showView = function(numMkg, numOther){
		//89%~90%
		var blMkg = parseInt(Math.random()*(100-99+1) + 99)/100,
			top = numMkg/blMkg,
			blOther = numOther/top;
		clearTimeout(timer1);
		clearTimeout(timer2);		
		moneyMkg.animateNumber({
			number: numMkg * 10000,
			numberStep: number_step
		},2500);
		moneyOther.animateNumber({
			number: numOther * 10000,
			numberStep: number_step
		},1500);
		less.animateNumber({
			number: (numMkg - numOther) * 10000,
			numberStep: number_step
		},2500);
		maskMkg.stop(true).css('width', '40%').animate({'width':blOther*100 + '%'}, 1000).delay(500).animate({'width':(blMkg)*100 + '%'}, 1000).delay(500);
		maskOther.stop(true).css('width', '40%').animate({'width':blOther*100 + '%'}, 1000);
		timer1 = setTimeout(function(){
			isRunning = true;
			maskMkg.addClass('blink');
			timer2 = setTimeout(function(){
				maskMkg.removeClass('blink');
				isRunning = false;
			}, 600);
		}, 3000);
	};
	button.on('click', function(e){
		var result = getCalculate();
		e.preventDefault();
		if(isRunning){
			return false;
		}
		if(Number(sale.val()) < Number(lost.val())){
			alert('每月输额不能大于每月销售额');
			lost.focus();
			return false;
		}
		showView(result['mkg'], result['other']);
	}).trigger('click');

	//选择彩种
	var $selectType = $('#J-select-gametype');
	var $selectGroup = $('#J-select-group');
	$selectType.on('change', function(e){
		var value = this.value;
		var dt = getDataByName($.trim(value)),
			i = 0,
			len = dt['list'].length,
			cnname = '[' + dt['cnname'] + ']',
			numValue = '',
			html = [];
		for(;i < len;i++){
			var v = dt['list'][i];
			if( i == 0 ){
				html.push('<option checked value="' + v + '">' + v + '</option>');
			}else{
				html.push('<option value="' + v + '">' + v + '</option>')
			}
		}
		$selectGroup.html(html.join(''));
		numValue = group.val();
		textTip1.find('.gametype').text(cnname);
		textTip2.find('.gametype').text(cnname);
		textTip1.find('.num').text(dt['name'] == 'ssc' ? 1954 : 1920);
		textTip2.find('.num').text(numValue);
	}).trigger('change');
	$selectGroup.on('change', function(e){
		var numValue = this.value;
		// textTip1.find('.num').text(numValue);
		textTip2.find('.num').text(numValue);
	}).trigger('change');

	sale.keyup(function(){
		var num = Number(this.value.replace(/[^\d]/g, ''));
		this.value = num;
	});
	sale.blur(function(){
		var num = Number(this.value);
		num = num < 100 ? 100 : num;
		num = num > 10000 ? 10000 : num;
		this.value = num;
	});
	profit.keyup(function(){
		var float = this.value.replace(/[^\d|^\.]/g, '');
		if(isNaN(Number(float))){
			this.value = 0;
		}else{
			this.value = float;
		}
	});
	point.keyup(function(){
		var float = this.value.replace(/[^\d|^\.]/g, '');
		if(isNaN(Number(float))){
			this.value = 0;
		}else{
			this.value = float;
		}
	});
	lost.keyup(function(){
		this.value = Number(this.value.replace(/[^\d]/g, ''));
	});


})(jQuery);

// 预约收益
(function($){
	var $dialog = $('#subscribe').animate({opacity:0}),
		$overlay = $('.overlay').hide(0);
	function showDialog(){
		$overlay.show();
		$dialog.css({display:'block'}).animate({opacity:1});
	}
	function hideDialog(){
		$overlay.hide();
		$dialog.animate({opacity:0}, function(){
			$(this).css('display', 'none');
		});
	}
	$('[data-action="subscribe"]').on('click', function(){
		showDialog();
		return false;
	});
	$('[data-action="close"]').on('click', function(){
		hideDialog();
		return false;
	});
})(jQuery);