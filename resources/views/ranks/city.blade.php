<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>市州排名</title>
		<link rel="stylesheet" type="text/css" href="{{ asset("images/rank_city.css") }}"/>
		<script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	</head>
	<body>
		<!--顶部-->
		<div class="top">
			<p>四川森林草原防灭火安全教育手抄报征集活动市州积分排名</p>
		</div>
					
		<!--提示消息-->
		<div class="hint">
			<div class="hint_text">
				<p>提示：</p><br />
				<span>1.投稿量积分 = 投稿数量 x 0.1</span><br />
				<span>2.获奖积分 = 一等奖数量 x 20 + 二等奖数量 x 10 + 三等奖数量 x 5</span>
				<span>3.总分 = 投稿量得分 + 获奖积分</span><br />
				<span>4.市(州)前10位获得优秀组织奖</span><br />
				<span>5.县(市/区)前50位获得优秀组织奖</span>	
			</div>
			<a class="change_rank" href="/ranks">查看作品排名</a>
		</div>
		<div style="text-align:center;">
			<div class="change_rank" id="export1" style="position:relative;cursor: pointer;display: inline-block;">导出当前组数据</div>
			<div class="change_rank" id="export2" style="position:relative;cursor: pointer;display: none;">导出当前组数据</div>

		</div>
		<!--导航-->
		<div class="nav">
			<span class="navcur" data-type="1">市(州)排名</span>
			<span data-type="2">县(市、区)排名</span>
		</div>
		
		
		<div class="scoreDetails">
			<div class="scoreDetails_item">
				<div class="city_head" style="height:auto;">
					<table class="city_head_lists" id="table_city">
					<thead>
						<tr>
						<td class="t_head_rank">排名</td>
						<td class="city">市(州)</td>
						<td>投稿数量</td>
						<td>投稿量积分</td>
						<td class="score">一等奖数量</td>
						<td>一等奖积分</td>
						<td class="score">二等奖数量</td>
						<td>二等奖积分</td>
						<td class="score">三等奖数量</td>
						<td>三等奖积分</td>
						<td>总分</td>
						</tr>
					</thead>
					<tbody>
							<!--分数行-->
							@foreach ($data as $k=>$v)
								<tr class="scoreDetails_list">
									<td class="rank rank1">{{ $k+1 }}</td>
									<td class="number">{{ $v['city'] }}</td>
									<td>{{ $v['count'] }}</td>
									<td>{{ $v['count_score'] }}</td>
									<td class="score">{{ $v['first'] }}</td>
									<td>{{ $v['first_score'] }}</td>
									<td class="score">{{ $v['second'] }}</td>
									<td>{{ $v['second_score'] }}</td>
									<td class="score">{{ $v['third'] }}</td>
									<td>{{ $v['third_score'] }}</td>
									<td>{{ $v['total_score'] }}</td>
								</tr>
							@endforeach
					</tbody>
					</table>
				</div>
			</div>

			<!--区县排名-->
			<div class="scoreDetails_item">
				<!--表头-->
			
				<div class="county_head" style="height: auto">
					<table class="county_head_lists" id="table_county">
						<thead>
							<tr>					
								<td class="t_head_rank">排名</td>
								<td class="county">县(市/区)</td>
								<td class="city">所属市(州)</td>
								<td>投稿数量</td>
								<td>投稿量积分</td>
								<td class="score">一等奖数量</td>
								<td>一等奖积分</td>
								<td class="score">二等奖数量</td>
								<td>二等奖积分</td>
								<td class="score">三等奖数量</td>
								<td>三等奖积分</td>
								<td>总分</td>
							</tr>
					</thead>
					<tbody class="county_lists">
						<!--分数行-->
						@foreach ($areas_arr as $k=>$v)
						<tr class="county_list">
							<td class="rank rank2">{{ $k+1 }}</td>
							<td class="county ">{{ $v['Name'] }}</td>
							<td class="city">{{ $v['city'] }}</td>
							<td>{{ $v['count'] }}</td>
							<td>{{ $v['count_score'] }}</td>
							<td class="score">{{ $v['first'] }}</td>
							<td>{{ $v['first_score'] }}</td>
							<td class="score">{{ $v['second'] }}</td>
							<td>{{ $v['second_score'] }}</td>
							<td class="score">{{ $v['third'] }}</td>
							<td>{{ $v['third_score'] }}</td>
							<td>{{ $v['total_score'] }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				</div>
		</div>
			
		</div>
		<br><br><br><br>
		{{-- <div class="empty"></div> --}}
		<script type="text/javascript" src="{{ asset('images/external/jszip.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('images/external/FileSaver.js') }}"></script>
		<script type="text/javascript" src="{{ asset('images/scripts/excel-gen.js') }}"></script>
		<script type="text/javascript">	
		   
			$('.scoreDetails_item').eq(0).show().siblings().hide()
			$('.nav span').click(function(){
				$(this).addClass('navcur').siblings().removeClass('navcur')
				if ($(".navcur").data('type') === 1){
				$('#export1').css('display', 'inline-block')
				$('#export2').css('display', 'none')
			}
			if ($(".navcur").data('type') === 2){
				console.log($(".navcur").data('type'));
				$('#export1').css('display', 'none')
				$('#export2').css('display', 'inline-block')
			}
				
				var index = $(this).index()
				$('.scoreDetails_item').eq(index).show().siblings().hide();

			})

			var rank1 = document.querySelectorAll(".rank1")
			var rank2 = document.querySelectorAll(".rank2")
			addBg(rank1,'10',' BgColor1')
			addBg(rank2,'50',' BgColor1')

			function addBg(els,length,classname){
				for(var i = 0; i < els.length; i++){
					els[i].innerText = i + 1
					if( i < length && !els[i].parentNode.classList.contains(classname) ){
						els[i].parentNode.className += classname
					}
				}
			}
			$(function () {
				excel_1 = new ExcelGen({
					"src_id": "table_city",
					"show_header": true
				});
				excel_2 = new ExcelGen({
					"src_id": "table_county",
					"show_header": true
				});
				$("#export1").click(function () {
					excel_1.generate("市(州)排名数据");
				});
				$("#export2").click(function () {
					excel_2.generate("县(市、区)排名数据");
				});
			});
		</script>
	</body>
</html>
