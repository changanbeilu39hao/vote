<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>作品初选</title>
		<link rel="stylesheet" type="text/css" href="images/index.css"/>
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
			<span class="nav_cur">初选平台</span>
			<a style="color:#BE0D0D" href="{{ route('score.index') }}"><span >评分平台</span> </a>
		</div>
		
		<div class="main">
			
			<!--初选平台-->
			<div class="chuxuan">
				<!--统计-->
				<div class="tongji">
					<div class="tongji_top">
						<span>初选结果</span>
						<button class="push">评审组长确认提交</button>
					</div>
					
					<div class="tongji_bot">
						
						<div class="tongji_bot_item">
							<span>三星作品</span>
							<p class="threeStar">{{ $works_num['level_3'] }}</p>
						</div>
						<div class="tongji_bot_item">
							<span>二星作品</span>
							<p>{{ $works_num['level_2'] }}</p>
						</div>
						<div class="tongji_bot_item">
							<span>一星作品</span>
							<p>{{ $works_num['level_1'] }}</p>
						</div>
					</div>			
				</div>
				
				<!--筛选-->
				<div class="shaixuan">
					<div class="shaixuan_l">
						<form action="{{ route('check.prev') }}" method="post">
							{{ csrf_field() }}
							<input type="text" name="search_id" placeholder="作品编号"  />
							<input type="submit" value="搜索" />
						</form>

						<span id="all_c" ><a  href="{{ route('check.pre') }}">全部作品</a></span>
						<a  href="{{ route('check.pre') }}?level=3&page=1&size=4"><span id="sanxing_c" title="表示有三个人通过的作品">三星作品</span></a>
						<a  href="{{ route('check.pre') }}?level=2&page=1&size=4"><span id="erxing_c" title="表示有二个人通过的作品">二星作品</span></a>
						<a  href="{{ route('check.pre') }}?level=1&page=1&size=4"><span id="yixing_c" title="表示有一个人通过的作品">一星作品</span></a>
					</div>
					
					<div class="shaixuan_r">我已选作品: <span>{{ Session::get('user_count_'.Auth::user()->id) }}</span></div>
				</div>
				
				<!--作品-->
				<div class="zuopin">
					<a href="@if($page == 1) # @else{{ $pre_url }} @endif" class="prev1">上一页</a>
					<a href="@if($page == $total_page) # @else{{ $next_url }} @endif" class="next1">下一页</a>
					<div class="zuopin_main" id="WorkdList">
						
						<!--img 中的 rel 属性为原始图片的地址-->
						@foreach ($works as $item)
						<div class="zuopin_item">
							<div class="zuopin_item_img">
								<img src="{{ $item['samllImage'] }}" data-rel = "{{ $item['bigImage'] }}" />
								<input type="hidde" name="work_id" value="{{ $item['id'] }}">
								<span class="star @if ($item['status'] ==1 )star_fill @endif" data-id="{{ $item['id'] }}"></span>
								<span class="realImg">查看原图</span>
							</div>
							<p class="zuopin_id">{{ $item['id'] }}</p>
						</div>
						@endforeach
						{{-- <div class="zuopin_item">
							<div class="zuopin_item_img">
								<img src="images/img1.jpg" data-rel = "images/relimg01.jpg" />
								<span class="star"></span>
								<span class="realImg">查看原图</span>
							</div>
							<p class="zuopin_id">0000000</p>
						</div> --}}				
					</div>
				</div>				
				


				<div id="fyq" >

				</div>
	
			</div>
			
			
		</div>
		<div id="Pagination" class="meneame">
		</div>


		<div class="showImg">
			<img src="images/img1.jpg"/>
		</div>
	</body>
</html>
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif

<script type="text/javascript" src="images/jquery-3.5.1.min.js" ></script>
<script type="text/javascript" src="images/pagination.min.js" ></script>
<script type="text/javascript" src="images/index.js" ></script>

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


function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return null; //返回参数值
}

$(function(){
	var l = getUrlParam('level');
	if (l==3) {
		$("#sanxing_c").addClass('shaixuancur');
	}
	if (l==2) {
		$("#erxing_c").addClass('shaixuancur');
	}
	if (l==1) {
		$("#yixing_c").addClass('shaixuancur');
	}
	if (l==null) {
		$("#all_c").addClass('shaixuancur');
	}
        $(".J-paginationjs-page").click(function(){
			var a = $(this).attr('data-num');
			var l = getUrlParam('level');
			console.log(l);
            $(window).attr('location', "{{ $r_url }}?size=4&page="+a+"&group={{ Auth::user()->group_id }}&level="+l+"");
		});
		$(".J-paginationjs-page.active").css("background", "red");

	});

	var to_page ="<div class='paginationjs-go-input'><input id='to_page' type='text' name='page'></div>"
	var to_button = "<button class='paginationjs-go-button' type='submit'>确定</button>"
	if({{ $total }} > 5) {
		$(".paginationjs-pages").append(to_page);
		$(".paginationjs-pages").append(to_button);
		$(".paginationjs-go-button").on("click", function(){
		var l = getUrlParam('level');
		var a = $("#to_page").val();
		$(window).attr('location', "{{ $r_url }}?size=4&page="+a+"&group={{ Auth::user()->group_id }}&level="+l+"");
	})

	}



	$("#WorkdList").on("click","span.star",function(){
		var _id=$(this).data("id");

		$.ajax({
            type: "POST",
            url: "{{ url('/pre/store') }}",
            dataType: 'json',
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
            data: {
                id:_id,
            },
            success: function (data) {
               	return 200
				}
			})
		});


	$(".push").on("click",function(){
		$.ajax({
            type: "POST",
            url: "{{ url('/pre/confirm') }}",
            dataType: 'json',
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
            data: {
                user_id: {{  Auth::user()->id }},
            },
            success: function (data) {
				if(data == 201){
					alert('请确认此组三星作品为2000件！')
				}
				if(data == 202){
					alert('请评审组长确认提交！');

            	}
				if(data == 200){
					alert('作品确认成功 ！');
					$(window).attr('location', "{{ $r_url }}");
            	}
        }})
	})


</script>