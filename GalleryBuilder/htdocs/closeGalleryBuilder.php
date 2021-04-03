<?php
/*
 * This file closes the session
*/
// Start session
//if ((session_status() == PHP_SESSION_NONE) || (session_status() !== PHP_SESSION_ACTIVE)) {
	//if(session_id() == ""){
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
	//	session_start();

$Galleries = '/home/bitnami/Galleries/htdocs/';
$return = '';
if((isset($_SESSION['galleryname'])) && ($_SESSION['galleryname'] != '')) {
	$galleryname = $_SESSION['galleryname'];
	if(file_exists($Galleries.$galleryname .'.zip')) {
		$result = unlink($Galleries.$galleryname.'.zip');}

	if(file_exists($Galleries.$galleryname .'.html')) {
		$return = 'Galleries/'.$galleryname .'.html';}
}

if($return === '') {
	$defaultReturn = "Galleries.php";
	$return = $defaultReturn;
	}

// get our host URL
$siteurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/Galleries/";
$location = $siteurl . $return;
$seconds = 1;

// Unset all of the session variables.
$_SESSION = array();
session_unset();

// destroy all session variables
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }

//remove PHPSESSID from browser
if(isset($_COOKIE[session_name()])) {
setcookie(session_name(), "", time()-3600, "/" );
}

header ("Refresh: $seconds; URL=$location");
echo 'Exiting & closing session';
?>