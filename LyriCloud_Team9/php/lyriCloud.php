<?php
require_once('classes.php');
session_start();
// initialize variables
// $artistList ;// stores a list of artist
// $songList ;
// $wordList ;
// $str ;
// $lyrics

//creating classes

//the following function sort the word with ascending value 
function cmpWord($word1, $word2){
    if($word1->$count == $word2->$count){
        return 0;
    }
    return($word1->$count < $word2->$count) ? -1 : 1;
}

function getLyrics($in_id){
    global $wordList;
    $index = $wordList.size();
    $current_word = $wordList[$index];
    $Lyrics = $current_word.getSongLyrics($in_id);
    return $Lyrics;
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // collect value of input field
//     echo "post triggered";
//     $name = htmlspecialchars($_REQUEST['fname']); 
//     if (empty($name)) {
//         echo "Name is empty";
//     } else {
//         echo $name;
//     }
// }

function addToArtistList($in_artist_name){
    // echo $in_artist_name;
    global $artistList;
    global $songList;
    $new_artist = new artistClass();
    $new_artist->setName($in_artist_name);
    
    $url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=".$in_artist_name .
    "&api_key=f791703e02b30485a7059d19d7913e34&format=json&limit=5";
    $params = array("method" => "artist.gettoptracks", 
        "artist" => $in_artist_name, 
        "api_key" => "f791703e02b30485a7059d19d7913e34",
        "format"=>"json");
    $defaults = array(
        // CURLOPT_URL => 'http://ws.audioscrobbler.com/2.0/?',
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true);
 
    $ch = curl_init();
    curl_setopt_array($ch, $defaults);
    $output = curl_exec($ch);
    curl_close($ch);
    
    // var_dump($output);
    $json = json_decode($output);
    // var_dump($json);
    $array = $json->{'toptracks'}->{'track'};
    $arraycount = count($array);
    
    // $new_song = new songClass();
    $new_artist->setRangeStart(count($songList));
    for($i = 0; $i<$arraycount; $i++){
        $each = $array[$i];
        //adding each name to the name array
        $new_song = new songClass();
        // var_dump($each->{'name'});
        $new_song->setName($each->{'name'});

        // var_dump($new_song);
        array_push($songList, $new_song);
    }
    $new_artist->setRangeEnd(count($songList));
    array_push($artistList, $new_artist);

    // var_dump($songList[0]);
    bigString($in_artist_name);

    
    
}

function bigString($in_artist_name){
    global $artistList;
    global $songList;
    // echo "this is a test<br>";
    // var_dump($songList[0]);
    global $wordList;
    global $str;

    $current_artist = $artistList[count($artistList)-1];
    $start = $current_artist->getRangeStart();
    $end = $current_artist->getRangeEnd();

    // var_dump($artistList) ;
    // echo $end;
    for($x = $start; $x < $end; $x++){
        // echo songList.size."<br>";
    // foreach ($songList as $each_song) {
        # code...
        // $url = "https://lyric-api.herokuapp.com/api/find/".$in_artist_name."/".$each_song;
        // echo"<br>this is the name: ".$songList[$x]->getName()."<br>";
        $url = "https://api.lyrics.ovh/v1/".rawurlencode ( $in_artist_name)."/".$songList[$x]->getName();
        // echo "<br> this is the url".$url."<br>";
        $defaults = array(
        // CURLOPT_URL => 'http://ws.audioscrobbler.com/2.0/?',
            CURLOPT_URL => $url,
            CURLOPT_POST => false,
        // CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true);

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $output = curl_exec($ch);
        curl_close($ch);
        // var_dump($output) ;
        $json = json_decode($output) ;
        // var_dump($json) ;
        $json = $json->{"lyrics"};
        // echo "this is the song name:".$songList[$x]."   <br>";
        // echo $output;
        // echo "<br>".$json."<br>";
        // var_dump($json) ;
        $formal_lyrics = explode(",", $json);
        $songList[$x]->setLyrics($formal_lyrics);

        // echo "<Br> end of miehhhhhh<br><br>";
        $temp = trim( preg_replace( "/[^0-9a-z]+/i", " ", $json ) );
        $word_array = explode(" ", $temp);
        // var_dump($songList[$x]->getName());
        $songList[$x]->setWordArray($word_array);
        // echo "<br>this is the word array".$songList[$x]$word_array[0]."<br>";
        $str.= $temp;
    // print_r($output);
    }  

    echo $str;
    // var_dump($songList);
$_SESSION['artists'] = $artistList;
$_SESSION['songs'] = $songList;
$_SESSION['words'] = $wordList;
$_SESSION['longString'] = $str;

}

//this function clears what's stored in the variables;
function clearup(){
    session_unset();
    session_destroy();
    session_start();

    global $artistList;
    // unset($artistsList);
    $artistList = array();
    global $songList;
    // unset($songList);
    $songList = array();
    global $wordList;
    // unset($wordList);
    $wordList = array();
    global $str ;
    // unset($str);
    $str = "";


    // $_SESSION['artists'] = $artistList;
    // $_SESSION['songs'] = $songList;
    // $_SESSION['words'] = $wordList;
    // $_SESSION['longString'] = $str;
    global $artist_name;
    addToArtistList($artist_name);
    // addToArtistList("Justin Bieber");

}

$artist_name = $_REQUEST["artist_name"];
$clear = $_REQUEST["clear"];
if ($artist_name != "") {
    // var_dump($clear);
    if($clear=="true"){
        // echo "<br><br> this is a clear decision <br><br>";
        // echo $artist_name;
        clearup();
        // var_dump($artists);
    }else{
        // echo "<br><br> this is not a clear decision <br><br>";
        // global $artistList;
        // $artistList = $_SESSION['artists'];
        // global $songList;
        // $songList = $_SESSION['songs'];
        // global $wordList ;
        // $wordList = $_SESSION['words'];
        // global $str ;
        // $str = $_SESSION['longString'];
        addToArtistList($artist_name);

    }

}else{
    echo "artist name is empty";
} 

$_SESSION['artists'] = $artistList;
$_SESSION['songs'] = $songList;
$_SESSION['words'] = $wordList;
$_SESSION['longString'] = $str;


// addToArtistList("Justin Bieber");
// clearup();
?>




