<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="{{ asset('images/xiangqing.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ asset('images/xiangqing_phone.css') }}"/>
		<title>详情页面</title>
	</head>
	<body>
		<!--顶部-->
		<div class="top">
			<div class="top_main">
				<div class="top_left">
					<a href="#" target="_blank" class="logo">
						<img src="{{ asset('images/scnews.png') }}"/>
						<p>四川新闻网首页</p>
					</a>
				</div>
				
			</div>
		</div>
			
		<!--banner-->
		<div class="banner"><img src="{{asset('images/banner.jpg')}}"/></div>
		
		<!--标题-->
		<div class="title">
			<span class="bianhao">{{ $data->name }}</span>
			{{-- <p>加快解决科技创新发展的一些关键问题</p> --}}
		</div>
		
		<!--正文-->
		<div class="main">
		  <div class="main_img">
			<div class="main_img_item">
				<img src="{{ $data->bigImage }}"/>
			

				<!--旋转按钮-->
				<div class="rotate_icon">
					<span title = "右旋90°"><img src="{{ asset('images/plus_90.png') }}"/></span>
					<span title = "左旋90°"><img src="{{ asset('images/min_90.png') }} "/></span>
					<span title = "水平翻转"><img src="{{ asset('images/shuiping.png') }}"/></span>
					<span title = "垂直翻转"><img src="{{ asset('images/chuizhi.png') }} "/></span>
					<span title = "重置旋转"><img src="{{ asset('images/reset.png') }}"/></span>
				</div>
		    </div>
		 </div>
			
			<div class="main_mse">
				<div class="main_mse_item">
					<span>作品组别:</span>
					<p>{{ $data->groupType }}</p>
				</div>
				{{-- <div class="main_mse_item">
					<span>作品简介:</span>
					<p>《方案》明确，探索建设天基智能卫星互联网，拓展“卫星+智慧城市”“卫星+安全服务”等应用服务能力。实施“星河”智能卫星互联网建设重大工程，建设人工智能（AI）卫星总装工厂、地基AI卫星运控网、卫星网络应用服务平台等，构建支持巨型星座式星群管控任务的地面测运控网络，打造通导遥一体化空间信息大数据中心，具备提供覆盖全球的分钟级对地观测和影像数据安全共享能力。</p>
				</div> --}}
				<div class="main_mse_item">
					<span>市(州)、县(市、区):</span>
					<p>{{ $data->areaName }}</p>
				</div>
				<div class="main_mse_item">
					<span>学校名称:</span>
					<p>{{ $data->school }}</p>
				</div>
				<div class="main_mse_item">
					<span>参与创作学生班级:</span>
					<p>{{ $data->class }}</p>
				</div>
				<div class="main_mse_item">
					<span>参与创作学生姓名:</span>
					<p>{{ $data->student }}</p>
				</div>
				<div class="main_mse_item">
					<span>指导教师姓名:</span>
					<p>{{ $data->teacher }}</p>
				</div>
			</div>
		
		</div>
		
		<!--底部-->
		<div class="foot">
			<ul class="foot_top">
				<li><a href="#" target="_blank">关于我们</a></li>
				<li><a href="#" target="_blank">网站合作</a></li>
				<li><a href="#" target="_blank">广告服务</a></li>
				<li><a href="#" target="_blank">法律声明</a></li>
				<li><a href="#" target="_blank">编辑部邮箱</a></li>
				<li><a href="#" target="_blank">友情链接</a></li>
				<li><a href="#" target="_blank">网站建设</a></li>
			</ul>
			<p>网上传播视听节目许可证 编号：2304068 发证机关：国家广播电影电视总局</p>
			<p>经营许可证 编号：川B2-20100027   四川新闻网版权所有   蜀ICP备12007028号-8  川公网安备51019002001679号</p>
			<ul class="foot_bot">
				<li><a href="http://www.cdnet110.com/" target="_blank"><img src="http://www.newssc.org/images/2018/foo_23.jpg"/></a></li>
				<li><a href="http://www.12377.cn/" target="_blank"><img src="http://www.newssc.org/images/2018/foo_25.jpg"/></a></li>
				<li><a href="http://www.12377.cn/node_548446.htm" target="_blank"><img src="http://www.newssc.org/images/2018/foo_27.jpg"/></a></li>
				<li><a href="http://www.scjb.gov.cn/" target="_blank"><img src="http://www.newssc.org/images/2018/foo_29.jpg"/></a></li>
				<li><a><img src="http://www.newssc.org/images/2018/foo_31.jpg"/></a></li>
			</ul>
		</div>
		
		<div class="showImg">
			<img src="" />
			<span>x</span>
		</div>
		<script type="text/javascript">
			(function(){
				 var htmlWidth = document.documentElement.clientWidth || document.body.clientWidth;
				 var htmlDom = document.getElementsByTagName("html")[0];
				 htmlDom.style.fontSize = htmlWidth / 10.8 + "px";
			})()
			
			//顶部时间
			// var dateText = document.querySelector(".date");
			// var _date = new Date();
			// var year = _date.getFullYear();
			// var month = _date.getMonth();
			// var day = _date.getDate();
			// var weeks = _date.getDay();
			// var week = "";
			
			// switch(weeks){
			// 	case 1:week = "星期一" ; break;
			// 	case 2:week = "星期二" ; break;
			// 	case 3:week = "星期三" ; break;
			// 	case 4:week = "星期四" ; break;
			// 	case 5:week = "星期五" ; break;
			// 	case 6:week = "星期六" ; break;
			// 	case 0:week = "星期日" ; break;
			// }
			// dateText.innerText = year + "年" + month + "月" + day + "日"  + "  " + week;
			
			var rotate_icon = document.querySelectorAll('.rotate_icon span')
			rotate_icon[0].onclick = function(){
				// console.log(1)
				rotate_method.call(this,90)
			}
			rotate_icon[1].onclick = function(){
				rotate_method.call(this,-90)
			}
			rotate_icon[2].onclick = function(){
				rotate_method.call(this,180,'Y')
			}
			rotate_icon[3].onclick = function(){
				rotate_method.call(this,180,'X')
			}
			rotate_icon[4].onclick = function(){
				this.parentNode.parentNode.children[0].style.transform = 'rotate(' + 0 + 'deg)'
			}
			
			// rotate_icon[5].onclick = function(){
			// 	rotate_method.call(this,90)
			// }
			// rotate_icon[6].onclick = function(){
			// 	rotate_method.call(this,-90)
			// }
			// rotate_icon[7].onclick = function(){
			// 	rotate_method.call(this,180,'Y')
			// }
			// rotate_icon[8].onclick = function(){
			// 	rotate_method.call(this,180,'X')
			// }
			// rotate_icon[9].onclick = function(){
			// 	this.parentNode.parentNode.children[0].style.transform = 'rotate(' + 0 + 'deg)'
			// }
			
			function rotate_method(deg,axis){
				if(axis){
					this.parentNode.parentNode.children[0].style.transform = 'rotate' + axis + '(' + deg + 'deg)'
				}else{
					this.parentNode.parentNode.children[0].style.transform = 'rotate(' + deg + 'deg)'
				}
			}
			
			
			// //点击查看大图
			// var main_img_item = document.querySelectorAll(".main_img_item")
			// var showImg = document.querySelector(".showImg")
			// for(var i = 0; i < main_img_item.length; i++){
			// 	main_img_item[i].children[0].onclick = function (){
			// 		var img_url = this.getAttribute("src")
			// 		showImg.children[0].setAttribute("src",img_url)
			// 		showImg.style.display = "block"
			// 	}
			// }
			
		</script>
	</body>
</html>
