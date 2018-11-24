<!DOCTYPE html>
<html>
  <head>
    @if (isset($iRefreshTime) && $iRefreshTime)
    <meta http-equiv="refresh" content="{{ $iRefreshTime }}">
    @else
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @endif

    <script>
        (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
    </script>
    @section ('styles')
      {{ style('ui' )}}
    @show

  </head>
  <body>
    @yield('container')

    @section('javascripts')
      {{ script('jquery') }}
      {{ script('bootstrap') }}
    @show

    @section('js-code')
      {{ script('datepicker')}}
      {{ script('switch') }}
      {{ script('dome')}}
    @show

    @section('end')
    @show
  </body>
</html>

