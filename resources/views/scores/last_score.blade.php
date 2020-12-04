<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>作品评分</title>
		<link rel="stylesheet" type="text/css" href="images/index.css"/>
		<link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

		<script type="text/javascript" src="images/jquery-3.5.1.min.js" ></script>
		<script type="text/javascript" src="js/layer/layer.js" ></script>
		<script type="text/javascript" src="images/pagination.min.js" ></script>
		<script type="text/javascript" src="images/index.js" ></script>
		<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
				<select id="group_c" style="background: rgb(121, 100, 237)">
					<option id="group1" value="1" >小学1-3年级组</option>
					<option id="group2" value="2">小学4-6年级组</option>
					<option id="group3" value="3">初中组</option>
				</select>
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
			<span class="nav_cur">评分平台</span>
		</div>
		
		<div class="main">
			

			<!--评分平台-->
			<div class="chuxuan ">
				<hr class="pingfen_line" />

				<div class="btn " style="float: left; margin: 20px 0 0 80px;">
					<a href="/last_score?status=0&group_id={{$group_id}}"><span class="r_cur" id="not_checked"   style="color: white;background:#BE0D0D">未评分</span></a> 
					<a href="/last_score?status=1&group_id={{$group_id}}"><span  class="r_cur" id="is_checked" style="color: white;background:#BE0D0D" >已评分</span></a>
				</div>
				
				<div class="btn" style="float: right; margin: 20px 0;">
					{{-- <span class = "btn_over" onclick="submitScore()">确认评审完毕</span> --}}
					{{-- <span class = "btn_lock">查看评审结果</span> --}}
				</div>
				<!--作品-->
				<div class="zuopin">
					{{-- <a href="@if($page == 1) # @else{{ $pre_url }} @endif" class="prev1">上一页</a> --}}
					@if ($status == 0)
					<a href="/last_score?status=0&group_id={{$group_id}}" class="next1">下一页</a>
					@endif
					
					<div class="zuopin_main">
            
                        @foreach ($works as $item)
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img data-src="{{ 'https://aqjy.newssc.org'.$item->SamllImage }}" />
								<a target="_blank" href="{{ route('score.detail',['id'=>$item->WorkId]) }}" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >{{ $item->WorkId }}</p>
								<div style="float: right;display: inline;">
									<input type="number" name="score" placeholder="@if($item->a != null) {{$item->a}} @else 0-80  @endif" required />
									<input type="submit" class="postScore pingfen" value="确定"/>
									<input id="item_id" type="hidden" value="{{ $item->WorkId }}" >
								</div>
							</div>
                        </div>
                        @endforeach
					
						
					</div>
				</div>				
				
				<!--分页-->
				{{ $works->appends(['status' => $status, 'group_id' => $group_id])->links() }}
				
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

function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}
$(function(){
	$('#group_c').on('change',function(){
			var selectId = $('#group_c option:selected');
			if(selectId.val()==1){
				$(window).attr('location', "?group_id=1");
			}else if(selectId.val()==2){
				$(window).attr('location', "?group_id=2");
	　　　　 }else if(selectId.val()==3){
				$(window).attr('location', "?group_id=3");
			}
		});

		

	var l = getUrlParam('group_id');

	if (l == 1){
		$('#group1').attr("selected",true);
	}
	if (l == 2){
		$('#group2').attr("selected",true);
	}
	if (l == 3){
		$('#group3').attr("selected",true);
	}


	$("nav").css('text-align', 'center')
	ArrPic();
});
function ArrPic()
{
	
	var leng=$("div.zuopin_main").find("div.zuopin_item").length;
	for(var i=0;i<leng;i++)
	{
		var arr_img=$("div.zuopin_main").find("div.zuopin_item").eq(i).find("img").data("src");
		$("div.zuopin_main").find("div.zuopin_item").eq(i).find("img").attr("src",arr_img.split(',')[0]);
	}
}
// submitScore = function (){

// 	var con = confirm('你确认提交吗?提交后将不可更改。');
// 	if (con == true) {
// 		$.ajax({
//             type: "POST",
//             url: "{{ url('/score/confirm') }}",
//             dataType: 'json',
// 			headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         	},
//             data: {
// 				confirm_score:1
//             },
//             success: function (data) {
//                	if(data == 200){
// 					   alert('确认成功 ！')
// 				   }
// 				if(data == 201){
// 					   alert('评分未完成！')
// 				   }
// 				}
// 			})
// 		} 
// 	}


function getUrlParam(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
		var r = window.location.search.substr(1).match(reg);  //匹配目标参数
		if (r != null) return unescape(r[2]); return null; //返回参数值
}



		$(".pingfen").on("click",function(){

			var _id=$(this).next().val();
			var _score =$(this).prev().val();
			if (_score<0||_score>80){
				return layer.msg('请输入0-80的数字');
			}
			$.ajax({
				type: "POST",
				url: "{{ url('/last_score') }}",
				dataType: 'json',
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					id:_id,
					score:_score,
					group_id:{{ $group_id }},
				},
				success: function (data) {
					if(data == 200){
						layer.msg("评分成功！",{time:2000});
					}
					if(data == 201){
					layer.msg("请输入整数或最多保留两位小数！",{time:2000});
					}
					}
				});

		});

</script>