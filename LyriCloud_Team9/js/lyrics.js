function ready(){
	var clicked_word = localStorage.getItem("clicked_word");
	var current_song = localStorage.getItem("current_song");
    var current_artist = localStorage.getItem("current_artist");
    console.log("this is the current artist"+current_artist);
	var lyrics = localStorage.getItem("current_lyrics");
	console.log(current_song);
	document.getElementById('current_song').innerHTML = current_song;
    document.getElementById('current_artist').innerHTML = "by "+current_artist;

	lyrics = JSON.parse(lyrics);
	for(var i = 0; i < lyrics.length; i++){
		displayLyric(lyrics[i]);
	}
}

function displayLyric(text) {
    
    var newParagraph = document.createElement('p');
    newParagraph.textContent = text;
    var clicked_word = localStorage.getItem("clicked_word").toLowerCase();
    console.log("this is the clicked word "+ clicked_word);

    var line = newParagraph.innerHTML;
    // var start = 0;
    var end =  line.indexOf(" "+clicked_word+" ");
    // var spot = end;
    // while( end >=0 )
    // { 
    // 	console.log("looping");

    //     line = line.substring(0,end+1) + "<span class='highlight'>" + line.substring(end+1,end+clicked_word.length+1) + "</span>" + line.substring(end + clicked_word.length+1);
    //     

    //     end = line.substring(end+clicked_word.length+2).indexOf(" "+clicked_word+" "); 
    // }
    newParagraph.innerHTML = processContent(clicked_word, line);
    


    document.getElementById("lyric").appendChild(newParagraph);
}
function processContent(in_word, in_line){
    var temp = (in_line.toLowerCase());
	var end = temp.indexOf(""+in_word+"");
	if(end < 0) return in_line;
    console.log("looping");

	var line = in_line.substring(0,end) 
	+ "<span class='highlight'>" + in_line.substring(end,end+in_word.length) + "</span>" 
	+ processContent(in_word, in_line.substring(end + in_word.length));
	return line;
}