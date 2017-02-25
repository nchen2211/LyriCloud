// JavaScript Document

function Show()
    { 
		if(document.getElementById("search").text == "john"){
			alert("hey john");
			document.getElementById("artistNames").style.visibility="visible";
		}
		else{
			document.getElementById("addbutton").style.visibility="visible";
			document.getElementById("sharebutton").style.visibility="visible"; 
			document.getElementById("gobutton").className = document.getElementById("gobutton").className + " move";
			document.getElementById("wordcloud").src="../wordcloud.png";
		}
	}
	 
	$("gobutton").click(function() {
    $(".gobutton").toggleClass("buttonLeft");
});
