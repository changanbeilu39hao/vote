@extends('layouts.app')
@section('title', '错误')

@section('content')
<div class="card">
    <div class="card-header">错误</div>
    <div class="card-body text-center">
        <h1>{{ $msg }}</h1>
        <button class="btn btn-danger"><a>评分平台</a></button>
    </div>
</div>
@endsection