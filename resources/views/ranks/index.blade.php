<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>作品排名</title>
		<link rel="stylesheet" type="text/css" href="{{ asset("images/rank_product.css") }}"/>
		<script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="{{ asset("images/result-1.js") }}" ></script>
	</head>
	<body>
		<!--顶部-->
		<div class="top">
			<p>四川森林草原防灭火安全教育手抄报征集活动作品排名</p>
		</div>
					
		<!--提示消息-->
		<div class="hint">
			<div class="hint_text">
				<p>提示：</p><br />
				<span>1.评审得分 =（专家总分 - 最高分 - 最低分）/ 5</span><br />
				<span>2.投票得分 = 作品得票数 ÷ 该组第一名作品得票数 x 20</span><br />
				<span>3.作品得分 = 评审得分 + 投票得分</span><br />
				<span>4.黄色背景为一等奖，绿色背景为二等奖，蓝色背景为三等奖</span>
			</div>
			<a class="change_rank" href="/city">查看市(州)、县(市/区)排名</a>
		</div>
		<div style="text-align:center;">
		<div class="change_rank" id="export" style="position:relative;cursor: pointer;display: inline-block;">导出当前组数据</div>
	 </div>
		<!--导航-->
		<div class="nav">
			<a href="/ranks/1"><span class="@if ($id == 1) navcur  @endif">小学1-3年级组</span></a>
			<a href="/ranks/2"><span class="@if ($id == 2) navcur  @endif">小学4-6年级组</span></a>
			<a href="/ranks/3"><span class="@if ($id == 3) navcur  @endif">初中组</span></a>
		</div>
		
		
		<div  class="t_head" style="width:1400px;">
			<table class="t_head_lists"  id="test_table">
				<thead>
				  <td class="t_head_rank">排名</td>
				  <td>作品编号</td>
				  <td>zhuanjia01</td>
				  <td>zhuanjia02</td>
				  <td>zhuanjia03</td>
				  <td>zhuanjia04</td>
				  <td>zhuanjia05</td>
				  <td>zhuanjia06</td>
				  <td>zhuanjia07</td>
				  <td class="t_head_lastSroce">评审得分</td>
				  <td>评审排名</td>
				  <td>票数</td>
				  <td>投票得分</td>
				  <td>投票排名</td>
				  <td>作品总分</td>
				  <td>指导教师</td>
				  <td>创作者</td>
			  </thead>
			  <tbody>
				@foreach ($data as $k=>$v)
				<tr class="scoreDetails_list">
					<td class="rank">{{ $k+1 }}</td>
					<td class="number"><a href="https://aqjy.newssc.org/work/workdetail/?id={{ $v['item_id'] }}" target="_blank">{{ $v['item_id'] }}</a></td>
					<td class="score">{{ $v['z1'] }}</td>
					<td class="score">{{ $v['z2'] }}</td>
					<td class="score">{{ $v['z3'] }}</td>
					<td class="score">{{ $v['z4'] }}</td>
					<td class="score">{{ $v['z5']}}</td>
					<td class="score">{{ $v['z6'] }}</td>
					<td class="score">{{ $v['z7'] }}</td>
					<td>{{ $v['last_score'] }}</td>
					<td>{{ $v['score_rank'] }}</td>
					<td>{{ $v['Tickets'] }}</td>
					<td>{{ $v['vote_score'] }}</td>
					<td>{{ $v['vote_rank'] }}</td>
					<td>{{ $v['total_score'] }}</td>
					<td>{{ $v['Teacher'] }}</td>
					<td class="author">{{ $v['Student'] }}</td>
				</tr>
				@endforeach
			  </tbody>
			  </table>
		<br><br><br><br>
		<script type="text/javascript" src="{{ asset('images/external/jszip.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('images/external/FileSaver.js') }}"></script>
		<script type="text/javascript" src="{{ asset('images/scripts/excel-gen.js') }}"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			excel = new ExcelGen({
				"src_id": "test_table",
				"show_header": true
			});
			$("#export").click(function () {

				excel.generate("作品排名数据");
			});
		});
		</script>
	</body>
	
</html>
