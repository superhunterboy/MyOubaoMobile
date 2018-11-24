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
    <div class=" panel-body">
    @include('userBankCard.detailForm')
    </div></div>
</div>

@stop

@section('end')

    @parent
    {{ script('bootstrap-switch') }}

    <?php
        $cities = json_encode($aAllCities);
        $hiddenColumns = json_encode($aHiddenColumns);
        print("<script language=\"javascript\">var provinceCities = $cities; var hiddenColumns = $hiddenColumns; </script>\n");

    ?>
    <script>
    jQuery(document).ready(function($) {
        function modal(href)
        {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
        function renderCitySelectorByProvince(province_id)
        {
            var cities = provinceCities[province_id]['children'];
            var options = ['<option></option>'];
            for (var i=0, l=cities.length; i < l; i++) {
                var item = cities[i];
                options.push('<option value="' + item['id'] + '">' + item['name'] + '</option>');
            }
            $('select[name=city_id]').html(options.join(''));
        }
        $('select').change(function(event) {
            var name = $(this).attr('name');
            var subName = name.split('_')[0];
            if (subName == 'user') subName = 'username';
            var text = $(this).find('option:selected').text();
            if (name == 'province_id') {
                var province_id = $(this).val();
                renderCitySelectorByProvince(province_id);
            }
            // if ($.inArray(subName, hiddenColumns) > -1) {
            //     $('input[type=hidden][name=' + subName + ']').val(text);
            // }
        });
    });
    </script>

@stop
