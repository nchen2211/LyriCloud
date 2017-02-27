// JavaScript Document

function displayLyric(text) {
    
    var newParagraph = document.createElement('p');
    newParagraph.textContent = text;
    document.getElementById("lyric").appendChild(newParagraph);
}
