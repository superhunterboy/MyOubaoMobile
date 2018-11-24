@if(isset($oUser) && is_object($oUser))
<?php
$aForefatherId = explode(',', $oUser->forefather_ids);
$aFirstIndex = array_keys($aForefatherId,Session::get('user_id'));
$aForefatherId = array_slice($aForefatherId, $aFirstIndex[0]);
$aForefather = explode(',', $oUser->forefathers);
$aForefather = array_slice($aForefather, $aFirstIndex[0]);
$i = 0;
?>
<div class="breadcrumb">
@foreach($aForefatherId as $userId)
@if($i==0)
<a href="{{route('users.index')}}">{{$aForefather[$i++]}}</a>
@else
<a href="{{route('users.sub-users', $userId)}}">{{$aForefather[$i++]}}</a>
@endif
@endforeach
</div>
@endif
<table width="100%" class="table table-toggle">
    <thead>
        <tr>
            <th>用户名{{-- custom_order_by('username', 'asc') --}}</th>
            <th>所属用户组</th>
            <th>奖金组</th>
            <th>下级人数</th>
            <th>注册时间</th>
            <th>最后登录时间</th>
            <th>用户余额</th>
            <th>团队余额</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $oUser)
        <tr>
            <td>@if($oUser->is_agent == 1)<a href="{{route('users.sub-users', [$oUser->id])}}">{{ $oUser->username }}</a>@endif @if($oUser->is_agent == 0){{ $oUser->username }}@endif</td>
            <td>{{ __('_user.'.$oUser->user_type_formatted)}}</td>
            <td>{{ $oUser->prize_group}}</td>
            <td>{{ $oUser->children_num }}</td>
            <td>{{ $oUser->register_at }}</td>
            <td>{{ $oUser->signin_at }}</td>
            <td><dfn>￥</dfn><span class="c-important" data-money-format>{{ $oUser->user_account }}</span></td>
            <td>@if($oUser->is_agent==1)<dfn>￥</dfn><span class="c-important" data-money-format>{{ $oUser->group_account_sum }}</span>@else &nbsp;@endif</td>
            <td>
                <a class="ui-action-adjust" href="{{ route('user-user-prize-sets.set-prize-set', $oUser->id) }}">调整奖金组/配额</a>
                <a class="ui-action-check" href="{{ route('user-transactions.index', $oUser->id) }}">查看账变</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>