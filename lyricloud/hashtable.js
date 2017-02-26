var pronouns = ["your","i","they","their","we","them", "u",
    "its","our","my","those","he","us","her","something",
    "me","yourself","someone","everything","itself","everyone",
    "themselves","anyone","him","whose","myself","everybody",
    "ourselves","himself","somebody","yours","herself","whoever",
    "you","that","it","this","what","which","these","his","she",
    "lot","anything","whatever","nobody","none","mine","anybody",
    "some","there","all","where","another","same","certain","nothing",
    "self","nowhere","with","at","from","into","during","including",
    "until","against","among","throughout","despite","towards","upon",
    "concerning","of","to","in","for","on","by","about","like","through",
    "over","before","between","after","since","without","under","within",
    "along","following","across","behind","beyond","plus","except","but",
    "up","out","around","down","off","above","near","the","a","one","some","few","m","u","s","an","it","d","t", "is","am","are","you", "be"]

var set = new Set(pronouns)

/*
 this function gets a string array, calculate each string frequency,
 and sorted in descending order based on the highest frequency
 */
function search(in_data) {
    var data = in_data;
    var temp = data;
    var words = new Array();
    words = temp.split(" ");
    words = tolower(words);

    var uniqueWords = new Array();
    var count = new Array();
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
        if (count[i] > 0) {
            wordArray.push({word: uniqueWords[i], freq: count[i]});
        }
    }

    // sorting
    wordArray.sort(function(first,second) {
        return second.freq - first.freq;
    });

    console.log("BEFORE DELETION")
    for (var i=0; i<wordArray.length; i++) {
        console.log(wordArray[i]);
    }

    // eliminating pronouns
    // for (var i=0; i<wordArray.length; i++) {
    //     for (var j=0; j<pronouns.length; j++) {
    //         if (wordArray[i].word == pronouns[j]) {
    //             console.log("deleting: " + wordArray[i].word);
    //             wordArray.splice(i,1);
    //         }
    //     }
    // }

    for (var i=0; i<wordArray.length; i++) {
        if (set.has(wordArray[i].word)) {
            console.log("deleting: " + wordArray[i].word);
            wordArray.splice(i,1);
        }
    }

    console.log("AFTER DELETION")
    for (var i=0; i<wordArray.length; i++) {
        console.log(wordArray[i]);
    }
}

// convert words found to lower case
function tolower(strArray) {
    var lowerTemp = new Array();
    for (var i=0; i<strArray.length; i++) {
        lowerTemp[i] = strArray[i].toLowerCase();
    }

    return lowerTemp;
}