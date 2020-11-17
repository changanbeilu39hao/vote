<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>评审结果</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/result.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/iconfont.css') }}"/>
        <script type="text/javascript" src="{{ asset('images/result.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('images/jquery-3.5.1.min.js') }}" ></script>
	</head>
	<body>
		<!--顶部-->
		<div class="top">四川森林草原防灭火安全教育手抄报征集活动评审结果</div>
					
		<!--提示消息-->
		<div class="hint">
			<p>提示：</p>
			<span>1.最终得分 =（总分 - 最高分 - 最低分）/ 7</span>
			<span>2.每组得分排前1000名的作品进入网络投票环节</span>
		</div>
		
		<!--导航-->
		<div class="nav">
            <a href="{{ route('score.last',['group_id'=>1]) }}"><span id="x1">小学1-3年级组</span></a>
            <a href="{{ route('score.last',['group_id'=>2]) }}"><span id="x4">小学4-6年级组</span></a>
            <a href="{{ route('score.last',['group_id'=>3]) }}"><span id="cz">初中组</span></a>
		</div>
        
       
		<!--表头-->
		<div class="t_head">
			<ul class="t_head_lists">
				<li class="t_head_rank">排名</li>
				<li>作品编号</li>
				<li id="zj1">zhuanjia01</li>
				<li id="zj2">zhuanjia02</li>
				<li id="zj3">zhuanjia03</li>
				<li id="zj4">zhuanjia10</li>
				<li id="zj5">zhuanjia11</li>
				<li id="zj6">zhuanjia12</li>
				<li id="zj7">zhuanjia13</li>
                <li class="t_head_lastSroce">最终得分</li>
                <li>终审1</li>
                <li>终审2</li>
                <li>终审3</li>
			</ul>
		</div>
		
		<!--得分详情-->
		<div class="scoreDetails">
			
			<ul class="scoreDetails_lists">
                <!--分数行--> 
                @foreach ($data as $k=>$v)    

				<li class="scoreDetails_list">
					<span class="rank">{{ $k+1 }}</span>
					<span class="number"><a href="{{ route('score.detail',['id'=>$v->item_id]) }}" target="_blank">{{ $v->item_id }}</a></span>
					<span class="score">{{ $v->z1 }}</span>
					<span class="score">{{ $v->z2 }}</span>
					<span class="score">{{ $v->z3 }}</span>
					<span class="score">{{ $v->z4 }}</span>
					<span class="score">{{ $v->z5 }}</span>
					<span class="score">{{ $v->z6 }}</span>
					<span class="score">{{ $v->z7 }}</span>
					<span class="last_score">{{ $v->last_score }}</span>
					
					@if (Auth::user()->id == 30)
						<span class="yes_or_no  isclick" >
							<!--当前用户会有两各按钮-->
							<i class="iconfont icon-duigou @if($v->status == 1)yn_cur2 @endif"></i>
							<i class="iconfont icon-cuo @if($v->status == 2)yn_cur1 @endif"></i>
						</span>
						<span class="yes_or_no">
							<i class="iconfont @if($v->status2 == 1)icon-duigou @endif @if($v->status2 == 2)icon-cuo @endif"></i>
						</span>
						<span class="yes_or_no">
							<i class="iconfont @if($v->status3 == 1)icon-duigou @endif @if($v->status3 == 2)icon-cuo @endif"></i>
						</span>
						
					@endif

					@if (Auth::user()->id == 31)
					<span class="yes_or_no">
						<i class="iconfont @if($v->status2 == 1)icon-duigou @endif @if($v->status2 == 2)icon-cuo @endif"></i>
					</span>
					<span class="yes_or_no  isclick" >
						<!--当前用户会有两各按钮-->
						<i class="iconfont icon-duigou @if($v->status == 1)yn_cur2 @endif"></i>
						<i class="iconfont icon-cuo @if($v->status == 2)yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v->status3 == 1)icon-duigou @endif @if($v->status3 == 2)icon-cuo @endif"></i>
					</span>
					
					@endif

					@if (Auth::user()->id == 32)
					<span class="yes_or_no">
						<i class="iconfont @if($v->status2 == 1)icon-duigou @endif @if($v->status2 == 2)icon-cuo @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v->status3 == 1)icon-duigou @endif @if($v->status3 == 2)icon-cuo @endif"></i>
					</span>
					<span class="yes_or_no  isclick" >
						<!--当前用户会有两各按钮-->
						<i class="iconfont icon-duigou @if($v->status == 1)yn_cur2 @endif"></i>
						<i class="iconfont icon-cuo @if($v->status == 2)yn_cur1 @endif"></i>
					</span>
					@endif


                    {{-- <span class="yes_or_no">
                        <i class="iconfont icon-duigou"></i>
                    </span>
                    <span class="yes_or_no  isclick" >
                        <!--当前用户会有两各按钮-->
                        <i class="iconfont icon-duigou @if($v->status == 1)yn_cur2 @endif"></i>
                        <i class="iconfont icon-cuo @if($v->status == 2)yn_cur1 @endif"></i>
                    </span>
                    <span class="yes_or_no">
                        <i class="iconfont icon-cuo"></i>
                    </span> --}}
                    
				</li>
                @endforeach
                
			</ul>
		</div>
		<br><br><br><br>

		
		<!--分页-->
		{{-- <div class="page page2">
			<a href="#" class="prev">上一页</a>
			<a href="#" class="pagecur">1</a>
			<a href="#">2</a>
			<a href="#">3</a>
			<a href="#">4</a>
			<a href="#">5</a>
			<a href="#">6</a>
			<a href="#">7</a>
			<a href="#">8</a>
			<a>...</a>
			<a href="#">200</a>
			<a href="#" class="next">上一页</a>
			<div class="topage">
				到
				<input type="text" />
				页
				<span>确定</span>
        </div> --}}
        <div class="empty"></div>
    </body>
