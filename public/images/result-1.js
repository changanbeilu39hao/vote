window.onload = function(){
	var scoreDetails_list = document.querySelectorAll(".scoreDetails_list")
	var nav = document.querySelectorAll(".nav span")
	addcalss(nav, " navcur")
	addRank()
	function addRank(){
		var rank = document.querySelectorAll(".rank")
		var i = 0,rank_length =  rank.length
		for(var i = 0; i < rank_length; i++){
			rank[i].innerText = i +1
			var rank_num = parseInt( rank[i].innerText )
			
			//前1000名添加背景
			if( rank_num <= 50 && !rank[i].parentNode.classList.contains('BgColor1') ){
				rank[i].parentNode.className += " BgColor1"
			   }else if(rank_num >=51 && rank_num <= 150 && !rank[i].parentNode.classList.contains('BgColor2')){
				rank[i].parentNode.className += " BgColor2"
			   }else if(rank_num >=151 && rank_num <= 350 && !rank[i].parentNode.classList.contains('BgColor3')){
				rank[i].parentNode.className += " BgColor3"
			   }
		}
	}
	
	//判断最高分和最低分并改变样式
	for( var i = 0; i < scoreDetails_list.length; i++){
		var scoreNum = []
		var score = scoreDetails_list[i].querySelectorAll(".score")
		for(var j = 0; j < score.length; j++){
			var score_n = parseFloat( score[j].innerText )
			scoreNum.push(score_n)
			var max_i = getmax(scoreNum)
			var min_i = getmin(scoreNum)
		}
		score[max_i].className += " maxmin"
		score[min_i].className += " maxmin"
	}

	//获取最高分
	function getmax(arr) {
		var max = arr[0]
		var maxIndex = 0
		for(var a = 0; a < arr.length; a++){
			if(max < arr[a]){
				max = arr[a]
				maxIndex = a
			}
		}
		return maxIndex
	}
	
	//获取最低分
	function getmin(arr) {
		var min = arr[0]
		var minIndex = 0
		for(var b = 0; b < arr.length; b++){
			if(min > arr[b]){
				min = arr[b]
				minIndex = b
			}
		}
		return minIndex
	}
	
	//菜单切换
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

	//复制文本
	$('.empty').click(function(){
		var copystr = ''
		for(var x= 0; x < $('.number').length; x++){
			copystr += $('.number a').eq(x).text() +'\n'
		}
		var el = document.createElement('textarea')
		$(el).text(copystr)
	 	$('body').append(el)
	 	el.select();
	    document.execCommand("copy");
	    $(el).remove()
	    alert("已复制至剪切板")
	})
}
