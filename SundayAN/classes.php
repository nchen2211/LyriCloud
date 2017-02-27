<?php  

session_start();


$artistList = $_SESSION['artists'];
$songList = $_SESSION['songs'];
$wordList = $_SESSION['words'];
$str = $_SESSION['longString'];

class artistClass{
    private $artistID;
    private $name;
    private $start;
    private $end;


    public function setName($in_name){
        $this->name = $in_name;
    }
    public function getName(){
        return $this->name;
    }
    // public function addSong($in_song){
    //     $length = count($songList);
    //     $songList[$length] = $in_song;
    // }
    // public function getSong(){
    //     return $songList;
    // }
    public function setRangeStart($in_start){
        $this->start = $in_start;
    }
    public function setRangeEnd($in_end){
        $this->end = $in_end;
    }
    public function getRangeStart(){
        return $this->start;
    }
    public function getRangeEnd(){
        return $this->end;
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
    public function getWordArray(){
        return $this->lwords;
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

function countFreq($in_word){
    global $songList;
    // var_dump($songList);
    global $wordList;
    // array_push($wordList, $in_word);
    $return_songs = array();

        // session_unset();
// session_destroy();
    // echo count($songList);
    for($i = 0; $i< count($songList); $i++){
       // for($i = 0; $i< 2; $i++){

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
?>