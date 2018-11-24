@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('javascripts')
@parent
{{ script('bootstrap-3-switch') }}
@stop

@section('container')
<div class="col-md-12">
    @include('w.breadcrumb')
    @include('w._function_title')
    @include('w.notification')

    <div class="panel panel-default">
        <div class=" panel-body">

            <form method="post" action="{{ route($resource .'.create') }}" accept-charset="UTF-8" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div>
                    <div class="form-group">
                        <label for=" " class="col-sm-2 control-label"> 缩写名称：</label>
                        <div class="col-sm-4"><input class="form-control" type="text" name="identifier"></div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label for=" " class="col-sm-2 control-label"> 描述：</label>
                        <div class="col-sm-4"><input class="form-control" type="text" name="description"></div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="form-group">
                        <label for=" " class="col-sm-2 control-label"> 表达式X：</label>
                        <div class="col-sm-10 j-fee-box">
                            <div class="j-add-fee clearfix" style="margin-bottom:2px;">
                                <!-- 条件区 START -->
                                <div style=" width:80px; float:left;">
                                    <input class="form-control" type="text" onkeyup="this.value = this.value.replace(/[^0-9]/g, '')"  value="" name="expression_set[0][amount_left]">
                                </div>
                                <label for=" " class="control-label " style="text-align: center; width:120px; float:left;">
                                    <font color="red"> &le; </font>X <font color="red"> &lt;</font>
                                </label>
                                <div style=" width:80px; float:left;">
                                    <input class="form-control" type="text" onkeyup="this.value = this.value.replace(/[^0-9]/g, '')" value="" name="expression_set[0][amount_right]">
                                </div>
                                <!-- 条件区 END -->
                                <label for=" " class="control-label " style="text-align: center; width:120px; float:left;">，值Y：</label>
                                <!-- 取值区 START -->
                                <div  style=" width:60px; float:left;">
                                    <select class="form-control j-select" name="expression_set[0][operator]" >
                                        <option value="=" <?php if (isset($fe['y']['='])) echo 'SELECTED'; ?>>固定值</option>
                                        <option value="%" <?php if (isset($fe['y']['%'])) echo 'SELECTED'; ?>>百分比</option>
                                    </select>
                                </div>
                                <div  style=" width:120px; float:left;" class="j-teggle">
                                    <span class="j-none">
                                        <input style=" width:50px;float:left;" class="form-control" type="text" value="" name="expression_set[0][value]">
                                        <label for=" " class="control-label ">元</label>
                                    </span>
                                    <span class="j-none"style="display: none;">
                                        <select style=" width:50px;float:left;" class="form-control" name="expression_set[0][value]" id=" " disabled="">
                                        </select>
                                        <label for=" " class="control-label " ><font color="red"> %</font></label>
                                    </span>
                                </div>
                                <!-- 取值区 END -->
                                <span class="btn    btn-danger j-delete" onclick="removeDiv(this);">删除</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <span id="add-fee-btn" class="btn    btn-default">添加新区间</span>
                            <input type="submit" class="btn   btn-success" value="保存设置" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




@stop

@section('end')
@parent
<script type="text/javascript">
    $(function () {

        var domHtml = $('.j-add-fee:last').html();
        var allHtml = '<div class="j-add-fee clearfix" style="margin-bottom:2px;">' + domHtml + '</div>';


        $('#add-fee-btn').click(function () {
            var eq2val = $('.j-add-fee ').last().find('input').eq(1).val();
            var eq1val = $('.j-add-fee ').last().find('input').eq(0).val();
            if (eq2val == '' || eq2val == null || +eq2val < +eq1val) {
                alert('请确保最后一条区间范围正确');
                return false;
            }
            var newName = inputVal();
            var lastVal = $('input[name*="[amount_right]"]').last().val();
            $('.j-fee-box').append(allHtml)/*.find('.j-add-fee').last().find('.j-teggle').html(teggleHtml)*/;
            $('.j-add-fee ').last().find(':input').each(function (i) {
                $(this).attr('name', newName[i]);
            });
            $('.j-add-fee ').last().find('input').eq(0).val(lastVal);
            $('.j-add-fee').last().find('input[name*="[amount_right]"]').val('');
        });

        var inputVal = function () {
            var a = [];
            var inputName = $('.j-add-fee ').last().find(':input').each(function (i) {
                a.push($(this).attr('name'));
                return a;
            })
            var newName = [];
            for (var i = 0; i < a.length; i++) {
                newName.push(a[i].replace(/\d/g, parseInt(a[i].match(/\d/g)) + 1));
            }
            return newName;
        };

        //切换
        $('form.form-horizontal').on('change', 'select.j-select', function (e) {
            var dom = $(this).parent().next().find('span');
            if ($(this).val() == "=") {
                dom.find('input , select').attr('disabled', true);
                dom.hide().eq('0').show().find('input , select').attr('disabled', false);
            } else {
                dom.find('input , select').attr('disabled', true);
                dom.hide().eq('1').show().find('input , select').attr('disabled', false);
            }
        });

    });

    function removeDiv(dome) {

        $(dome).parent('div.j-add-fee').remove();

    }

</script>

@stop
