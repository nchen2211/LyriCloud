function showResult(){
	var str = "Justin Biber";
	var processed = "";
	var returnValue = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status ==200){
			 var returnValue= JSON.parse(this.responseText); 
			 
			 // alert("what the fu");

			 document.getElementById('txtHint').innerHTML = returnValue.songs;
		}
	};
	xmlhttp.open("GET", "testphp.php?q="+str, true);
	xmlhttp.send();
}

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1737253786597285";
  fjs.parentNode.insertBefore(js, fjs);
}
(document, 'script', 'facebook-jssdk'));