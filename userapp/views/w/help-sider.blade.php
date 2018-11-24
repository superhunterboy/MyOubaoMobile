<div class="help-side">
    @foreach($aTitles as $data)
        <h3>{{ $data['name'] }}</h3>
        <div class="help-side-nav">
            @foreach($data['children'] as $child)
            <a href="{{route('help.index',$child['category_id'])}}#{{$child['id']}}">{{ $child['title'] }}</a>
            @endforeach
        </div>
    @endforeach
</div>

