<?php
	$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>
<div class="pull-right">
<ul class="pagination pagination-sm">
<li class=""><span>{{ __('_basic.page') . $paginator->getCurrentPage() }}, {{ __('_basic.per page') . $paginator->getPerPage() }}, {{ __('_basic.total') . $paginator->getTotal() }}<span></li>
    {{ $presenter->render() }}
</ul>
</div>
