@extends('l.admin', ['active' => $resource])
@section('title')
@parent
{{ $sPageTitle }}
@stop

@section('container')
<div class="col-md-12">
  @include('w._function_title', ['id' => $data->id , 'parent_id' => $data->parent_id])
  @include('w.breadcrumb')
  @include('w.notification')

  <div class="panel panel-default">
    <div class="panel-body">
        <table class="table table-bordered table-striped" id="J-tabel">
          <tbody>
            <?php
              $i = 0;
              foreach ($aColumnSettings as $sColumn => $aSetting){

                if (isset($aViewColumnMaps[ $sColumn ])){
                  $sDisplayValue = $data->{$aViewColumnMaps[ $sColumn ]};
                }else{
                  if (isset($aSetting[ 'type' ])){
                      switch ($aSetting[ 'type' ]){
                          case 'ignore':
                              continue 2;
                              break;
                          case 'bool':
                              $sDisplayValue = $data->$sColumn ? __('Yes') : __('No');
                              break;
                          case 'text':
                              $sDisplayValue = nl2br($data->$sColumn);
                              break;
                          case 'select':
                              $sDisplayValue = __($sLangPrev . Str::slug(strtolower(!is_null($data->$sColumn) ? ${$aSetting[ 'options' ]}[ $data->$sColumn ] : null)));
                              break;
                          case 'numeric':
                          case 'date':
                          default:
                              $sDisplayValue = $data->$sColumn;
                      }
                  }else{
                    $sDisplayValue = $data->$sColumn;
                  }
                }

            ?>
              <tr>
                  <th class="text-center" style="width:30px;">{{ $i+1 }}</th>
                   <th  class="text-right col-xs-2">{{ __($sLangPrev . $sColumn, null, 2) }}</th>
                   @if($sColumn=='transaction_pic_url' && !is_null($data->transaction_pic_url))
                   <td class="data-copy"><img src="{{route('withdrawals.load-img', [$data->id])}}"/></td>
                   @else
                  <td class="data-copy">{{ $sDisplayValue }}</td>
                  @endif
                  <td class="{{$sColumn}}"></td>
              </tr>
            <?php
              $i++;
              }
            ?>
          </tbody>
        </table>
      </div>
  </div>
</div>
@stop
@section('end')
{{ script('ZeroClipboard')}}
    @parent
    <script>

 $(function(){
        //初始化加入按钮
        var table = $('#J-tabel'), btn = '<input type="button" class="btn btn-xs   btn-default" value="点击复制" />';
//,.amount,.bank,.account
        $('.account_name,.amount,.bank,.account').html(btn);
        $('input').each(function(e){
          $(this).attr('id', $(this).parents('td').attr('class'))
        })

        //载入复制
        ZeroClipboard.setMoviePath('/assets/js/ZeroClipboard.swf');

        var
            clip_name = new ZeroClipboard.Client(),
            clip_card = new ZeroClipboard.Client(),
            clip_money = new ZeroClipboard.Client(),
            clip_msg = new ZeroClipboard.Client(),
            table = $('#J-table'),
            fn = function(client){
              var el = $(client.domElement),value = $.trim(el.parent().parent().find('.data-copy').text());
              client.setText(value);
              alert('复制成功:\n\n' + value);
            };

          clip_name.setCSSEffects( true );
          clip_card.setCSSEffects( true );
          clip_money.setCSSEffects( true );
          clip_msg.setCSSEffects( true );

          clip_name.addEventListener( "mouseUp", fn);
          clip_card.addEventListener( "mouseUp", fn);
          clip_money.addEventListener( "mouseUp", fn);
          clip_msg.addEventListener( "mouseUp", fn);

          clip_name.glue('amount');
          clip_card.glue('bank');
          clip_money.glue('account');
          clip_msg.glue('account_name');



    })

    //------------------------//
        function modal(href)
       {
            $('#real-delete').attr('action', href);
            $('#myModal').modal();
        }
   </script>
@stop