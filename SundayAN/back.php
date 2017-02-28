<?php  
require_once('classes.php');

session_start();


$artistList = $_SESSION['artists'];
$songList = $_SESSION['songs'];
$wordList = $_SESSION['words'];

$back= $_REQUEST["backCloud"];

//$wordList = $wordlist;

echo json_encode($wordList);
?>