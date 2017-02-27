<?php  
require_once('classes.php');

session_start();


$artistList = $_SESSION['artists'];
$songList = $_SESSION['songs'];
$wordList = $_SESSION['words'];

$q = $_REQUEST["song_id"];

$song_word = $songList[0]->getWordArray();

echo json_encode($song_word);
?>