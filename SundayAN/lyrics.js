function ready(){
	var word_clicked = localStorage.getItem("clicked_word");
	var lyrics = localStorage.getItem("current_lyrics");

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