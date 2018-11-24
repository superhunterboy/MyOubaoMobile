@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w._function_title')
    @include('w.breadcrumb')
    @include('w.notification')
    <div class="col-md-6">
        <div class="panel panel-default">

            <div class=" panel-body">
                    <table class="table table-bordered table-striped">
                        
                    </table>

            </div>
            <div class="panel-footer">
                <form action="{{route('withdrawals.remit-verify', $oBankCard->id)}}" method="post" class="text-right">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input class="btn btn-success" type="submit" value="通过" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">{{ __($sLangPrev . 'transaction_pic_url', null, 2) }}</div>
            <div class=" panel-body">

                <img src="{{ route('withdrawals.load-img',[$oBankCard->id ])}}" >
            </div>
        </div>
    </div>
</div>
@stop

@section('end')
@parent
<script>
    $('[data-toggle="popover"]').popover()
    function modal(href)
    {
        $('#real-delete').attr('action', href);
        $('#myModal').modal();
    }
</script>
@stop
