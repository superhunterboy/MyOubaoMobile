<!DOCTYPE html>
<html>
    <head>
        <title>
            @section('title')
            @show{{-- 页面标题 --}}
        </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--[if lt IE 9]>
            <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
            <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script>
            (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
        </script>
        @section ('styles')
          {{ style('bootstrap-3.0.3') }}
          {{ style('main' ) }}
          {{ style('ui' ) }}
        @show
    </head>
    <body>
        <nav class="navbar" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" target="main" href="{{ route('admin.dashboard') }}">{{ $title or '' }}</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <!--
              <ul class="nav navbar-nav">
                <li>
                    <a href="##"></a>
                </li>
              </ul>
 -->
                <ul class="nav navbar-nav navbar-right">
                  <!-- <li>
                    <a target="main" href="###">
                        <span class="glyphicon glyphicon-bullhorn label label-warning"> 提款消息</span>
                    </a>
                  </li> -->

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/img/logo.jpg" style="width:20px;" class="img-circle"> {{ Session::get('admin_username') }} <!-- <b class="caret"></b> --></a>
                    <!-- <span class="dropdown-arrow dropdown-arrow-inverse"></span>
                    <ul class="dropdown-menu">
                      <li><a href="#">修改信息</a></li>
                      <li><a href="#">安全管理</a></li>
                      <li class="divider"></li>
                      <li><a href="#">帮助中心</a></li>
                      <li><a href="#">建议反馈</a></li>
                    </ul> -->
                  </li>
                  <li>
                    <a  target="_parent" href="{{ route('admin-logout') }}">
                        <span class="glyphicon glyphicon-off" title="{{__('Logout')}}"></span>
                    </a>
                  </li>
                </ul>
            </div>

        </nav>

        @section('javascripts')
          {{ script('jquery-1.10.2') }}
          {{ script('bootstrap-3.0.3') }}
        @show
    </body>
</html>