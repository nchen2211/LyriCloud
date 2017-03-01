<?php  
require_once('classes.php');

session_start();


$artistList = $_SESSION['artists'];
$songList = $_SESSION['songs'];
$wordList = $_SESSION['words'];

$song_id= $_REQUEST["song_id"];

$song_word = $songList[$song_id]->getLyrics();

echo json_encode($song_word);
?>