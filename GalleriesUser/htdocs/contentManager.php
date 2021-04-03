<?php
/*
 * filename: contentManager.php
 * this code processes the delete images and users request
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
//	@session_start();
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");

	// there are images for this user
$headhtml = <<<EOT
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Content Manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta name="description" content="Part of SyntheticReality Gallery Builder">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="facebook application">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/">
<!--	<link href="https://syntheticreality.net/ArtSee" rel="canonical"> -->
	<link href="./CSS/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link href="./CSS/main.css" rel="stylesheet"> -->
	<link href="./CSS/PrivacyPolicy.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./CSS/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./CSS/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="./CSS/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./ArtSee/favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./ArtSee/favicon.ico" type="image/x-icon">
<!-- set up our cache choices -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
</head>
<body>
<!-- #echo var="QUERY_STRING_UNESCAPED" -->
<div class="pageWrapper" id="container el">
EOT;
echo $headhtml;

// get the facebook logout url
$location = "https://syntheticreality.net/ArtSee/logout.php";
// check that form was actually submitted
if(!(isset($_POST['deleteALL']))){
	// no, get the no form msg
	require '/home/bitnami/ArtSee/htdocs/Messages/noFormMsg.php';
	$_SESSION['logoutMsg'] = $logoutMsg;
	// Redirect to the logout URL													
	$seconds = 0;
	header ("Refresh: $seconds; URL=$location");
}

if(isset($_SESSION['oauth_id'])) {
	$UserID = ($_SESSION['oauth_id']);}
include '/home/bitnami/GalleryBuilder/htdocs/rrmdir.php';
require("/home/bitnami/includes/Gallery.class.php");
	$gallery = new Gallery();
// Galleries folder path
$Galleries = '/home/bitnami/Galleries/htdocs/';
require '/home/bitnami/ArtSee/htdocs/User.class.php';
	$user = new User();

	// $userData = $user->returnUser($UserID);
	$userData = $user->returnUser($UserID);

	$galleryname = $userData['gallery_name'];
	echo '<h2>User ID = '.$UserID.'</h2>';
	echo '<h2>Gallery Name = '.$galleryname.'</h2>';

	//clean up gallery files
	if(file_exists($Galleries.$galleryname.'OGIMG.png')) {
		$result = unlink($Galleries.$galleryname.'OGIMG.png');
		echo '<h2>Deleted '.$galleryname.'OGIMG.png</h2>';}
	if(file_exists($Galleries.$galleryname.'.html')) {
		$result = unlink($Galleries.$galleryname.'.html');
		echo '<h2>Deleted '.$galleryname.'.html</h2>';}
	$folder = $Galleries.$galleryname;
	rrmdir($folder);
	echo '<h2>Deleted '.$galleryname.' Folder</h2>';

	// clear the GalleryBuilder database
	//$imageList = $gallery->listGallery($galleryname, true);
	$imageList = $gallery->deleteGallery($galleryname);
	echo '<h2>Deleted '.$galleryname.' from Gallery Database</h2>';
	
	// clear the User database
	$userData = $user->deleteUser($UserID);
	echo '<h2>Deleted '.$UserID.' from User Database</h2>';

	// Redirect to the logout URL													
	$seconds = 5;
	header ("Refresh: $seconds; URL=$location");

echo
	'<!-- ++++++++++++++++++++ -->'.
	'<!-- Java script section -->'.
	'<!-- Placed at the end of the document so the page loads faster -->'.
	'<script src="../js/jquery-3.3.1.min.js"></script>'.
	'<script src="../js/context.js"></script>'.
	'<script src="../js/swipe.js"></script>'.
	'<!-- End of the Java script section-->'.
	'<!-- ======================= -->'.
	'<script src="../js/isoblockLogo.js"></script>'.
	'</div></body></html>';

?>