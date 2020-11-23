window.onload = function(){
	var rank = document.querySelectorAll(".rank")
	var scoreDetails_list = document.querySelectorAll(".scoreDetails_list")
	var nav = document.querySelectorAll(".nav span")
	addcalss(nav, " navcur")

	addRank()
	function addRank(){
		var rank = document.querySelectorAll(".rank")
		for(var i = 0; i < rank.length; i++){
			//遍历排名序号
			rank[i].innerText = i+1
			var rank_num = parseInt( rank[i].innerText )
			//前1000名添加背景
			if( rank_num <= 1000 && !rank[i].parentNode.classList.contains('BgColor') ){
				rank[i].parentNode.className += " BgColor"
				rank[i].className += " blodFont"
			}
		}
	}
	
	for(var i = 0; i < rank.length; i++){
		var rank_num = parseInt( rank[i].innerText )
		if( rank_num <= 1000 ){
			rank[i].parentNode.className += " BgColor"
			rank[i].className += " blodFont"
		}	
	}
	
	for( var i = 0; i < scoreDetails_list.length; i++){
		var scoreNum = []
		var score = scoreDetails_list[i].querySelectorAll(".score")
		for(var j = 0; j < score.length; j++){
			var score_n = parseInt( score[j].innerText )
			scoreNum.push(score_n)
			var max_i = getmax(scoreNum)
			var min_i = getmin(scoreNum)
		}
		score[max_i].className += " maxmin"
		score[min_i].className += " maxmin"
	}
	
	function 	getmax(arr) {
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
	
	function 	getmin(arr) {
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
