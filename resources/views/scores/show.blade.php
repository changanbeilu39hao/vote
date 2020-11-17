<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
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
            $("#zj1").text('zhuanjia4')
            $("#zj2").text('zhuanjia5')
            $("#zj3").text('zhuanjia6')
            $("#zj4").text('zhuanjia14')
            $("#zj5").text('zhuanjia15')
            $("#zj6").text('zhuanjia16')
            $("#zj7").text('zhuanjia17')
        }
        if (l==3){
            $("#cz").addClass('navcur');
            $("#zj1").text('zhuanjia7')
            $("#zj2").text('zhuanjia8')
            $("#zj3").text('zhuanjia9')
            $("#zj4").text('zhuanjia18')
            $("#zj5").text('zhuanjia19')
            $("#zj6").text('zhuanjia20')
            $("#zj7").text('zhuanjia21')
        }
	})
	
</script>
</html>
@if (app()->isLocal())
@include('sudosu::user-selector')
@endif