<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>作品评分</title>
		<link rel="stylesheet" type="text/css" href="images/index.css"/>
		<script type="text/javascript" src="images/jquery-3.5.1.min.js" ></script>
		<script type="text/javascript" src="js/layer/layer.js" ></script>
		<script type="text/javascript" src="images/pagination.min.js" ></script>
		<script type="text/javascript" src="images/index.js" ></script>
	</head>
	<body>
		<!--顶部-->
		<div class="top"> 
			<p>四川森林草原防灭火安全教育手抄报征集活动初选平台&评分平台</p>
			<div class="top_r">
                @guest
                <span>未登录</span>
                @else    
                <span>
                    @switch(Auth::user()->group_id)
                    @case(1)
                    小学1-3年级组
                    @break
                    @case(2)
                    小学4-6年级组
                    @break

                    @case(3)
                    初中组
                    @break
                    
                    @default
                        
                @endswitch
            </span>
                <span>{{ Auth::user()->name }}</span>
				<a href="{{ route('logout') }}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">退出登录</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>
                @endguest   

			</div>
		</div>
		
		<!--导航-->
		<div class="nav">
			<span> <a style="color:#BE0D0D" href="{{ route('check.pre') }}">初选平台</a></span>
			<span class="nav_cur">评分平台</span>
		</div>
		
		<div class="main">
			

			<!--评分平台-->
			<div class="chuxuan ">
				<hr class="pingfen_line" />

				<div class="btn " style="float: left; margin: 20px 0 0 80px;">
					<span class="r_cur" id="not_checked" @if($scored_status == 0)  style="color: white;background:#BE0D0D" @endif>未评分</span>
					<span  class="r_cur" id="is_checked" @if($scored_status == 1)  style="color: white;background:#BE0D0D" @endif>已评分</span>
				</div>
				
				<div class="btn" style="float: right; margin: 20px 0;">
					<span class = "btn_over" onclick="submitScore()">确认评审完毕</span>
					{{-- <span class = "btn_lock">查看评审结果</span> --}}
				</div>
				<!--作品-->
				<div class="zuopin">
					<a href="@if($page == 1) # @else{{ $pre_url }} @endif" class="prev1">上一页</a>
					<a href="@if($page == $total_page) # @else{{ $next_url }} @endif" class="next1">下一页</a>
					<div class="zuopin_main">
            
                        @foreach ($works as $item)
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="{{ $item['samllImage'] }}" />
								<a target="_blank" href="{{ route('score.detail',['id'=>$item['id']]) }}" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >{{ $item['id'] }}</p>
								<div style="float: right;display: inline;">
									<input type="number" name="score" placeholder="@if($item['score']==-1)0-80分 @else{{ $item['score'] }} @endif" required />
									<input type="submit" class="postScore pingfen" value="确定"/>
									<input id="item_id" type="hidden" value="{{ $item['id'] }}" >
								</div>
							</div>
                        </div>
                        @endforeach
					
						
					</div>
				</div>				
				
				<!--分页-->
				<div id="fyq">

				</div>
				
			</div>
			
		</div>
		<div id="Pagination" class="meneame">
		</div>
	</body>
</html>
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif



<script>
	$('#fyq').pagination({
    
	dataSource: function(done){
	var result = [];
	for (var i = 1; i <= {{ $total }}; i++) {
		result.push(i);
	}
	done(result);
},
pageSize:4,
pageNumber:{{ $page }},
showPrevious: false,
showNext: false,
});

submitScore = function (){

	var con = confirm('你确认提交吗?提交后将不可更改。');
	if (con == true) {
		$.ajax({
            type: "POST",
            url: "{{ url('/score/confirm') }}",
            dataType: 'json',
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
            data: {
				confirm_score:1
            },
            success: function (data) {
               	if(data == 200){
					   alert('确认成功 ！')
				   }
				if(data == 201){
					   alert('评分未完成！')
				   }
				}
			})
		} 
		;	

	}


function getUrlParam(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
		var r = window.location.search.substr(1).match(reg);  //匹配目标参数
		if (r != null) return unescape(r[2]); return null; //返回参数值
}

$(function() {
	$(".J-paginationjs-page").click(function(){
			var a = $(this).attr('data-num');
			var s = getUrlParam('scored_status');
            $(window).attr('location', "{{ $r_url }}?size=4&scored_status="+s+"&page="+a+"");
		});

	$(".J-paginationjs-page.active").css("background", "red");

	var to_page ="<div class='paginationjs-go-input'><input id='to_page' type='text' name='page'></div>"
	var to_button = "<button class='paginationjs-go-button' type='submit'>确定</button>"
	if({{ $total_page }} > 5) {
		$(".paginationjs-pages").append(to_page);
		$(".paginationjs-pages").append(to_button);
		$(".paginationjs-go-button").on("click", function(){
		var l = getUrlParam('scored_status');
		var a = $("#to_page").val();
		$(window).attr('location', "{{ $r_url }}?size=4&page="+a+"&scored_status="+l+"");
	})

	}

		
	$("#is_checked").click(function(){
			$(window).attr('location', "{{ $r_url }}?size=4&page=1&scored_status=1");
		})

		$("#not_checked").click(function(){
			$(window).attr('location', "{{ $r_url }}?size=4&page=1&scored_status=0");
		})

		$(".pingfen").on("click",function(){
		var _id=$(this).next().val();
		var _score =$(this).prev().val();
		if (_score<0||_score>80){
			return layer.msg('请输入0-80的数字');
		}
		$.ajax({
            type: "POST",
            url: "{{ url('/score') }}",
            dataType: 'json',
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
            data: {
				id:_id,
				score:_score
            },
            success: function (data) {
               	if(data == 200){
					layer.msg("评分成功！",{time:2000});
				   }
				if(data == 201){
				layer.msg("请输入整数或最多保留两位小数！",{time:2000});
				}
				}
			})
		});	


})



</script>