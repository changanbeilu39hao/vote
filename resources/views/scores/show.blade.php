<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>评审结果</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/result.css') }}"/>
		<script type="text/javascript" src="{{ asset('images/result.js') }}" ></script>
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
			<span class="navcur">小学1-3年级组</span>
			<span>小学4-6年级组</span>
			<span>初中组</span>
		</div>
		
		<!--表头-->
		{{-- <div class="t_head">
			<ul class="t_head_lists">
				<li class="t_head_rank">排名</li>
				<li>作品编号</li>
				<li>zhuanjia01</li>
				<li>zhuanjia02</li>
				<li>zhuanjia03</li>
				<li>zhuanjia04</li>
				<li>zhuanjia05</li>
				<li>zhuanjia06</li>
				<li>zhuanjia07</li>
				<li class="t_head_lastSroce">最终得分</li>
			</ul>
		</div> --}}
		
		<!--得分详情-->
		{{-- <div class="scoreDetails">
			
			<ul class="scoreDetails_lists">
				<!--分数行-->
				<li class="scoreDetails_list">
					<span class="rank">1</span>
					<span class="number"><a href="#" target="_blank">000000</a></span>
					<span class="score">79</span>
					<span class="score">76</span>
					<span class="score">80</span>
					<span class="score">51</span>
					<span class="score">32</span>
					<span class="score">74</span>
					<span class="score">78</span>
					<span class="last_score">00.00</span>
				</li>
				
				<li class="scoreDetails_list">
					<span class="rank">1</span>
					<span class="number"><a href="#" target="_blank">000000</a></span>
					<span class="score">22</span>
					<span class="score">76</span>
					<span class="score">68</span>
					<span class="score">51</span>
					<span class="score">79</span>
					<span class="score">74</span>
					<span class="score">78</span>
					<span class="last_score">00.00</span>
				</li>

				<li class="scoreDetails_list">
					<span class="rank">1001</span>
					<span class="number"><a href="#" target="_blank">000000</a></span>
					<span class="score">79</span>
					<span class="score">76</span>
					<span class="score">80</span>
					<span class="score">51</span>
					<span class="score">79</span>
					<span class="score">74</span>
					<span class="score">78</span>
					<span class="last_score">00.00</span>
				</li>
				
				<li class="scoreDetails_list">
					<span class="rank">1002</span>
					<span class="number"><a href="#" target="_blank">000000</a></span>
					<span class="score">79</span>
					<span class="score">38</span>
					<span class="score">49</span>
					<span class="score">51</span>
					<span class="score">79</span>
					<span class="score">74</span>
					<span class="score">78</span>
					<span class="last_score">00.00</span>
				</li>
				
				
			</ul>

		</div>
		 --}}
		
		
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
	</body>
</html>
