<div class="article-page-title">
  <h2>{{ $data->title }}</h2>
  <p class="article-page-time"><small>{{ $data->created_at}}</small></p>
</div>
<div class="article-page-content">
{{ nl2br($data->content) }}
</div>