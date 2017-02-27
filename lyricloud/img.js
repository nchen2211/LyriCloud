// JavaScript Document
function shareImage(url){
	var img = document.createElement('img');
	img.src = url;
	document.getElementById('shareimg').appendChild(img);
}
function share(){
	shareImage("images/wordcloud.png")
}