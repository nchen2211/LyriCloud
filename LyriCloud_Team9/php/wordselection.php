<?php 		
require_once('classes.php');
session_start();

$stored_words = $_SESSION["longString"];

$request = $_REQUEST["request"];

if($request == "yes"){
	echo $stored_words;
}

?>