//this functino add function to enter key
//as well as check if this is the first time entering the cloud
function ready(){
	document.getElementById('search').onkeypress = function searchKeyPress(event) {
			if (event.keyCode == 13) {
				document.getElementById('gobutton').click();
			}
		}
	console.log("onload");
	console.log(localStorage.getItem("reload"));
	if(localStorage.getItem("reload") == "true"){
		console.log("here here");
		document.getElementById('wordcloudimg').style.visibility = "hidden";
		localStorage.setItem("reload","false");
		var x = "notarray";
		processCloud(x);
	}
	
}

function inputchange( i){	
	var text = document.getElementsByTagName('a')[i].innerHTML;
	document.getElementById("search").value=text;			   

}

//this function clear the current cloud and add a new one	
function showCloud(){
	document.getElementById('cloud_title').innerHTML = "";
	var words = [];
	localStorage.setItem("selectedWord", "");
	var artist = document.getElementById('search').value;
	console.log(artist);
	var string_to_process = loadAllLyrics(true, artist); 
}

//this functino keep adding to the current cloud
function addArtist(){
	console.log("the add artist function /n");
	var artist = document.getElementById('search').value;
	console.log(artist);
	var string_to_process = loadAllLyrics(false, artist); 
}

function loadAllLyrics(clear, in_name){
	localStorage.setItem("title_artist", in_name);
	var returnValue = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status ==200){
			returnValue= (this.responseText);
			console.log(returnValue);
			search(returnValue);
		}
	};
	if(clear){
		xmlhttp.open("GET", "../php/lyriCloud.php?artist_name="+in_name+"&clear=true", true);
	}else{
		console.log("about to send to php!");
		xmlhttp.open("GET", "../php/lyriCloud.php?artist_name="+in_name+"&clear=false", true);
	}
	xmlhttp.send();
	// return returnValue;
}

function processCloud(in_array){
	var words;
	if(in_array !="notarray"){
		words = [];
		for(var i = 0; i < in_array.length; i++){
			var each = {text: in_array[i].word, size: in_array[i].freq }
			words.push(each);
		}
	}else{
		words = localStorage.getItem("selectedWord");
		words = JSON.parse(words);
		console.log("this is the word"+words);
	}
	var temp = JSON.stringify(words);
	localStorage.setItem("selectedWord", temp);
	document.getElementById('wordcloud').innerHTML = '';
	d3.wordcloud()
			.size([500, 300])
			.fill(d3.scale.ordinal().range(["#9926b2", "#604865", "#6e08b5", "#504f50"]))
			.words(words)
			.start();

	showButtons();
}

function showButtons(){
	document.getElementById('search').autocomplete="on";
	document.getElementById('search').class="";
	document.getElementById("addbutton").style.visibility="visible";
	document.getElementById("sharebutton").style.visibility="visible"; 
	document.getElementById("gobutton").className = document.getElementById("gobutton").className + " move";
	if(document.getElementById('cloud_title').innerHTML!="")document.getElementById('cloud_title').innerHTML += ", ";
	document.getElementById('cloud_title').innerHTML += localStorage.getItem("title_artist");
	localStorage.setItem("title_artist", document.getElementById('cloud_title').innerHTML);
}

function share(){
    var canvas_img;
    html2canvas($('#wordcloud'), {
         onrendered: function(canvas) {
          //this is the callback when canvas is rendered
          var returnURL = "";
          try {
              var img = canvas.toDataURL('../image/png', 0.9).split(',')[1];
          } catch(e) {
              var img = canvas.toDataURL().split(',')[1];
          }
          // open the popup in the click handler so it will not be blocked
          // var w = window.open();
          // w.document.write('Uploading...');
          // upload to imgur using jquery/CORS
          // https://developer.mozilla.org/En/HTTP_access_control
          // var name = document.getElementById('search').value;
          var name = localStorage.getItem("title_artist");

          $.ajax({
              url: 'https://api.imgur.com/3/upload',
              method: 'POST',
              dataType: 'json',
              headers: {
                  Authorization: 'Client-ID 733f64f7fc2d307'
              },
              data: {
                  type: 'base64',
                  // get your key here, quick and fast http://imgur.com/register/api_anon
                  key: '733f64f7fc2d307',
                  name: 'neon.jpg',
                  title: name,
                  caption: 'Dope wordcloud',
                  image: img
              }
          }).success(function(data) {
              var id = data.data.id;
              //get the url of the uploaded image
              imageurl = "https://imgur.com/gallery/" + id;
              console.log("imageurl" + imageurl);
              //convert it to the url of facebook sharing
              returnURL = fbshareCurrentPage(false, imageurl);
              //open a new window for fb sharing
              console.log("finalULR" + returnURL);
              window.open (returnURL,"facebook sharing");
          }).error(function() {
              alert('Could not reach api.imgur.com. Sorry :(');
              w.close();
          });
          return returnURL;
        },
        width: 500,
        height: 350
    });
}

