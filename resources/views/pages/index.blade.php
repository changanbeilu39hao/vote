<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>筛选和评分</title>
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
			<span>评分平台</span>
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
							<p class="threeStar">0</p>
						</div>
						<div class="tongji_bot_item">
							<span>二星作品</span>
							<p>0</p>
						</div>
						<div class="tongji_bot_item">
							<span>一星作品</span>
							<p>0</p>
						</div>
					</div>			
				</div>
				
				<!--筛选-->
				<div class="shaixuan">
					<div class="shaixuan_l">
						<from>
							<input type="text" name="id" placeholder="作品编号"  />
							<input type="submit" value="搜索" />
						</from>
						<span class="shaixuancur" title="表示有三个人通过的作品">三星作品</span>
						<span title="表示有二个人通过的作品">二星作品</span>
						<span title="表示有一个人通过的作品">一星作品</span>
					</div>
					
					<div class="shaixuan_r">我已选作品: <span>0</span></div>
				</div>
				
				<!--作品-->
				<div class="zuopin">
					<a href="#" class="prev1">上一页</a>
					<a href="#" class="next1">下一页</a>
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
							<p class="zuopin_id">{{ $item['code'] }}</p>
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
				
				<!--分页-->
				<div class="page page1">
					{{-- <a href="#" class="prev">上一页</a>
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
						<span>确定</span> --}}
					{{-- </div> --}}
				</div>

				<div id="fyq" class="paginationjs-theme-blue">

				</div>
			</div>
			
			<!--评分平台-->
			<div class="chuxuan">
				<hr class="pingfen_line" />
				<!--作品-->
				<div class="zuopin">
					<a href="#" class="prev1">上一页</a>
					<a href="#" class="next1">下一页</a>
					<div class="zuopin_main">
			
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="images/img1.jpg" />
								<a href="#" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >0000000</p>
								<form action="#" method="post">
									<input type="number" name="score" placeholder="0-80分" required/>
									<input type="submit" class="postScore" value="确定"/>
								</form>
							</div>
						</div>
						
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="images/img1.jpg" />
								<a href="#" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >0000000</p>
								<form action="#" method="post">
									<input type="number" name="score" max="80" min="0" placeholder="0-80分"  required/>
									<input type="submit" class="postScore" value="确定"/>
								</form>
							</div>
						</div>
						
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="images/img1.jpg" />
								<a href="#" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >0000000</p>
								<form action="#" method="post">
									<input type="number" name="score" placeholder="0-80分" required/>
									<input type="submit" class="postScore" value="确定"/>
								</form>
							</div>
						</div>
						
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="images/img1.jpg" />
								<a href="#" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >0000000</p>
								<form action="#" method="post">
									<input type="number" name="score" placeholder="0-80分" required/>
									<input type="submit" class="postScore" value="确定"/>
								</form>
							</div>
						</div>
						
						
						
					</div>
				</div>				
				
				<!--分页-->
				<div class="page page2">
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
					</div>
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


<script type="text/javascript" src="images/jquery-3.5.1.min.js" ></script>
<script type="text/javascript" src="images/pagination.min.js" ></script>
<script type="text/javascript" src="images/index.js" ></script>

<script>
	$('#fyq').pagination({
    
		dataSource: function(done){
		var result = [];
		for (var i = 1; i < {{ $total }}; i++) {
			result.push(i);
		}
		done(result);
 },
	pageSize:4,
	pageNumber:{{ $page }},
    showPrevious: true,
	showNext: true,
	// showGoInput: true,
    // showGoButton: true,
});
$(function(){
        $(".J-paginationjs-page").click(function(){
			var a = $(this).attr('data-num');
            $(window).attr('location', "http://vote.test/pre?size=4&page="+a+"");
		});

	});
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
                console.log(data)
            },
        });


	})


</script>