<?php
/*
 * filename: getConfig.php
 * this code gets the previously saved gallery config file name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$getconfig = 'GalleryConfig1'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['getconfig'] == '')) { // empty POST then fallback value
	$_SESSION["getconfig"] = $getconfig;
	header("Refresh: 1; URL=./index.php");
	echo "$getconfig is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['getconfig'])) && ($_POST['getconfig'] != '')) {
	$getconfig = trim($_POST['getconfig']);
	//sanitize string
	$getconfig = filter_var($getconfig, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($getconfig != '') {
		$_SESSION["getconfig"] = $getconfig;
		header("Refresh: 1; URL=./index.php");
		echo "$getconfig is a valid string.<br/><br/>";
	} else {
		$_SESSION["getconfig"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$getconfig is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
