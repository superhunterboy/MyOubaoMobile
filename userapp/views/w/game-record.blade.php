<div class="game-record-section">
	<ul class="tabs clearfix">
		<li class="current" srcLink="{{route('projects.mini-window')}}"><a href="javascript:;" >游戏记录</a></li>
		<li srcLink="/tasks/mini-window"><a href="javascript:;" >追号记录</a></li>
		<li srcLink="/transactions/mini-window"><a href="javascript:;" >资金明细</a></li>
	</ul>
	<div class="record-content">
		<iframe id="record-iframe" src="{{route('projects.mini-window')}}" width="100%" height="220px" frameborder="0"></iframe>
	</div>
</div>