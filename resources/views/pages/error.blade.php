@extends('layouts.app')
@section('title', '错误')

@section('content')
<div class="card">
    <div class="card-header">提示</div>
    <div class="card-body text-center">
        <h1>{{ $msg }}</h1>
        <a style="color: white" href="{{ route('check.pre') }}"><button class="btn btn-success">返回初选平台</button></a>
        <a style="color: white" href="{{ route('score.index') }}"><button class="btn btn-danger">评分平台</button></a>
        <a style="color: white" href="{{ route('score.show') }}"><button class="btn btn-danger">结果公示</button></a>
    </div>
</div>
@endsection