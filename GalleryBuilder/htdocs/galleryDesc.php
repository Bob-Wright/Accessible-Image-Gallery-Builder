<?php
/*
 * filename: galleryDesc.php
 * this code saves the gallery display subtitle in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$gallerydesc = 'This is a sample gallery description/subtitle'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['gallerydesc'] == '')) { // empty POST then fallback value
	$_SESSION["gallerydesc"] = $gallerydesc;
	header("Refresh: 1; URL=./index.php");
	echo "$gallerydesc is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['gallerydesc'])) && ($_POST['gallerydesc'] != '')) {
	$gallerydesc = trim($_POST['gallerydesc']);
	//sanitize string
	$gallerydesc = filter_var($gallerydesc, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($gallerydesc != '') {
		$_SESSION["gallerydesc"] = $gallerydesc;
		header("Refresh: 1; URL=./index.php");
		echo "$gallerydesc is a valid string.<br/><br/>";
	} else {
		$_SESSION["gallerydesc"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$gallerydesc is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
