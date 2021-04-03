<?php
/*
 * filename: nameGallery.php
 * this code saves the SQL database gallery name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$namegallery = 'AnImageGallery'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['namegallery'] == '')) { // empty POST then fallback value
	$_SESSION["namegallery"] = $namegallery;
	header("Refresh: 1; URL=./index1.php");
	echo "$namegallery is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['namegallery'])) && ($_POST['namegallery'] != '')) {
	$namegallery = trim($_POST['namegallery']);
	//sanitize string
	if (preg_match('/^([A-Za-z0-9]+$)/', $namegallery)) {
		$_SESSION["namegallery"] = $namegallery;
		header("Refresh: 1; URL=./index1.php");
		echo "$namegallery is a valid string.<br/><br/>";
	} else {
		$_SESSION["namegallery"] = '';
		header("Refresh: 1; URL=./index1.php");
		echo "$namegallery is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