<script>
    function getUrlParam(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
		var r = window.location.search.substr(1).match(reg);  //匹配目标参数
		if (r != null) return unescape(r[2]); return null; //返回参数值
    }
    $(function () {
        var l =getUrlParam('group_id')
        console.log(l)
        if (l==1 || l==null){
            $("#x1").addClass('navcur');
        }
        if (l==2){
            $("#x4").addClass('navcur');
            $("#zj1").text('zhuanjia4')
            $("#zj2").text('zhuanjia5')
            $("#zj3").text('zhuanjia6')
            $("#zj4").text('zhuanjia14')
            $("#zj5").text('zhuanjia15')
            $("#zj6").text('zhuanjia16')
            $("#zj7").text('zhuanjia17')
        }
        if (l==3){
            $("#cz").addClass('navcur');
            $("#zj1").text('zhuanjia7')
            $("#zj2").text('zhuanjia8')
            $("#zj3").text('zhuanjia9')
            $("#zj4").text('zhuanjia18')
            $("#zj5").text('zhuanjia19')
            $("#zj6").text('zhuanjia20')
            $("#zj7").text('zhuanjia21')
        }
	})
	
	//通过或者不通过
	$('.isclick i').click(function(){
		if($(this).index() == 0){

			$.ajax({
				type: "POST",
				url: "{{ url('/score/last_score_choose') }}",
				dataType: 'json',
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					status:1,
					user_id:{{ Auth::user()->id }},
					item_id:$(this).parent().siblings('.number').text(),   
				},
				success: function () {
					console.log(200)
					}
				})
			$(this).addClass('yn_cur2').siblings('i').removeClass('yn_cur1')
		}else{
			$.ajax({
				type: "POST",
				url: "{{ url('/score/last_score_choose') }}",
				dataType: 'json',
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					status:2,
					user_id:{{ Auth::user()->id }},
					item_id:$(this).parent().siblings('.number').text(),   
				},
				success: function () {
					console.log(200)
					}
				})
			$(this).addClass('yn_cur1').siblings('i').removeClass('yn_cur2')
		}
	})
</script>
</html>
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif