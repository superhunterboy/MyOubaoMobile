jQuery(document).ready(function($) {
/**
 *页面面板左右缩进
 */
	$(".sidebar-collapse-icon").data('state', 1)
	$(".sidebar-collapse-icon").click(function(){
        var state = $(this).data('state');
        if(+state){
            parent.document.getElementById('attachucp').cols="55,*";
			$('.sidebar-list ').hide();
        } else {
            parent.document.getElementById('attachucp').cols="180,*";
			$('.sidebar-list ').show();
        }
        $(this).data('state', +!state)
    });

    /**
     *折叠面板方向图标
     */


    /**
     *菜单状态
     */
     //$(".sidebar-nav").find('.sub-menu:first').addClass('in').end().find('[data-toggle="collapse"]:first').addClass('active');
     $(".sidebar-list").find('[target="main"]').click(function(event) {
        $(".sidebar-list").find('[target="main"]').removeClass('active').end().find('[data-toggle="collapse"]').removeClass('active');
         $(this).addClass('active');
         $(this).parents('li.sidebar-list').find('[data-toggle="collapse"]').addClass('active');
     });




});
