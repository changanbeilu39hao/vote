@extends('layouts.app')

@section('content')

@if ( Session::get('totle_'.Auth::user()->id) == 1 )
<form action="{{ route('check.confirm') }}" method="POST"  onsubmit="return validator()";>
    @csrf
    
    <div class="alert alert-success">
        <p>由于您已全部审查完作品，请确认结果</p>
        <button class="btn-success" type="submit">确认结果</button>
    </div>
</form>

<form action="{{ route('check.store') }}" method="POST">
    @csrf
    
<div class="jumbotron ml-4 mr-4">


    @endif
    <div class="row">
    @foreach ($data as $v)
    <input type="hidden" name="all_ids[]" value="{{ $v->id }}">
    <input type="hidden" name="page" value="@if($data->lastPage()==$data->currentPage()) {{$data->url($data->currentPage())}} @else {{$data->nextPageUrl()}} @endif ">
        <div class="col-xs-6 col-md-3 pl-5">
            <a href="#" class="thumbnail">
            <img src="{{ $v->url }}" alt="..." width="150px">
            </a><br>
            <input type="checkbox" name="work_ids[]" value="{{ $v->id }}" @if(in_array($v->id, $ids))checked @endif>
        </div>
    @endforeach
    </div>

    <div class="col-md-11 mt-4" style="text-align: center">
        <button type="submit" class="btn-info ">确认</button>
    </div>  

    <div class="col-md-11 mt-5" style="text-align: center">{{ $data->links() }}</div>
    
</div>
</form>
@stop

<script language="Javascript">
    function validator()
    {
        if(confirm("确认要执行此操作吗？")==true)
            return true;
        else
            return false;
    }
</script>