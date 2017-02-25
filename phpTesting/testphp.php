<?php
session_start();
//initialize variables
$artistList = array();// stores a list of artist
$songList = array();
$words;
// $lyrics
$_SESSION['artists'] = $artistList;
$_SESSION['songs'] = $songList;
$_SESSION['words'] = $words;
//creating classes

class artistClass{
    private $artistID;
    private $name;
    private $songList = array();


    public function setName($in_name){
        $name = $in_name;
    }
    public function getName(){
        return $name;
    }
    public function addSong($in_song){
        $length = count($songList);
        $songList[$length] = $in_song;
    }
    public function getSong(){
        return $songList;
    }

}

class songClass{
    private $songID;
    private $songName;
    private $lwords;//an array of the words
    private $lyrics;//an array of words
    private $artistID;

    public function setID($in_id){
        $songID = $in_id;
    }
    public function setName($in_name){
        $songName = $in_name;
    }
    public function setLyrics($in_lyrics){
        $lyrics = $in_lyrics;
    }
    public function getLyrics(){
        return $lyrics;
    }
    public function setArtist($in_artist){
        $artistID = $in_artist;
    }
    //return the count of an given word in that song.
    public function returnCount($in_word){
        $count = 0;
        foreach ($lwords as $word ) {
            if($word == $in_word){
                $count++;
            }
        }
        return $count;
    }
}

class wordClass{
    private $artistID;
    private $songID;//list of song that contains this word
    private $count;

    public function getFreq(){
        return $count;
    }

}

//the following function sort the word with ascending value 
function cmpWord($word1, $word2){
    if($word1->$count == $word2->$count){
        return 0;
    }
    return($word1->$count < $word2->$count) ? -1 : 1;
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
    
    $json = json_decode($output);
    $array = $json->{'toptracks'}->{'track'};
    $arraycount = count($array);
    global $songList;
    for($i = 0; $i<$arraycount; $i++){
        $each = $array[$i];
        //adding each name to the name array
        array_push($songList, $each->{'name'});
    }

    $tempurl = "https://lyric-api.herokuapp.com/api/find/justin%20bieber/baby";
    $temp_defaults = array(
        // CURLOPT_URL => 'http://ws.audioscrobbler.com/2.0/?',
        CURLOPT_URL => $tempurl,
        CURLOPT_POST => false,
        // CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true);

    $cht = curl_init();
    curl_setopt_array($cht, $temp_defaults);
    $outputt = curl_exec($cht);
    curl_close($cht);

    $jsont = json_decode($outputt) ;
    $jsont = $jsont->{"lyric"};
    echo "miehahahahahahaha:   <br>";
    echo $outputt;
    echo "<br><br><br>";
    var_dump($jsont) ;
    echo "<Br> end of miehhhhhh";

    // print_r($output);
}

    // var_dump($songList);

$q = $_REQUEST["q"];
// echo"this is the request ".$q."<Br>";
$hint = "";
if ($q !== "") {
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
    $return = array("songs"=>$songList);

    $return = json_encode($return);
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


?>




