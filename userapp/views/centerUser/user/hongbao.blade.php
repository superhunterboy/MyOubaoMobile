@extends('l.home')

@section('title')
红包中心
@parent
@stop

@section('scripts')
@parent
{{ script('dsgame.Mask') }}
@stop

@section('main')
<div class="g_33 main clearfix">
    <div class="main-sider">


    </div>
    <div class="main-content">

        <div class="nav-bg">
            <div class="title-normal">我的红包</div>
        </div>

        <div class="content myhongbao clearfix">

            <!-- 活动推送 -->
            <span data-event-push style="dispaly:none;"></span>

            <div class="hongbao-box">
                <div class="hb-top">
                    @if($datas->getTotal()>0)
                    <div class="right">    
                        <div class="list-show-mode">
                            <a href="javascript:void(0);" data-mode="view" class="view-mode">图片模式</a>
                            <a href="javascript:void(0);" data-mode="list" class="list-mode">列表模式</a>
                        </div>
                    </div>
                    @endif
                    <div class="filter-tabs">
                        <div class="filter-tabs-cont">
                            <a @if(Route::current()->getName() == 'user-activity-user-prizes.index')class="current" @endif href="{{route('user-activity-user-prizes.index')}}?type=pic">全部({{$iHongBaoTotalCount}})</a>
                            <a @if(Route::current()->getName() == 'user-activity-user-prizes.available')class="current" @endif href="{{route('user-activity-user-prizes.available')}}?type=pic">可领取({{$iHongBaoAvailableCount}})</a>
                            <!-- <a href="{{route('user-activity-user-prizes.received')}}?type=pic">暂不可领取(0)</a> -->
                            <a @if(Route::current()->getName() == 'user-activity-user-prizes.received')class="current" @endifhref="{{route('user-activity-user-prizes.received')}}?type=pic">已领取({{$iHongBaoReceivedCount}})</a>
                            <a @if(Route::current()->getName() == 'user-activity-user-prizes.expired')class="current" @endifhref="{{route('user-activity-user-prizes.expired')}}?type=pic">已过期({{$iHongBaoExpiredCount}})</a>
                        </div>
                    </div>
                </div>
                @if($datas->getTotal()>0)
                @if($type=='pic')
                <ul class="hb-list clearfix" id="J-hb-list" data-show-mode="view" style="display:none;">
                    @foreach($datas as $data)
                    <?php
                    $aData = json_decode($data->data, true);
                    // $statusClass = 'hb-' . $data->type;
                    $statusClass = 'hb-rebate';
                    $btnHtml1 = $btnHtml2 = '';

                    // 已领取
                    if( $data->status == 2 ){
                        $statusClass .= ' hb-claimed';
                        $btnHtml1 = '<a class="btn" href="javascript:void(0);">已领取</a>';
                        $btnHtml2 = '已领取';
                    }
                    //  可领取
                    else if( $data->status == 4 ){
                        $btnHtml1 = '<a data-button=" '.$data->id.' " class="btn btn-important" href="javascript:void(0);">领取红包</a>';
                        $btnHtml2 = '<a data-button=" '.$data->id.' " class="c-important" href="javascript:void(0);">领取红包</a>';
                    }
                    // 过期的
                    else if( $data->status == 6 ){
                        $statusClass .= ' hb-expired';
                        $btnHtml1 = '<a class="btn" href="javascript:void(0);">发放中</a>';
                        $btnHtml2 = '发放中';
                    }
                    // 锁定的
                    else if( $data->status == 8 ){
                        $statusClass .= ' hb-locked';
                        $btnHtml1 = '<a class="btn" href="javascript:void(0);">已锁定</a>';
                        $btnHtml2 = '已锁定';
                    }
                    ?>
                    <li class="{{$statusClass}}">
                        <div class="css-flip css-flip-x">
                            <div class="flip-front hb-cover">
                                <span class="hb-icon"></span>
                            </div>
                            <div class="flip-back">
                                <dl>
                                    <dt><span class="c-important">红包</span></dt>
                                    <dt>获得于：</dt>
                                    <dd>{{$data->created_at}}</dd>
                                    <dt>获得自：</dt>
                                    <dd><span class="c-important">{{$data->prize_name}}</span></dd>
                                    <dt>领取过期时间：</dt>
                                    <dd><span class="c-important">{{$data->expired_at}}</dd>
                                </dl>
                            </div>
                        </div>
                        <p><span data-money-format>{{$aData['rebate_amount']}}</span>元</p>
                        {{$btnHtml1}}
                    </li>
                    @endforeach
                </ul>
                <div class="hb-list" data-show-mode="list" style="display:none;">
                    <table class="table">
                        <tr>
                            <th>红包类型</th>
                            <th>获得途径</th>
                            <th>获得时间</th>
                            <th>红包金额（元）</th>
                            <th>过期时间</th>
                            <th>红包状态</th>
                        </tr>
                        @foreach($datas as $data)
                        <?php
                        $aData = json_decode($data->data, true);
                        $statusClass = 'hb-rebate';
                    $btnHtml1 = $btnHtml2 = '';

                    // 已领取
                    if( $data->status == 2 ){
                        $statusClass .= ' hb-claimed';
                        $btnHtml2 = '已领取';
                    }
                    //  可领取
                    else if( $data->status == 4 ){
                        $btnHtml2 = '<a data-button=" '.$data->id.' " class="c-important" href="javascript:void(0);">领取红包</a>';
                    }
                    // 过期的
                    else if( $data->status == 6 ){
                        $statusClass .= ' hb-expired';
                        $btnHtml2 = '发放中';
                    }
                    // 锁定的
                    else if( $data->status == 8 ){
                        $statusClass .= ' hb-locked';
                        $btnHtml2 = '已锁定';
                    }
                        ?>
                        <tr>
                            <td>活动红包</td>
                            <td>{{$data->prize_name}}</td>
                            <td>{{$data->created_at}}</td>
                            <td><span>{{$aData['rebate_amount']}}</span>元</td>
                            <td>{{$data->expired_at}}</td>
                            <td>{{$btnHtml2}}</td>
                        </tr>
                        @endforeach
                        </tr>
                    </table>
                </div>
                @elseif($type=='table')
                <div class="hb-list">
                    <table class="table">
                        <tr>
                            <th>红包名称</th>
                            <th>红包金额</th>
                            <th>领取时间</th>
                            <th>过期时间</th>
                        </tr>
                        @foreach($datas as $data)
                        <?php
                        $aData = json_decode($data->data, true);
                        ?>
                        <tr>
                            <td>{{$data->prize_name}}</td>
                            <td>{{$aData['rebate_amount']}}元</td>
                            <td>{{$data->received_at}}</td>
                            <td>{{$data->expired_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                {{ pagination($datas->appends(Input::except('page')), 'w.pages') }}
                @else
                <div class="hb-list">
                    <div class="no-data">暂时没有找到符合当前条件的红包哦～</div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@stop


@section('end')

@parent
<script>
(function($){

    var $lists = $('#J-hb-list');

    // Flip添加class
    $('li .css-flip', $lists).hover(function () {
        $(this).addClass('flip-hover');
    }, function () {
        $(this).removeClass('flip-hover');
    });

    // 列表显示方式
    var $modes = $('[data-mode]'),
            mode = dsCookie.readCookie('hongbaoListMode'),
            $lists = $('[data-show-mode]').fadeOut(0);
    if (mode != 'view' && mode != 'list') {
        mode = 'view';
    }
    $modes.on('click', function () {
        var mode = $(this).data('mode');
        if (!mode || (mode != 'view' && mode != 'list') || $(this).hasClass('active'))
            return false;
        $lists.fadeOut(0).filter('[data-show-mode="' + mode + '"]').fadeIn();
        dsCookie.eraseCookie('hongbaoListMode');
        dsCookie.createCookie('hongbaoListMode', mode, 100);
        $(this).addClass('active').siblings().removeClass('active');
    }).filter('[data-mode="' + mode + '"]').trigger('click');

    // 下拉组件
    // var selectYear = new dsgame.Select({
    //     cls: 'select-game-statics-multiple w-2',
    //     realDom: '#J-hongbao-select',
    // });
    // selectYear.addEvent('change', function (e, value, text) {
    //     console.log(value, text);
    // });

    // 领取红包
    var hbWindow = new dsgame.Message();
    var hbMask = new dsgame.Mask();
    $('[data-button]', $lists).on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
                id = $this.data('button');
        $.ajax({
            type: 'POST',
            url: '{{route("user-activity-user-prizes.get-prize")}}',
            data: 'id=' + id +'&_token={{ csrf_token() }}',
            success: function (resp) {
                 resp = $.parseJSON(resp);
                var data = {
                    closeIsShow: true,
                    closeButtonText: '关闭',
                    closeFun: function () {
                        this.hide();
                        hbMask.hide();
                    }
                };
                if (resp.msgType == 'error') {
                    data['title'] = '红包领取失败';
                    data['content'] = '红包领取失败，请稍候再试';
                } else {
                    data['title'] = '红包领取成功';
                    // console.log(resp, resp.money, resp.msgType);
                    data['content'] = '价值' + resp.money + '元的红包礼金已经发放到您的账户中了，请在<a class="c-important" href="{{ route('user-transactions.index') }}">账变记录</a>中查看。';
                    if ($this.hasClass('btn')) {
                        $this.parents('li:eq(0)').addClass('hb-claimed').end()
                                .replaceWith('<a class="btn" href="javascript:void(0);">已领取</a>');
                    } else {
                        $this.replaceWith('已领取');
                    }
                }
                hbWindow.show(data);
                hbMask.show();
            }
        });
    });

})(jQuery);
</script>
@stop