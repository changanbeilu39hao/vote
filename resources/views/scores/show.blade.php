<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>评审结果</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/result.css') }}"/>
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
            <a href="{{ route('score.show',['group_id'=>1]) }}"><span id="x1">小学1-3年级组</span></a>
            <a href="{{ route('score.show',['group_id'=>2]) }}"><span id="x4">小学4-6年级组</span></a>
            <a href="{{ route('score.show',['group_id'=>3]) }}"><span id="cz">初中组</span></a>
		</div>
        
       
		<!--表头-->
		<div class="t_head">
			<ul class="t_head_lists">
				<li class="t_head_rank">排名</li>
				<li>作品编号</li>
				<li>zhuanjia01</li>
				<li>zhuanjia02</li>
				<li>zhuanjia03</li>
				<li>zhuanjia10</li>
				<li>zhuanjia11</li>
				<li>zhuanjia12</li>
				<li>zhuanjia13</li>
				<li class="t_head_lastSroce">最终得分</li>
			</ul>
		</div>
		
		<!--得分详情-->
		<div class="scoreDetails">
			
			<ul class="scoreDetails_lists">
                <!--分数行--> 
                @foreach ($d as $k=>$v)    

				<li class="scoreDetails_list">
					<span class="rank">{{ $k+1 }}</span>
					<span class="number"><a href="#" target="_blank">{{ $v['item_id'] }}</a></span>
					<span class="score">{{ $v['z1'] }}</span>
					<span class="score">{{ $v['z2'] }}</span>
					<span class="score">{{ $v['z3'] }}</span>
					<span class="score">{{ $v['z10'] }}</span>
					<span class="score">{{ $v['z11'] }}</span>
					<span class="score">{{ $v['z12'] }}</span>
					<span class="score">{{ $v['z13'] }}</span>
					<span class="last_score">{{ $v['last_score'] }}</span>
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
        if (l==1){
            $("#x1").addClass('navcur');
        }
        if (l==2){
            $("#x4").addClass('navcur');
        }
        if (l==3){
            $("#cz").addClass('navcur');
        }
    })
</script>
</html>
