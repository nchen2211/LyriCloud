<?php
session_start();
//initialize variables
$artistList = array();// stores a list of artist
$songList = array();
$wordList = array();
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
        $this->name = $in_name;
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
    private $songName = "hhhhh";
    private $lwords;//an array of the words
    private $lyrics;//an array of words
    private $artistID;

    public function setID($in_id){
        $this->songID = $in_id;
    }
    public function setName($in_name){
        // var_dump($songName);
        $this->songName = $in_name;
        // echo $this->songName;
    }
    public function getName(){
        return $this->songName;
    }
    public function setWordArray($in_array){
        $this->lwords = $in_array;
    }
    public function setLyrics($in_lyrics){
        $this->lyrics = $in_lyrics;
    }
    public function getLyrics(){
        return $this->lyrics;
    }
    public function setArtist($in_artist){
        $this->artistID = $in_artist;
    }
    //return the count of an given word in that song.
    public function returnCount($in_word){
        $count = 0;
        foreach ($this->lwords as $word ) {
            if($word == $in_word){
                // echo "<br>here is a match<br>";
                $count++;
            }
        }
        return $count;
    }
}

class wordClass{
    private $my_word;
    // private $my_freq;
    private $artistID;
    private $song_array;//list of song that contains this word
    //each entry in song_array is a map:
    //songID->
    //songName->
    //Freq->
    // private $count;

    public function setWord($in_word){
        $this->my_word = $in_word;
    }
    // public function setFreq($in_freq){
    //     $my_freq = $in_freq;
    // }
    
    public function getFreq(){
        return $count;
    }
    public function setSongList($in_array){
        $this->song_array = $in_array;
    }
    public function getSongID(){//return the song id
        $idList = array();
        foreach ($this->song_array as $each_song) {
            # code...
            $each_id = $each_song["songID"];
            array_push($idList, $each_id);
        }
        return $idList;
    }
    public function getSongLyrics($in_id){
        global $songList;
        $entry = $song_array[$in_id];
        $id = $entry["songID"];
        $Lyrics = $songList[$id].getLyrics();
        return $Lyrics;
    }

}

//the following function sort the word with ascending value 
function cmpWord($word1, $word2){
    if($word1->$count == $word2->$count){
        return 0;
    }
    return($word1->$count < $word2->$count) ? -1 : 1;
}



function countFreq($in_word){
    global $songList;
    // var_dump($songList);
    global $wordList;
    // array_push($wordList, $in_word);
    $return_songs = array();

    // for($i = 0; $i< count($songList); $i++){
       for($i = 0; $i< 5; $i++){

    // foreach ($songList as $song) {
        # code...
        // echo "<br>this is the loop  ".$i."<br>";
        $key0 = "songID";
        $key1 = "songname";
        $key2 = "freq";
        $word_count = $songList[$i]->returnCount($in_word);
        if($word_count > 0){
            // $entry =  array("songID" =>$i , "songname" => $song.getName(), "freq" => $word_count);
            
            $entry =  array($key0 =>$i , $key1 => $songList[$i]->getName(), $key2 => $word_count);
            array_push($return_songs, $entry);
        }
        //put the frequency info into the word Class
        $new_word = new wordClass();
        $new_word->setWord($in_word);
        $new_word->setSongList($return_songs);

        array_push($wordList, $new_word);
        //we can 
    }
    return $return_songs;

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
    for($x = 0; $x < 5; $x++){
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


$clickedWord = $_REQUEST["clicked_word"];
// var_dump($clickedWord);
if($clickedWord != ""){
    echo "shouldn't see this".$clickedWord;
    $to_return = countFreq($clickedWord);
    echo "<br> here is to return: <br>";
    var_dump($to_return);
    $to_return = json_encode($to_return);

}


?>




