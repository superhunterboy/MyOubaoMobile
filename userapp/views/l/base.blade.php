<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')" />
        @section ('metas')
        @show
        <title>
            @section('title')
            --博狼娱乐
            @show
        </title>

        @section ('styles')
            {{ style('global')}}
        @show


        @section('scripts')
            {{ script('jquery-1.9.1') }}
            {{ script('jquery.easing.1.3') }}
            {{ script('jquery.mousewheel') }}
            {{ script('jquery.jscrollpane') }}
            {{ script('dsgame.base') }}
            {{ script('dsgame.Ernie') }}
            {{ script('dsgame.Mask') }}
            {{ script('dsgame.MiniWindow') }}
            {{ script('global')}}

        @show
    </head>

    <body>
        @yield('container')
    </body>

    @include('w.notification')

    @section('end')

    @show

</html>
