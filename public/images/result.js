window.onload = function(){
	var rank = document.querySelectorAll(".rank")
	var scoreDetails_list = document.querySelectorAll(".scoreDetails_list")
	var nav = document.querySelectorAll(".nav span")
	addcalss(nav, " navcur")
	
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
		console.log(max_i,min_i)
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
}
