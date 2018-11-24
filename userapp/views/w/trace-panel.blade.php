<div class="j-ui-miniwindow pop pop-panel-trace trace-panel" id="J-trace-panel">
	<div class="trace-radio pop-hd">
		<i class="pop-close closeBtn"></i>
		<a href="javascript:void(0);" data-value="tongbei">同倍追号</a>
		<a href="javascript:void(0);" data-value="lirunlv">利润率追号</a>
		<a href="javascript:void(0);" data-value="fanbei">翻倍追号</a>
	</div>
	<div class="trace-content">
		<div class="chase-tab">
			<div class="chase-tab-content">
				<div class="trace-title-param">
					<div class="filter-tabs">
						<span class="filter-tabs-title">连续追:</span>
						<div class="filter-tabs-cont J-trace-tongbei-times-filter">
							<a href="javascript:void(0);" data-value="5">5期</a>
							<a href="javascript:void(0);" data-value="10">10期</a>
							<a href="javascript:void(0);" data-value="15">15期</a>
							<a href="javascript:void(0);" data-value="20">20期</a>
						</div>
					</div>
					<label class="param">
						已选:&nbsp;<input id="J-trace-tongbei-times" class="input w-1" type="text" value="10" />&nbsp;期
					</label>
					<label class="param">
						倍数:
						<select id="J-trace-tongbei-multiple-select" style="display:none;">
							<option value="1">1</option>
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="15">15</option>
							<option value="20">20</option>
						</select>
						倍
						<input id="J-trace-tongbei-multiple" class="input" type="hidden" value="1" />
					</label>
					<input type="button" class="btn trace-button-detail btn-important" value="生成追号计划" />
				</div>

				<div class="chase-table-container">
					<table class="table chase-table" id="J-trace-table">
						<tbody id="J-trace-table-tongbei-body" data-type="tongbei">
							<tr>
								<th class="text-center">序号</th>
								<th><input type="checkbox" checked="checked" class="checkbox" data-action="checkedAll">追号期次</th>
								<th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- 利润率追号 -->
			<div class="chase-tab-content">
				<div class="trace-title-param">
					<label class="param right c-red" style="line-height: 28px;">注意：利润率计算使用当前用户最大奖金组计算</label>
					<label class="param">
						最低收益率:
						<input id="J-trace-lirunlv-num" class="input w-1" type="text" value="50" /> %
					</label>
					<label class="param">
						追号期数:
						<input id="J-trace-lirunlv-times" class="input w-1" type="text" value="10" />
					</label>
					<input type="button" class="btn trace-button-detail btn-important" value="生成追号计划" />
				</div>

				<div class="chase-table-container">
					<table id="J-trace-table-lirunlv" class="table chase-table">
						<tbody data-type="lirunlv" id="J-trace-table-lirunlv-body">
							<tr><th class="text-center">序号</th><th><input  checked="checked" data-action="checkedAll" type="checkbox"> 追号期次</th><th>倍数</th><th>金额</th><th>奖金</th><th>预期盈利金额</th><th>预期盈利率</th></tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- 翻倍追号 -->
			<div class="chase-tab-content">
				<div class="trace-title-param">
					<label class="param">
						起始倍数:
						<input id="J-trace-fanbei-multiple" class="input w-1" type="text" value="1" />
					</label>
					<label class="param">
						隔
						<input id="J-trace-fanbei-jump" class="input w-1" type="text" value="2" />
					</label>
					<label class="param">
						期 倍x
						<input id="J-trace-fanbei-num" class="input w-1" type="text" value="2" />
					</label>
					<label class="param">
						追号期数:
						<input id="J-trace-fanbei-times" class="input w-1" type="text" value="10" />
					</label>
					<input type="button" class="btn trace-button-detail btn-important" value="生成追号计划" />
				</div>

				<div class="chase-table-container">
					<table class="table chase-table" id="J-trace-table">
						<tbody id="J-trace-table-fanbei-body" data-type="fanbei">
							<tr>
								<th class="text-center">序号</th>
								<th><input type="checkbox" checked="checked" class="checkbox" data-action="checkedAll">追号期次</th>
								<th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="chase-tab-content">
				<div class="chase-select-high">
					<div class="title">基本参数</div>
					<ul class="base-parameter">
						<li>
							起始期号：
							<select id="J-traceStartNumber" style="display: none;"></select>
						</li>
						<li>
							追号期数：
							<input id="J-trace-advanced-times" type="text" class="input" value="10">&nbsp;&nbsp;期（最多可以追<span id="J-trace-number-max">14</span>期）
						</li>
						<li>
							起始倍数：
							<input id="J-trace-advance-multiple" type="text" class="input" value="1">&nbsp;&nbsp;倍
						</li>
					</ul>

					<div class="title">高级参数</div>
					<div id="J-trace-advanced-type-panel" class="high-parameter">
						<ul class="tab-title">
							<li class="current">翻倍追号</li>
							<li>盈利金额追号</li>
							<li>盈利率追号</li>
						</ul>
						<ul class="tab-content">
							<li class="panel-current">
								<p data-type="a">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1" checked="checked">
									每隔&nbsp;<input id="J-trace-advanced-fanbei-a-jiange" type="text" class="input" value="2">&nbsp;期
									倍数x<input id="J-trace-advanced-fanbei-a-multiple" type="text" class="input trace-input-multiple" value="2">
								</p>
								<p data-type="b">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type1">
									前&nbsp;<input id="J-trace-advanced-fanbei-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
									倍数=起始倍数，之后倍数=<input id="J-trace-advanced-fanbei-b-multiple" type="text" class="input trace-input-multiple" value="2" disabled="disabled">
								</p>
							</li>
							<li>
								<p data-type="a">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2" checked="checked">
									预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-a-money" type="text" class="input" value="100">&nbsp;元
								</p>
								<p data-type="b">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type2">
									前&nbsp;<input id="J-trace-advanced-yingli-b-num" type="text" class="input" value="2" disabled="disabled">&nbsp;期
									预期盈利金额≥&nbsp;<input id="J-trace-advanced-yingli-b-money1" type="text" class="input" value="100" disabled="disabled">&nbsp;元，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-money2" type="text" class="input" value="50" disabled="disabled">&nbsp;元
								</p>
							</li>
							<li>
								<p data-type="a">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3" checked="checked">
									预期盈利率≥&nbsp;<input id="J-trace-advanced-yinglilv-a" type="text" class="input" value="10">&nbsp;%
								</p>
								<p data-type="b">
									<input class="trace-advanced-type-switch" type="radio" name="trace-advanced-type3">
									前&nbsp;<input id="J-trace-advanced-yinglilv-b-num" type="text" class="input" value="5" disabled="disabled">&nbsp;期
									预期盈利率≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv1" type="text" class="input" value="30" disabled="disabled">&nbsp;%，之后≥&nbsp;<input id="J-trace-advanced-yingli-b-yinglilv2" disabled="disabled" type="text" class="input" value="10">&nbsp;%
								</p>
							</li>
						</ul>
					</div>
				</div>

				<div class="chase-table-container">
					<table id="J-trace-table-advanced" class="table chase-table">
						<tbody id="J-trace-table-advanced-body">
							<tr>
								<th style="width:125px;" class="text-center">序号</th>
								<th><label class="label"><input type="checkbox" class="checkbox">追号期次</label>
								</th><th>倍数</th>
								<th>金额</th>
								<th>预计开奖时间</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="bet-statistics">
			<table class="table">
				<th><span id="J-trace-statistics-times">0</span><br>期数</th>
				<th><span id="J-trace-statistics-lotterys-num">0</span><br>注数</th>
				<th><span id="J-trace-statistics-amount">0.00</span><br>追号方案总金额(元)</th>
				<th><span id="J-trace-statistics-balance">0.00</span><br>账户可用余额(元)</th>
				<th><span id="J-trace-statistics-countdown">00:01:35</span><br>本期投注截止</th>
			</table>
		</div>

		<div class="pop-btn">
			<a href="javascript:void(0);" class="btn btn-submit disable" id="J-button-trace-confirm">确认追号投注</a>
			<div class="trace-switch-label">
				<div class="chase-stop" id="J-trace-iswintimesstop-panel">
					<label class="label">
						<input type="checkbox" class="checkbox" id="J-trace-iswintimesstop" checked="checked">
						<span>中奖后停止追号</span>
					</label>
					<input type="text" value="1" class="input" id="J-trace-iswintimesstop-times" style="display:none;">&nbsp;
					<i id="J-trace-iswintimesstop-hover" class="icon-question" style="display:none;">
						玩法提示
						<div class="chase-stop-tip" id="chase-stop-tip-1">
							当追号计划中，一个方案内的任意注单中奖时，即停止继续追号。<br>
							如果您希望考虑追号的实际盈利，<a id="J-chase-stop-switch-1" href="#">点这里</a>。
						</div>
					</i>
				</div>
				<div style="display:none;" class="chase-stop" id="J-trace-iswinstop-panel">
					<label for="J-trace-iswinstop" class="label"><input type="checkbox" class="checkbox" id="J-trace-iswinstop">累计盈利</label>
					&gt;
					&nbsp;<input type="text" value="1000" class="input" disabled="disabled" id="J-trace-iswinstop-money" style="width:30px;text-align:center;padding:0 4px;">&nbsp;元时停止追号
					<i id="J-trace-iswinstop-hover" class="icon-question" style="display:none;">
						玩法提示
						<div class="chase-stop-tip" id="chase-stop-tip-2">
							当追号计划中，累计盈利金额（已获奖金扣除已投本金）大于设定值时，即停止继续追号。<br>
							如果您不考虑追号的盈利情况，<a id="J-chase-stop-switch-2" href="#">点这里</a>。
						</div>
					</i>
				</div>
			</div>
		</div>
	</div>

</div>