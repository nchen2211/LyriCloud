<?php
require_once('classes.php');
session_start();
//initialize variables
$artistList = array();// stores a list of artist
$songList = array();
$wordList = array();
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

// usort($words, "cmpWord");
// var_dump($words);
// 
// 

// echo "this is the session var: <br>";
// echo $_SESSION[1];
// print_r($_SESSION);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    echo "post triggered";
    $name = htmlspecialchars($_REQUEST['fname']); 
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $name;
    }
}

function addToArtistList($in_artist_name){
    global $artistList;
    $new_artist = new artistClass();
    $new_artist->setName($in_artist_name);
     array_push($artistList, $new_artist);
    // $artist = "justin biber";
    
    $url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=".$in_artist_name .
    "&api_key=f791703e02b30485a7059d19d7913e34&format=json";
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
    global $songList;
    // $new_song = new songClass();
    for($i = 0; $i<$arraycount; $i++){
        $each = $array[$i];
        //adding each name to the name array
        $new_song = new songClass();
        // var_dump($each->{'name'});
        $new_song->setName($each->{'name'});

        // var_dump($new_song);
        // echo "<br><br>";
        array_push($songList, $new_song);
    }
    // var_dump($songList[0]);
    bigString($in_artist_name);

    
    
}

function bigString($in_artist_name){
    global $songList;
    // echo "this is a test<br>";
    // var_dump($songList[0]);
    $str;
    for($x = 0; $x < 2; $x++){
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
}

$q = $_REQUEST["q"];
// $q ="sillyb";
// echo"this is the request ".$q."<Br>";
$hint = "";
if ($q != "") {
    // $q = strtolower($q);
    // $len=strlen($q);
    // foreach($a as $name) {
    //     if (stristr($q, substr($name, 0, $len))) {
    //         if ($hint === "") {
    //             $hint = $name;
    //         } else {
    //             $hint .= ", $name";
    //         }
    //     }
    // }
    addToArtistList("Justin Bieber");
    // var_dump($songList); 
    // $return = array("songs"=>$songList);

    // $return = json_encode($return);
    // var_dump($return);
    // echo $songList;
    // echo $return;
}else{
    echo "q is empty";
}    

// addToArtistList("Justin Biber");
// echo $songList;
    // $retun = array("songs"=>$songList);

    // // $return = json_encode($return);
    // echo $return;


// $clickedWord = $_REQUEST["clicked_word"];
// // var_dump($clickedWord);
// if($clickedWord != ""){
//     echo "shouldn't see this".$clickedWord;
//     // $to_return = countFreq($clickedWord);
//     $to_return = countFreq();
//     // echo "<br> here is to return: <br>";
//     var_dump($to_return);
//     $to_return = json_encode($to_return);

// }

$_SESSION['artists'] = $artistList;
$_SESSION['songs'] = $songList;
$_SESSION['words'] = $wordList;


?>




