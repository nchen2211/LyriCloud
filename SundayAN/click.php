<?php 

require_once('classes.php');
session_start();

$artistList = $_SESSION['artists'];
$songList = $_SESSION['songs'];
$wordList = $_SESSION['words'];


// echo "<br>this is a new page"."<br>";

// var_dump($songList[0]);

$clickedWord = $_REQUEST["clicked_word"];
// $clickedWord = "but";
// var_dump($clickedWord);
if($clickedWord != ""){
    // echo "shouldn't see this".$clickedWord;
    $to_return = countFreq($clickedWord);
    // $to_return = countFreq("but");
    // echo "<br> here is to return: <br>";
    // var_dump($to_return);
    $to_return = json_encode($to_return);
    echo $to_return;

}


?>