<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta charset="UTF-8">

        <title>
            @section('title')
            博狼娱乐
            @show
        </title>

        @section ('styles')
          {{ style('global')}}
        @show

        @section('scripts')
        {{ script('jquery-1.9.1')}}
        {{ script('dsgame.base') }}
        {{ script('dsgame.Mask') }}
        {{ script('dsgame.Message') }}
        {{ script('dsgame.Tip') }}
        @show


    </head>

    <body>


        @yield('container')

    </body>
    @include('w.notification')
    @section('end')
    <script type="text/javascript">
        (function(){
        if ($('#popWindow').length) {
            // $('#myModal').modal();
            var popWindow = new dsgame.Message();
            var data = {
                title          : '提示',
                content        : $('#popWindow').find('.pop-bd > .pop-content').html(),
                closeIsShow    : true,
                closeButtonText: '关闭',
                closeFun       : function() {
                    this.hide();
                }
            };
            popWindow.show(data);
        }
    })();
    </script>
    @show



</html>