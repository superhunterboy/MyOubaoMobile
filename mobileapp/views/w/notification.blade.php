@if( $message = Session::get('success') )
<script>
$(function(){
  BootstrapDialog.show({
    title: '温馨提示',
    message: '{{ $message }}',
    type: BootstrapDialog.TYPE_SUCCESS,
    buttons: [{
      label: '关闭',
      action: function(dialog){
        dialog.close();
      }
    }]
  });
});  
</script>
@endif

@if( ($message = Session::get('error')) || ($message = Session::get('warning')) )
<script>
$(function(){
  BootstrapDialog.show({
    title: '温馨提示',
    message: '{{ $message }}',
    type: BootstrapDialog.TYPE_WARNING ,
    buttons: [{
      label: '关闭',
      action: function(dialog){
        dialog.close();
      }
    }]
  });
});  
</script>
@endif


@if( $message = Session::get('info') )
<script>
$(function(){
  BootstrapDialog.show({
    title: '温馨提示',
    message: '{{ $message }}',
    type: BootstrapDialog.TYPE_INFO ,
    buttons: [{
      label: '关闭',
      action: function(dialog){
        dialog.close();
      }
    }]
  });
});  
</script>
@endif

