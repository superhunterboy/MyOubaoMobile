        @if($isOpenBankDeposit)<li><a href="{{ route('user-recharges.netbank') }}"><span>银行卡充值</span></a></li>@endif
        @foreach ($oPlatforms as $oNavPlatform)
        <?php $class = $oNavPlatform->id == $iPlatformId ? 'current' : ''; ?>
        <li class="{{ $class }}" id='quie-menu-{{ $oNavPlatform->id }}'><a href="{{ route('user-recharges.quick', $oNavPlatform->id) }}"><span>{{ $oNavPlatform->display_name }}</span></a></li>
        @endforeach
