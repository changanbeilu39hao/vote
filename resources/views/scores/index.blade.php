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
			<span>初选平台</span>
			<span class="nav_cur">评分平台</span>
		</div>
		
		<div class="main">
			

			<!--评分平台-->
			<div class="chuxuan ">
				<hr class="pingfen_line" />
				<!--作品-->
				<div class="zuopin">
					<a href="#" class="prev1">上一页</a>
					<a href="#" class="next1">下一页</a>
					<div class="zuopin_main">
{{--             
                        @foreach ($works as $item)
						<div class="zuopin_item pinfen_item">
							<div class="zuopin_item_img">
								<img src="{{ $item['samllImage'] }}" />
								<a href="#" class="details">查看详情</a>
								<span class="scoreShow">90</span>
							</div>
							<div class="zuopin_item_img_bot">
								<p >{{ $item['code'] }}</p>
								<form action="#" method="post">
									<input type="number" name="score" placeholder="0-80分" required/>
									<input type="submit" class="postScore" value="确定"/>
								</form>
							</div>
                        </div>
                        @endforeach --}}
					
						
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
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif

<script type="text/javascript" src="images/jquery-3.5.1.min.js" ></script>
<script type="text/javascript" src="images/pagination.min.js" ></script>
<script type="text/javascript" src="images/index.js" ></script>

<script>


</script>