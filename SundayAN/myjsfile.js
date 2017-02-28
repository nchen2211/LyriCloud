// JavaScript Document
// function ready(){
// 	var words = localStorage.getItem("selectedWord");
// 	if(words!=null){
// 		console.log(words);
// 		console.log(JSON.parse(words));
// 		d3.wordcloud()
// 			.size([500, 300])
// 			.fill(d3.scale.ordinal().range(["#884400", "#448800", "#888800", "#444400"]))
// 			.words(words)
// 			.start();
// 	}

// }

function Show()
{ 
		if(document.getElementById("search").value == "john"){
			
			document.getElementById("artistNames").style.visibility="visible";
			document.getElementById("wordcloudimg").style.visibility="hidden";
		}
		else{
			document.getElementById("artistNames").style.visibility="hidden";
			document.getElementById("wordcloudimg").style.visibility="visible";
			document.getElementById("addbutton").style.visibility="visible";
			document.getElementById("sharebutton").style.visibility="visible"; 
			document.getElementById("gobutton").className = document.getElementById("gobutton").className + " move";
			document.getElementById("wordcloudimg").src="images/wordcloud.png";
		}
}

function inputchange( i){
	
	var text = document.getElementsByTagName('a')[i].innerHTML;
	document.getElementById("search").value=text;			   

}
/*
	$("gobutton").click(function() {
    $(".gobutton").toggleClass("buttonLeft");
	});
*/

	
//this function clear the current cloud and add a new one	
function showCloud(){
	var words = [];
	localStorage.setItem("selectedWord", "");
	var artist = document.getElementById('search').value;
	console.log(artist);
	// var test = localStorage.getItem("selsectedWord");
	// console.log(test);
	var string_to_process = loadAllLyrics(true, artist); 

	document.getElementById("addbutton").style.visibility="visible";
	document.getElementById("sharebutton").style.visibility="visible"; 
	document.getElementById("gobutton").className = document.getElementById("gobutton").className + " move";
			//document.getElementById("wordcloudimg").src="images/wordcloud.png";







}
//this functino keep adding to the current cloud
function addArtist(){
	console.log("the add artist function /n");
	var artist = document.getElementById('search').value;
	console.log(artist);
	var string_to_process = loadAllLyrics(false, artist); 
}

function loadAllLyrics(clear, in_name){
	var returnValue = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status ==200){
			// console.log(this.responseText);
			 // var returnValue= JSON.parse(this.responseText); 
			
			returnValue= (this.responseText);
			// console.log("this should be the lyrics");
			console.log(returnValue);
			

			search(returnValue);
			 // alert("what the fu");

		}
	};
	// console.log("this is clear"+ clear);
	if(clear){
		xmlhttp.open("GET", "testphp.php?artist_name="+in_name+"&clear=true", true);
	}else{
		console.log("about to send to php!");
		xmlhttp.open("GET", "testphp.php?artist_name="+in_name+"&clear=false", true);
	}
	
	xmlhttp.send();

	return returnValue;
}

function processCloud(in_array){
	// var current_words = localStorage.getItem("selectedWord");
	// console.log(in_array.length);
	var words = [];

	for(var i = 0; i < in_array.length; i++){
		// sconsole.log(in_array[i]);
		var each = {text: in_array[i].word, size: in_array[i].freq }
		words.push(each);
	}
	// console.log("this is the word array");
	// console.log(words);
	// var new_words = current_words.concat(words);
	localStorage.setItem("selectedWord", words);
	// console.log("this is our word<br>");
	// console.log(words);
	document.getElementById('wordcloud').innerHTML = '';


	d3.wordcloud()
			.size([500, 300])
			.fill(d3.scale.ordinal().range(["#884400", "#448800", "#888800", "#444400"]))
			.words(words)
			.start();

	document.getElementById('addbutton').setAttribute("style",""); 

}


	function backToCloud(){
			console.log("back");
			localStorage["rehome"] =JSON.stringify(1);
			window.location = "index.html";	

/*
			var xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status ==200){

					var returnValue= (this.responseText);
			 		console.log(returnValue);
			 		localStorage.setItem("storedWords", returnValue);

			 		setTimeout(function(){window.location = "index.html";}, 2000);


					}
			};
				xmlhttp.open("GET", "back.php", true);
				xmlhttp.send();
*/				
	}


	function reload(){
		/*
		if (localStorage.getItem("home") == null){
			localStorage.setItem("home", JSON.stringify(1));
		}
		*/
		if (localStorage.getItem("rehome") == null){
			localStorage.setItem("rehome", JSON.stringify(0));
		}	
		//var home = parseInt(localStorage.getItem("home"));
		var rehome = parseInt(localStorage.getItem("rehome"));	
		//console.log("home");
		//console.log(home);
		console.log("rehome");
		console.log(rehome);
		//var wordList = localStorage.getItem("selectedWord");
		if (rehome==1){
			console.log("reload");
			localStorage["rehome"] =JSON.stringify(0);
			var wordList = localStorage.getItem("selectedWord");
			console.log(wordList);
			wordList = JSON.parse(wordList);
			console.log(wordList);
		}
		/*
		if (localStorage.getItem("selectedWord") != null) {
  			console.log("reload");
  			//wordList = JSON.parse(wordList);
			console.log(wordList);
			//processCloud(wordList);
		}
		*/

	}

	function share(){
        
		html2canvas($('#wordcloud'), {
 			 onrendered: function(canvas) {
    		document.body.appendChild(canvas);
  			},
  			width: 300,
  			height: 200
		});

		/*
        html2canvas(document.body).then(function(canvas) {
            
            
            var i = Canvas2Image.convertToImage(canvas, 50, 50, "png");
            //var src = document.getElementById("img");
            document.body.appendChild(i);
        });
        */
	}
