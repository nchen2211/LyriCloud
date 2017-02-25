/*
 this function gets a string array, calculate each string frequency,
 and sorted in descending order based on the highest frequency
 */
function search() {
    var data = document.getElementById('txt').value;
    var temp = data;
    var words = new Array();
    words = temp.split(" ");
    var uniqueWords = new Array();
    var count = new Array();
    var wordMap = new Map();
    var wordArray = new Array();

    // calculate each word frequency
    console.log(words.length);
    for (var i = 0; i < words.length; i++) {
        var freq = 0;
        for (j = 0; j < uniqueWords.length; j++) {
            if (words[i] == uniqueWords[j]) {
                count[j] = count[j] + 1;
                freq = 1;
            }
        }
        if (freq == 0) {
            count[i] = 1;
            uniqueWords[i] = words[i];
        }
    }

    for (var i=0; i<uniqueWords.length; i++) {
        if (count[i] != "undefined") {
            wordArray.push({word: uniqueWords[i], freq: count[i]});
            wordMap.set(uniqueWords[i], count[i]);
        }
    }

    // sorting
    wordArray.sort(function(first,second){
        return second.freq - first.freq;
    });

    for (var i=0; i<wordArray.length; i++) {
        console.log(wordArray[i]);
    }

}