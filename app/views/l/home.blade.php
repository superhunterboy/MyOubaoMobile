<!DOCTYPE html>
<html class="g-box">
  <head>
    <title>博狼娱乐管理中心</title>
    @section ('styles')
      {{ style('ui' )}}
    @show
  </head>
  <body class="g-box">
    <div class="g-box">
      <div class="g-l">
        <div class="logo" miniLogo='C' logo="CC Lottery" title="{{ $title or '' }}">
          博狼娱乐
        </div>
        <div class="side-menu" id="J-side-box">
          @foreach ($menus as $key => $menu)
            <?php if ( !isset($menu['children']) || !count($menu['children']) ) continue; ?>
            <div class="side-li-box">
              <div class="side-li-name">
                <div class="li-name">
                  <i class="glyphicon glyphicon-book"></i> <font>{{ Str::title(__('_function.' . $menu['title'])) }} </font> <!-- <span class="badge pull-right">4</span> -->
                </div>
              </div>

              <div class="side-box"  id="collapseFor{{ $key }}">
                  @foreach ($menu['children'] as $subMenu)
                    <?php
                      if ($subMenu['route_name']){
                        $sUrl = route($subMenu['route_name']);
                        !$subMenu['params'] or $sUrl .= '?' . $subMenu['params'];
                      }else{
                        $sUrl = 'javascript:void(0);';
                      }
                      $sTarget = $subMenu['new_window'] ? '_blank' : 'main';
                    ?>
                    <div class="side-li">
                      <a target="{{ $sTarget }}"  href="{{ $sUrl }}">{{ Str::title(__( '_function.' . $subMenu['title'])) }}</a>
                    </div>
                  @endforeach
              </div>

            </div>
          @endforeach
        </div>
      </div>

      <div class="g-c">
        <div class="heard-top">
          <div class="pull-left">
            <span class="menu-btn" id="J-side-tog-btn"></span>
            <a target="{{ $sTarget }}" href="{{ route('withdrawals.index') }}" withdrawals-box class="btn btn-link">提现 <span id="j-badge" class="badge badge-warning" style="display: none;"></span></a>
            <a href="##" class="btn btn-link">充值 </a>
            <a href="##" class="btn btn-link">异常 <span class="badge badge-danger"  style="display: none;"><i class="glyphicon glyphicon-bullhorn "></i></span></a>
          </div>

          <!-- <div class="btn-group">
            <button type="button" class="btn btn-b btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              快捷菜单 <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">快捷1 <span class="badge badge-danger">3</span></a></li>
              <li><a href="#">快捷2</a></li>
              <li><a href="#">快捷3</a></li>
              <li class="divider"></li>
              <li><a href="#">快捷4</a></li>
            </ul>
          </div>
          <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-b btn-sm btn-default">1</button>
            <button type="button" class="btn btn-b btn-sm btn-default">2</button>

            <div class="btn-group" role="group">
              <button type="button" class="btn btn-b btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                成组菜单
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">下拉</a></li>
                <li><a href="#">下拉</a></li>
              </ul>
            </div>
          </div> -->

        <div class="pull-right" id="aa">
          <span class="user-box">
            <a href="##">
              <img src="assets/img/logo.png" alt="{{ Session::get('admin_username') }}" class="img-thumbnail u-icon">
            </a>
          </span>
            <a href="##" class="btn btn-link">{{ Session::get('admin_username') }} <!-- <span class="badge badge-danger">3</span> --></a>
            <span class="exit-box">
              <a  target="_parent" href="{{ route('admin-logout') }}" class="btn btn-link"><span class="glyphicon glyphicon-off"  title="{{__('Logout')}}"></span></a>
            </span>
        </div>

        </div>
        <iframe name="main" id="main" src="{{ route('admin.dashboard') }}" style="border:0;" ></iframe>
      </div>
  </div>

  <div class="video"></div>

  <!--模态弹出窗-->

  <div class="modal fade" id="myModal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">.col-md-4</div>
              <div class="col-md-4 col-md-offset-4">.col-md-4 .col-md-offset-4</div>
            </div>
            <div class="row">
              <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
              <div class="col-md-2 col-md-offset-4">.col-md-2 .col-md-offset-4</div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3">.col-md-6 .col-md-offset-3</div>
            </div>
            <div class="row">
              <div class="col-sm-9">
                Level 1: .col-sm-9
                <div class="row">
                  <div class="col-xs-8 col-sm-6">
                    Level 2: .col-xs-8 .col-sm-6
                  </div>
                  <div class="col-xs-4 col-sm-6">
                    Level 2: .col-xs-4 .col-sm-6
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>

  @section('javascripts')
      {{ script('jquery') }}
      {{ script('bootstrap') }}
      {{ script('dome')}}
    @show
    <script type="text/javascript">
      $(function(){
        var role,
            startTime = 0,
            url = '/alarm/withdraw',
            mp3 = 'assets/mp3/withdrawals.mp3',
            withdrawUrl = "{{ route('withdrawals.unverified','is_tester=0') }}";
        if( {{ intval(Session::get('bFlagForFinance') )}} ){
          role = 'finance';
          url += '-finance';
          withdrawUrl = "{{ route('withdrawals.verified','is_tester=0') }}";
          mp3 = 'assets/mp3/withdrawals-finance.mp3';
        }else if( {{ intval(Session::get('bFlagForCustomer') )}} ){
          role = 'customer';
        }
        $('#j-badge').parent().attr('href', withdrawUrl);
        if( role == 'finance' || role == 'customer' ){
          setInterval(function (){
            $.ajax({
               url: url,//提款
             })
             .done(function(data) {
                var count = parseInt(data);
                if( count < 1 ){
                  startTime = 0;
                  $('.video').html();
                  $('#j-badge').hide();
                }else{
                  $('#j-badge').show().html(count);
                  var newTime = new Date().getTime();
                  if(newTime-startTime > 30*1000){
                    if(/msie/.test(navigator.userAgent.toLowerCase())) {
                        $('.video').html('<bgsound  src="'+mp3+'" loop="1"/>');
                    } else {
                        $('.video').html('<audio  src="'+mp3+'" autoplay="autoplay"/>');
                    }
                    startTime = new Date().getTime();
                  }
                }
             });
          },5000);
        }
      });

    </script>
  </body>
</html>