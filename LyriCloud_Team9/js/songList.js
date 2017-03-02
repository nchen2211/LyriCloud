function ready(){
	var clicked_word = localStorage.getItem("clicked_word");
	var list = localStorage.getItem("songs_to_show");
	// console.log("from second page");
	// console.log(the_word);
	// console.log(list);
	document.getElementById('clicked_word').innerHTML = clicked_word;
	list = JSON.parse(list);
	// console.log(list);
	var length = list.length;

	var flag =1;
	for (var i=1; (i<length)&&(flag==1);i++ ){
		flag = 0;
		for (var j =0; j<(length-1);j++){
			if (list[j+1].freq > list[j].freq){
				var temp =list[j];
				list[j] =list[j+1];
				list[j+1] = temp;
				flag =1 ; 
			}
		}
	}

	for(var i = 0; i < length; i++){
		addSong(list[i].songname, list[i].freq, list[i].songID);
	}
}


//dynamically adding rows in songs.html for songname and frequency
function addSong(songName, frequency, id){
	 var tbl = document.getElementById('songList'), // table reference
        row = tbl.insertRow(tbl.rows.length),      // append table row
        i;
    // insert table cells to the new row
	
		createCell(row.insertCell(0),  frequency, 'row');
        createCell(row.insertCell(1),songName , 'row');
		// createCell(row.insertCell(2),frequency, 'row');
	row.setAttribute("name", songName);
    row.setAttribute("id", id);
    row.setAttribute("onclick", "showLyrics("+id+")");
}

function createCell(cell, text, style) {
    var div = document.createElement('div'), // create DIV element
        txt = document.createTextNode(text); // create text node
    div.appendChild(txt); 
    // if(text=="frequency"){
    // 	div.setAttribute("class", "left");
    // }                   // append text node to the DIV
    div.setAttribute('class', style);        // set DIV class attribute
    div.setAttribute('className', style);    // set DIV class attribute for IE (?!)
    cell.appendChild(div);                   // append DIV to the table cell
}// JavaScript Document


function showLyrics(in_id){
	// console.log("yeaaaahhhhhh");
	var current_song = document.getElementById(in_id).getAttribute("name");
	// console.log("this is the current song: "+current_song);
	localStorage.setItem("current_song", current_song);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if(this.readyState == 4 && this.status ==200){
			// console.log(this.responseText);
			 // var returnValue= JSON.parse(this.responseText); 
			var returnValue= (this.responseText);
			 // console.log(returnValue);
			 console.log(returnValue);
			 // alert("what the fu");
			 localStorage.setItem("current_lyrics", returnValue);

			 setTimeout(function(){window.location = "lyrics.html";}, 2000);


		}
	};
	xmlhttp.open("GET", "../php/lyrics.php?song_id="+in_id, true);
	xmlhttp.send();
}
//when the back to cloud function is clicked: 
function backToCloud(){
	console.log("back to cloud clicked");
	localStorage.setItem("reload", "true");
	setTimeout(function(){window.location = "lyriCloud.html";}, 2000);
}