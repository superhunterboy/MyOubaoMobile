<!DOCTYPE html>
<html>
<head>
  @section('meta')
    @include('w.meta')
  @show

  <title>
  @section('title')
  - 欧豹娱乐
  @show
  </title>

  @section ('styles')
    {{ style('third') }}
  @show
  
</head>

@section('bodyClass')
<body>
@show

  @yield('container')

  @section('footer')
  @show

  @section('scripts')
    {{ script('third') }}
    {{ script('global') }}
  @show

@include('w.notification')
</body>
</html>