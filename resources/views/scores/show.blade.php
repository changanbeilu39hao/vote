<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>评审结果</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/result.css') }}"/>
				<link rel="stylesheet" type="text/css" href="{{ asset('images/iconfont.css') }}"/>
		<script type="text/javascript" src="{{ asset('images/jquery-3.5.1.min.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('images/result.js') }}" ></script>
	</head>
	<body>
		<!--顶部-->
		<div class="top">
			<p>四川森林草原防灭火安全教育手抄报征集活动评审结果</p>
			<div class="top_right">
                <span>{{ Auth::user()->name }}</span>
				<a href="{{ route('logout') }}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">退出登录</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</div>
		</div>
				
					
		<!--提示消息-->
		<div class="hint">
			<p>提示：</p>
			<span>1.最终得分 =（总分 - 最高分 - 最低分）/ 5</span>
			<span>2.每组得分排前1000名的作品进入网络投票环节</span>
		</div>
		
		<!--导航-->
		<div class="nav">
            <a href="{{ route('score.show',['group_id'=>1]) }}"><span id="x1">小学1-3年级组</span></a>
            <a href="{{ route('score.show',['group_id'=>2]) }}"><span id="x4">小学4-6年级组</span></a>
            <a href="{{ route('score.show',['group_id'=>3]) }}"><span id="cz">初中组</span></a>
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
				@if (Auth::user()->group_id ==4 )
				<li>终审1</li>
                <li>终审2</li>
				<li>终审3</li>
				@endif
			</ul>
		</div>
		
		<!--得分详情-->
		<div class="scoreDetails">
			
			<ul class="scoreDetails_lists">
                <!--分数行--> 
                @foreach ($d as $k=>$v)    

				<li class="scoreDetails_list">
					<span class="rank"></span>
					<span class="number"><a href="{{ route('score.detail',['id'=>$v['item_id']]) }}" target="_blank">{{ $v['item_id'] }}</a></span>
					<span class="score">{{ $v['z1'] }}</span>
					<span class="score">{{ $v['z2'] }}</span>
					<span class="score">{{ $v['z3'] }}</span>
					<span class="score">{{ $v['z10'] }}</span>
					<span class="score">{{ $v['z11'] }}</span>
					<span class="score">{{ $v['z12'] }}</span>
					<span class="score">{{ $v['z13'] }}</span>
					<span class="last_score">{{ $v['last_score'] }}</span>

				@if (Auth::user()->group_id ==4 )

				@if (Auth::user()->id == 30)
					<span class="yes_or_no  isclick" >
						<!--当前用户会有两各按钮-->
						<i class="iconfont icon-duigou @if($v['status'] == 1)yn_cur2  @endif"></i>
						<i class="iconfont icon-cuo @if($v['status'] == 2)yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v['status2'] == 1)yn_cur2 icon-duigou @endif @if($v['status2'] == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v['status3'] == 1)yn_cur2 icon-duigou @endif @if($v['status3'] == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					
					@endif

					@if (Auth::user()->id == 31)
					<span class="yes_or_no">
						<i class="iconfont @if($v['status2']== 1)yn_cur2 icon-duigou @endif @if($v['status2'] == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no  isclick" >
						<!--当前用户会有两各按钮-->
						<i class="iconfont icon-duigou @if($v['status']  == 1)yn_cur2 @endif"></i>
						<i class="iconfont icon-cuo @if($v['status']  == 2)yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v['status3'] == 1)yn_cur2 icon-duigou @endif @if($v['status3'] == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					
					@endif

					@if (Auth::user()->id == 32)
					<span class="yes_or_no">
						<i class="iconfont @if($v['status2'] == 1)yn_cur2 icon-duigou @endif @if($v['status2'] == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no">
						<i class="iconfont @if($v['status3']  == 1)yn_cur2 icon-duigou @endif @if($v['status3']  == 2)icon-cuo yn_cur1 @endif"></i>
					</span>
					<span class="yes_or_no  isclick" >
						<!--当前用户会有两各按钮-->
						<i class="iconfont icon-duigou @if($v['status'] == 1)yn_cur2 @endif"></i>
						<i class="iconfont icon-cuo @if($v['status'] == 2)yn_cur1 @endif"></i>
					</span>
					@endif

				@endif	
					
				</li>
                @endforeach
                
			</ul>
		</div>
		<br><br><br><br>

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
            $("#zj1").text('zhuanjia05')
            $("#zj2").text('zhuanjia06')
            $("#zj3").text('zhuanjia14')
            $("#zj4").text('zhuanjia15')
            $("#zj5").text('zhuanjia16')
            $("#zj6").text('zhuanjia17')
			$("#zj7").text('zhuanjia33')
        }
        if (l==3){
            $("#cz").addClass('navcur');
            $("#zj1").text('zhuanjia07')
            $("#zj2").text('zhuanjia08')
            $("#zj3").text('zhuanjia09')
            $("#zj4").text('zhuanjia18')
            $("#zj5").text('zhuanjia19')
            $("#zj6").text('zhuanjia20')
            $("#zj7").text('zhuanjia21')
		}
		
	})
	
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
			var cuo_num =0
			for(var i= 0;  i < $(this).parent().siblings('.yes_or_no').length; i++ ){
				if(  $(this).parent().siblings('.yes_or_no').eq(i).find('i').hasClass('icon-cuo')){
					cuo_num ++
				}
			}
			//如果三个不通过，则排到最后
			if(cuo_num == 2){
				var copyLi = $(this).parents('li')
				$('.scoreDetails_lists').append(copyLi)
				addRank()
			}
		}
	})
	
	addRank()
	function addRank(){
		var rank = document.querySelectorAll(".rank")
		for(var i = 0; i < rank.length; i++){
			//遍历排名序号
			rank[i].innerText = i+1
			var rank_num = parseInt( rank[i].innerText )
			//前1000名添加背景
			if( rank_num <= 1000 && !rank[i].parentNode.classList.contains('BgColor') ){
				rank[i].parentNode.className += " BgColor"
				rank[i].className += " blodFont"
			}
		}
	}

	sortBycha()

	function sortBycha(){
	var hasCuo_num = 0
	var scoreDetails_list = $('.scoreDetails_list')
	for(var li_i = 0; li_i < scoreDetails_list.length; li_i++ ){
	var yes_or_no = scoreDetails_list.eq(li_i).find('.yes_or_no')
	for(var cuo_i = 0; cuo_i < yes_or_no.length; cuo_i++){
		yes_or_no.eq(cuo_i).find('i').each(function(index,el){
		//检测 勾叉 按钮是否有 yn_cur1 的calss
		if($(el).hasClass('yn_cur1')){
		hasCuo_num++
		}
		})
	}
	if(hasCuo_num == 3){
		var copyLi = scoreDetails_list.eq(li_i)
		$('.scoreDetails_lists').append(copyLi)
		addRank()
	}
	hasCuo_num = 0
	}
	}
</script>
</html>
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif