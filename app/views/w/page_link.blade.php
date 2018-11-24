<div class="form-inline pull-right">
@foreach ($buttons['pageButtons'] as $element)
<?php
//pr($element->getAttributes());
// pr($element->label);exit;
//continue;
?>
<div class="form-group">
    <?php
    if (!$url = $element->url){
        if ($element->route_name){
            $url = $element->para_name && isset(${$element->para_name}) ? route($element->route_name, ${$element->para_name}) : route($element->route_name);
        }
        else{
            $url = 'javascript:void(0);';
        }
    }
    ?>
    @if ($element->btn_type == 1)
    <a href="javascript:void(0)" class="btn   btn-danger"
                 onclick="modal('{{ $url  }}')">{{ __( $element->label) }}</a>
    @elseif ($element->btn_type == 2)
    <a href="{{ $url }}" class="btn   btn-success">{{ __( $element->label) }}</a>
    @else
      <?php // if ($element->para_name){
//          $url = $element->route_name ? route($element->route_name, str_contains($element->route_name, 'index') ? [$element->para_name => ${$element->para_name}] : ${$element->para_name}) : 'javascript:void(0);';
//        }
        ?>
        <a  href="{{ $url }}" class="btn   btn-default" > {{ __( $element->label) }}</a>

    @endif
</div>
@endforeach
</div>
