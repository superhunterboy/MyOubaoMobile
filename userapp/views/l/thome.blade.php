<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <meta charset="UTF-8">

        <title>
            @section('title')
            --博狼娱乐
            @show{{-- 页面标题 --}}
        </title>

        @section ('styles')
            {{ style('global') }}
            {{ style('chart') }}
        @show

        @section('scripts')

            {{ script('jquery-1.9.1') }}

            <!-- {{ script('jquery.min.map') }} -->
            {{ script('jquery.easing.1.3') }}
            {{ script('jquery.mousewheel') }}
            {{ script('jquery.jscrollpane') }}

            {{ script('dsgame.base') }}
            {{ script('dsgame.Ernie') }}
            {{ script('dsgame.Select') }}
            <!--[if IE] >{{script('IE-excanvas')}}<![endif]-->
            {{ script('dsgame.DatePicker') }}
            {{ script('dsgame.GameChart.Case') }}
            {{ script('dsgame.GameChart') }}

        @show



    </head>

    <body class="table-trend">
        @yield('container')
        <div class="prompt-text keywords-description">
            <div class="item-title"><i class="item-icon"></i>参数说明</div>
            <ol class="item-info">
                <li>出现总次数：统计期数内实际出现的次数。</li>
                <li>平均遗漏：统计期数内遗漏的平均值。（计算公式：平均遗漏＝统计期数/(出现次数+1)。）</li>
                <li>最大遗漏：统计期数内遗漏的最大值。</li>
                <li>最大连出值：统计期数内连续开出的最大值。</li>
            </ol>
        </div>
        @include('w.footer')
    </body>

        @include('w.notification')

        @section('end')

        @show

</html>