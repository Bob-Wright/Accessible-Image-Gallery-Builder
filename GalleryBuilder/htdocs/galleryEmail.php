<?php
/*
 * filename: galleryEmail.php
 * this code saves the site Email address in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$galleryemail = 'GalleryCreator@syntheticreality.net'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['galleryemail'] == '')) { // empty POST then fallback value
	$_SESSION["galleryemail"] = $galleryemail;
	header("Refresh: 1; URL=./index.php");
	echo "$galleryemail is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['galleryemail'])) && ($_POST['galleryemail'] != '')) {
	$galleryemail = trim($_POST['galleryemail']);
	//sanitize string
    $galleryemail = filter_var($_POST['galleryemail'], FILTER_SANITIZE_EMAIL);
    if (filter_var($galleryemail, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["galleryemail"] = $galleryemail;
		header("Refresh: 1; URL=./index.php");
		echo "$galleryemail is a valid string.<br/><br/>";
	} else {
		$_SESSION["galleryemail"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$galleryemail is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}


?>
