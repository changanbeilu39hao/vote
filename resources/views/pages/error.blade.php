@extends('layouts.app')
@section('title', '错误')

@section('content')
<div class="card">
    <div class="card-header">提示</div>
    <div class="card-body text-center">
        <h1>{{ $msg }}</h1>
        <button class="btn btn-danger"><a style="color: white" href="{{ route('score.index') }}">评分平台</a></button>
        <button class="btn btn-danger"><a>公示页面</a></button>
    </div>
</div>
@endsection