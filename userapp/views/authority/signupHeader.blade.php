<div id="header" class="wrap">
    <div class="wrap-inner">
        <a href="/" id="logo">博狼娱乐</a>
        <div class="right">
            <ul class="top-account">
                <li class="contact-us">

                    @if (isset($oRegisterLink) && $oRegisterLink && $oRegisterLink->agent_qqs)
                    <?php
                        $aAgentQQs = explode(',', $oRegisterLink->agent_qqs);
                    ?>
                    <a class="ui-button" href="javascript:void(0);">联系博狼娱乐代理</a>
                    <div class="submenu">
                        @foreach($aAgentQQs as $key => $value)
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{ $value }}&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:{{ $value }}:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
                        @endforeach
                    </div>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>