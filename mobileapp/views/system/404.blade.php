@extends('l.base')

@section('title')
404
@parent
@stop

@section('container')
    <h1>404</h1>
    <p>抱歉，您访问的页面不存在。</p>
    <a href="javascript:history.back()">Back</a>
@stop