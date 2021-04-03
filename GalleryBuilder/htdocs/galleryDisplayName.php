<?php
/*
 * filename: galleryDisplayName.php
 * this code saves the gallery display name in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$gallerydisplayname = 'My First Image Gallery'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['gallerydisplayname'] == '')) { // empty POST then fallback value
	$_SESSION["gallerydisplayname"] = $gallerydisplayname;
	header("Refresh: 1; URL=./index.php");
	echo "$gallerydisplayname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['gallerydisplayname'])) && ($_POST['gallerydisplayname'] != '')) {
	$gallerydisplayname = trim($_POST['gallerydisplayname']);
	//sanitize string
	$gallerydisplayname = filter_var($gallerydisplayname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($gallerydisplayname != '') {
		$_SESSION["gallerydisplayname"] = $gallerydisplayname;
		header("Refresh: 1; URL=./index.php");
		echo "$gallerydisplayname is a valid string.<br/><br/>";
	} else {
		$_SESSION["gallerydisplayname"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$gallerydisplayname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
