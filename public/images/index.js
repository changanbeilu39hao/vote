window.onload =function(){
	
	//导航
// 	var nav = document.querySelectorAll(".nav span")
// 	var chuxuan = document.querySelectorAll(".chuxuan")
// //	addcalss(nav,"nav_cur");
// 	for(var i = 0; i < nav.length; i++){
// 		nav[i].index = i
// 		nav[i].onclick = function(){
// 			var index = this.index
// 			for(var j = 0; j <nav.length; j++){
// 				nav[j].className = ""
// 				chuxuan[j].style.display = "none"
// 			}
// 			chuxuan[index].style.display = "block"
// 			this.className += " nav_cur"
// 		}
// 	}

	
	//筛选
	var filter_btn =  document.querySelectorAll(".shaixuan_l span");
	addcalss(filter_btn,"shaixuancur");

	
	//分页
	page1 = document.querySelectorAll(".page1 a")
	addcalss(page1,"pagecur");
	page2 = document.querySelectorAll(".page2 a")
	addcalss(page2,"pagecur");
	
	//确认作品
	var star = document.querySelectorAll(".star")
	var mypass = document.querySelector('.shaixuan_r span')
	var mypass_num = mypass.innerHTML;
	
	for(var star_index = 0; star_index < star.length; star_index++){
		star[star_index].onclick = function(){
			if(this.classList.contains("star_fill")){
				this.classList.remove("star_fill")
				this.classList.add("star_stroke")
				mypass_num--
			
			}else{

				this.classList.remove("star_stroke")
				this.classList.add("star_fill")
				mypass_num++
	
			}
			mypass.innerText = mypass_num
		}
	}
	
	//提交验证
	// var push = document.querySelector(".push")
	// var threeStar = document.querySelector(".threeStar")
	// push.onclick = function(){
	// 	var threeStar_num =  parseInt(threeStar.innerText) 
	// 	if(threeStar_num < 2000){
	// 		alert("三星作品少于2000件")
	// 	}else if(threeStar_num > 2000){
	// 		alert("三星作品多于2000件")
	// 	}else{
	// 		//执行提交	
	// 	}
	// }
	
	//打分
	var scoreShow = document.querySelectorAll(".scoreShow")
	var postScore = document.querySelectorAll(".postScore")

	for(var post_i = 0; post_i < postScore.length; post_i++ ){
		postScore[post_i].setAttribute("index",post_i)
		postScore[post_i].onclick = function(){
			var post_index = this.getAttribute("index")
			var scoreValue = parseInt( this.previousElementSibling.value )
			if( scoreValue <= 80 && scoreValue >= 0 ){
				scoreShow[post_index].style.display = "block"
				scoreShow[post_index].innerText =scoreValue
			}else{
				alert("分数范围0-80分")
			}
		}
	}
	
	//查看大图
	var rel =  document.querySelectorAll(".realImg")
	var showImg =  document.querySelector(".showImg")
	for(var rel_index = 0; rel_index < rel.length; rel_index++){
		rel[rel_index].onclick = function(){
			var rel_imgSrc = this.parentNode.querySelector("img").getAttribute("data-rel");
			console.log(rel_imgSrc)
			showImg.style.display = "block"
			showImg.children[0].setAttribute("src",rel_imgSrc)
		}
	}
	showImg.onclick = function(){
		this.style.display = "none"
	}
	
	function addcalss(el,curclass){
		for(var i = 0; i < el.length; i++){
			el[i].onclick = function(){
				for(var j = 0; j < el.length; j++){
					el[j].className = ""
				}
				this.className += " " + curclass
			}
		}
	}
	
}
