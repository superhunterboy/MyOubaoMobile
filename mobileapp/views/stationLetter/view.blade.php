<div class="article-page-title">
  <h2>{{ $data->msg_title }}</h2>
  <p class="article-page-time"><small>{{ $data->created_at}}</small></p>
</div>
<div class="article-page-content">
{{ nl2br($data->msg_content) }}
</div>
