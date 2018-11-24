//side menu function
$(function(){
	//菜单配置
	var defConfig = {
		isDefShow : false,
		demoBox : '#J-side-box',
		showDemo : '.side-box',
		trigger : '.li-name',
		sideDemo:'.side-li',
		activeCls : 'on',
	};
	var leftShow = false , openLeft = false ;
	var pros = {

	}
	//收起展开状态
	var togfun = function(){

		$(defConfig.trigger).click(function(event) {
			if(leftShow) return false;
			var liName = $(this).parent();
			 if(liName.hasClass(defConfig.activeCls)) {
			 	$(defConfig.trigger).parent().removeClass(defConfig.activeCls);
			 	$(defConfig.showDemo).slideUp();
			 	return false;
			 }
			if(defConfig.isDefShow){
				$(defConfig.showDemo).slideUp();
				$(defConfig.trigger).parent().removeClass(defConfig.activeCls);
				$(this).parent().next().slideDown();
				$(this).parent().addClass(defConfig.activeCls);
			}else{
				$(defConfig.trigger).parent().removeClass(defConfig.activeCls);
				$(this).parent().next().slideDown();
				defConfig.isDefShow = true;
				$(this).parent().addClass(defConfig.activeCls);
			}
		});
		$(defConfig.sideDemo).click(function(){
			$(defConfig.sideDemo).removeClass(defConfig.activeCls);
			$(this).addClass(defConfig.activeCls);
		});
	};

	var hover = function(){
		$(defConfig.trigger).click(function(event) {
			if(!leftShow)  return false;
			$(this).parent().next().slideDown("fast");
			$(defConfig.trigger).parent().removeClass(defConfig.activeCls);
			$(this).parent().addClass(defConfig.activeCls);
		});
		$('.side-li-box').mouseleave(function() {
			if(!leftShow)  return false;
			$(defConfig.showDemo).slideUp();
		});
	};
	//菜单收起操作
	var sideTogger = function(){
		$('#J-side-tog-btn').click(function(){
			if(!openLeft){
				leftShow = true ; openLeft = true ;
				$(".g-l").animate({width: '50px'}, 200);
				$(".g-c").animate({marginLeft: '50px'}, 200);

				$('.logo').html($('.logo').attr('miniLogo'));
				$('.side-box').addClass('side-box-left');
				$('.li-name').css('padding','15px');
				$('.li-name').addClass('left');
				$('.li-name').each(function(index, val) {
					 var fontText = $(this).find('font').html();
					 $(this).parent().next().prepend('<font>'+fontText+'</font>');
				});
				$('.li-name').find('font,span').hide();
				hover();
			}else{
				leftShow = false;openLeft = false;
				$(".g-l").animate({width: '180px'}, 200);
				$(".g-c").animate({marginLeft: '180px'}, 200);
				$('.li-name').find('font,span').animate({opacity: 'show'},800);

				$('.logo').html($('.logo').attr('logo'));
				$('.side-box').removeClass('side-box-left');
				$('.li-name').attr('style', '');
				$('.li-name').removeClass('left');
				$('.side-box').find('font').remove();
			}
		});
	};
	togfun();
	sideTogger();


	/**
     *页面加载动画
     */
     $(':submit').click(function(){
        //$('a').click(function(){
        if($(this).hasClass('unLoding')){
        	return false;
        }
        var dHid = $(document).height();
        var spinner='<div class="spinnerBox"><div class="spinner">'
                   +'  <div class="bounce1"></div>'
                   +'  <div class="bounce2"></div>'
                   +'  <div class="bounce3"></div>'
                   +'</div></div>';
        $('body').append(spinner).css('position','relative');
        $('.spinnerBox').css('height', dHid+'px');
    });

     /**
      * 全选allCheckbox
      */

    //查询选中值放入指定 容器

    var checkValFun = function( checkName,valeId){
        var data = []
        $('input[name="'+checkName+'"]:checked').each(function() {
            if(this.checked) data.push($(this).val());
         });
         $('.'+valeId).val(data);
    }

    $("#allCheckbox").click(function() {

         if (this.checked) {
            $('tbody').find('input[name="selectFlag"]').each(function() {
                $(this).prop("checked", true);
            })
         }else{
            $('tbody').find('input[name="selectFlag"]').each(function() {
                $(this).prop("checked", false);
            })
         }

        checkValFun( 'selectFlag','checkboxId');
    });
    var $subBox = $('tbody').find('input[name="selectFlag"]');
    $subBox.click(function(){
        checkValFun( 'selectFlag','checkboxId');
        $("#allCheckbox").prop("checked",$subBox.length == $('tbody').find("input[name='selectFlag']:checked").length ? true : false);


    });

});





