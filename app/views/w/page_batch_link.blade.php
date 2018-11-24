@foreach ($buttons['pageBatchButtons'] as $element)
<form action="{{route($element->route_name)}}">
    <input class="checkboxId" type="hidden" name="id" value="" />

    <input class="btn btn-default"  type="submit" value="{{$element->label}}">


</form>
@endforeach
