
//dynamically adding rows in songs.html for songname and frequency
function addSong(songName, frequency, id){
	 var tbl = document.getElementById('songList'), // table reference
        row = tbl.insertRow(tbl.rows.length),      // append table row
        i;
    // insert table cells to the new row
	
		createCell(row.insertCell(0),  id, 'row');
        createCell(row.insertCell(1),songName , 'row');
		createCell(row.insertCell(2),frequency, 'row');
    
}

function createCell(cell, text, style) {
    var div = document.createElement('div'), // create DIV element
        txt = document.createTextNode(text); // create text node
    div.appendChild(txt);                    // append text node to the DIV
    div.setAttribute('class', style);        // set DIV class attribute
    div.setAttribute('className', style);    // set DIV class attribute for IE (?!)
    cell.appendChild(div);                   // append DIV to the table cell
}// JavaScript Document