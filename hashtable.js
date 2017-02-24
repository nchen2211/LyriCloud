function search() {
    var data = document.getElementById('txt').value;
    var temp = data;
    var words = new Array();
    words = temp.split(" ");
    var uniqueWords = new Array();
    var count = new Array();


    for (var i = 0; i < words.length; i++) {
        //var count=0;
        var f = 0;
        for (j = 0; j < uniqueWords.length; j++) {
            if (words[i] == uniqueWords[j]) {
                count[j] = count[j] + 1;
                //uniqueWords[j]=words[i];
                f = 1;
            }
        }
        if (f == 0) {
            count[i] = 1;
            uniqueWords[i] = words[i];
        }
        console.log("count of ->" + uniqueWords[i] + "<- - " + count[i]);
    }
}