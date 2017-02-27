function ready(){
	var the_word = localStorage.getItem("clicked_word");
	var list = localStorage.getItem("songs_to_show");
	console.log("from second page");
	console.log(the_word);
	console.log(list);
	list = JSON.parse(list);
	console.log(list);
	var length = list.length;
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
	
		createCell(row.insertCell(0),  id, 'row');
        createCell(row.insertCell(1),songName , 'row');
		createCell(row.insertCell(2),frequency, 'row');
    row.setAttribute("id", id);
    row.setAttribute("onclick", "showLyrics("+id+")");
}

function createCell(cell, text, style) {
    var div = document.createElement('div'), // create DIV element
        txt = document.createTextNode(text); // create text node
    div.appendChild(txt);                    // append text node to the DIV
    div.setAttribute('class', style);        // set DIV class attribute
    div.setAttribute('className', style);    // set DIV class attribute for IE (?!)
    cell.appendChild(div);                   // append DIV to the table cell
}// JavaScript Document


function showLyrics(in_id){
	console.log("yeaaaahhhhhh");
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
	xmlhttp.open("GET", "lyrics.php?song_id="+in_id, true);
	xmlhttp.send();
}