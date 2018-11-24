@extends('l.admin', array('active' => $resource))

@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

    <div class="panel panel-default">
        <div class="panel-body">
            <form action="{{route('issues.issue-operate')}}" method="post"  class="form-horizontal" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label class="col-sm-3 control-label">彩种:</label>
                    <div class="col-sm-5">
                        <select class="form-control" name='lottery_id'>
                            @foreach ($aLotteries as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">奖期:</label>
                    <div class="col-sm-5">
                        <input class="form-control" value="" name='issue'>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">操作:</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="operate" name='operate_type'>
                            @foreach ($aOperateType as $key => $val)
                            <option value="{{$key}}">{{__('_issue.'.$val)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none" revise>
                    <label class="col-sm-3 control-label">开奖号码</label>
                    <div class="col-sm-5">
                        <input class="form-control" value="" name="new_code">
                    </div>
                </div>
                <div class="form-group" style="display: none" advanced>
                    <label class="col-sm-3 control-label">提前开奖时间</label>
                    <div class="col-sm-5">
                        <input class="form-control boot-time-xs" value="" name="earliest_draw_time">
                    </div>
                    <div class="col-sm-3 control-label" style="text-align: left;color:red;">
                        正确时间格式： 2000-01-01 01:01:01
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="reset" class="btn btn-default" >{{ __('Reset') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('end')

@parent

<script>
    $(function () {
        $('#operate').change(function (event) {
            if ($(this).val() == 1) {
                $('[advanced]').hide();
                $('[revise]').show();
            } else if ($(this).val() == 3) {
                $('[advanced]').show();
                $('[revise]').hide();
            } else {
                $('[advanced]').hide();
                $('[revise]').hide();
            }
        }).trigger('change');
    })
</script>
@stop
