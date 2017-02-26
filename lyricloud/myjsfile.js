// JavaScript Document

// Enter key triggers GO button
document.getElementById("gobutton")
    .addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode == 13) {
            document.getElementById("gobutton").click();
        }
    });

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

	
// show the word cloud
function showCloud(){
	//document.getElementById("wordcloudimg").style.visibility="hidden";
	var artist = document.getElementById('search').value;
	console.log(artist);

	// var string_to_process = loadAllLyrics(artist);
	// console.log(string_to_process);
	d3.wordcloud()
		.size([500, 300])
		.fill(d3.scale.ordinal().range(["#884400", "#448800", "#888800", "#444400"]))
		.words(words)
		.start();

}

function loadAllLyrics(in_name){
	var str = in_name;
	var processed = "";
	var returnValue = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status ==200){
			console.log(this.responseText);
			 var returnValue= JSON.parse(this.responseText); 

			 document.getElementById('txtHint').innerHTML = returnValue.songs;
		}
	};
	xmlhttp.open("GET", "testphp.php?q="+str+"&", true);
	xmlhttp.send();
	return returnValue;
}


   
