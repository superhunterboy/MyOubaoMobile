<!DOCTYPE html>
<html>
  <head>
    <title>
    	@section('title')博狼娱乐管理中心
    	@show
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section ('styles')

      {{ style('ui' )}}

    @show


  </head>
  <body class="body">

  		@yield('body')



    @section('javascripts')
      {{ script('jquery') }}
      {{ script('bootstrap') }}
      {{ script('md5') }}
    @show

    @section('js-code')

    @show

    @section('end')

    @show
  </body>
</html>