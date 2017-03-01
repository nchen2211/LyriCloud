function ready(){
	var current_song = localStorage.getItem("current_song");
	var lyrics = localStorage.getItem("current_lyrics");
	console.log(current_song);
	document.getElementById('current_song').innerHTML = current_song;

	lyrics = JSON.parse(lyrics);

	var part = lyrics.slice(0, 5);
	console.log(part);
	for(var i = 0; i < part.length; i++){
		displayLyric(part[i]);
	}
}

function displayLyric(text) {
    
    var newParagraph = document.createElement('p');
    newParagraph.textContent = text;
    document.getElementById("lyric").appendChild(newParagraph);
}