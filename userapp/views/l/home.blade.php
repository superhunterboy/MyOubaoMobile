@extends('l.base')


@section ('styles')
@parent
    {{ style('ucenter') }}
@stop

@section('scripts')
@parent

    {{ script('dsgame.Select') }}
    {{ script('dsgame.Message') }}
    {{ script('dsgame.Tip') }}
@stop


@section ('container')
    @include('w.top-header')
    @include('w.nav')

        <div class="g_33 main clearfix">

            <div class="main-content">

                @section ('main')
                @show


            </div>
        </div>

    @include('w.footer')
@stop

@section('end')
@parent
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
@stop
