<?php
    $presenter = new Illuminate\Pagination\CustomPagerPresenter($paginator);
?>

<div class=" page-wrapper clearfix">
    <div class="page page-right">
        {{ $presenter->render() }}
        <span class="page-few">第{{ $paginator->getCurrentPage() }}页，共{{ $paginator->getTotal() }}条</span>
    </div>
</div>
