<?php
/*
 * filename: Portal.php
 * this code processes the Facebook user authentication
 * and the uploading images OR deleting images/account dialog
*/

// disable error reporting for production
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
//	@session_start();
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");
	
require "/home/bitnami/GalleriesUser/htdocs/Login.php";

$head1 = <<<EOT
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Logon Portal</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Facebook Logon Portal">
	<meta name="copyright" content="Copyright 2021 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="facebook application">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/GalleryBuilder/">
<!--	<link href="https://SyntheticReality.net/GalleryBuilder/" rel="canonical"> -->
    <!-- Bootstrap core CSS -->
	<link href="/Galleries/css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="/Galleries/css/mdb.min.css">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryCreator.css" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryBuilder.css" rel="stylesheet" type="text/css">
  <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="/GalleriesUser/favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="/GalleriesUser/favicon.ico" type="image/x-icon">
<!-- set up our cache choices -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
</head>
<!-- Build out the page -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
<!--#include file="/Galleries/includes/browserupgrade.ssi" -->
<main class="pageWrapper d-flex row flex-row row-no-gutters justify-content-center" id="container">
<h1 class="sr-only">This is the login entry page for the Synthetic Reality gallery builder.</h1>
<!--------------------------------------->
<!-- Include the facebook javascript SDK -->
<script>
window.fbAsyncInit = function() {
	FB.init({
		appId      : '2917501244986193',
		xfbml      : true,
		version    : 'v8.0'
	});
	FB.AppEvents.logPageView();
};
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<style>
#prevpagebutton {
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 2.4vw;
}
#nextpagebutton {
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 2.4vw;
}

</style>
EOT2;
echo $head2;
echo
'<!-- ++++++++++++++++++++++ -->'.
'<!-- Logo and name -->'.
'<header class="myHeaderTall" id="myHeader">'.
'<img class="Logo" id="Logo" src = "./images/IsoBlockLOGO.gif" alt="rotating IsoBlock sphere"><div class="sitename" id="sitename" >Synthetic<br>Reality</div>'.
'<div class="siteSubtitle">Gallery Builder</div></header>'.
'<div class="row justify-content-end fixed-top">
    <nav title="jump to the Galleries" class="btn btn-sm btn-yellow accent1">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="galleriesHome" class="bi-layout-wtf"
		 width="75px" height="50px" viewBox="0 0 16 12" fill="red" stroke="blue"><path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/><path d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
		<a xmlns="http://www.w3.org/2000/svg" id="anchor" xlink:href="https://syntheticreality.net/Galleries/Galleries.php" xmlns:xlink="http://www.w3.org/1999/xlink" target="_top"><rect x="0" y="0" width="100%" height="100%" fill-opacity="0"/></a>
		</svg>
    </nav>
</div>';
//display the page function message
$pagetask1 = <<<EOT1
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- the message -->
EOT1;
echo $pagetask1;

require_once '/home/bitnami/GalleriesUser/htdocs/User.class.php';
    // Initialize User class
    $user = new User();

// see how many users we have
$userCount = $user->userCount();
//$userCount = 256;
// do we limit user count?
$maxUserCount = 256;
$userCountMsg = '';
if($userCount >= $maxUserCount) {
	$userCountMsg .= '<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
	$userCountMsg .= '<section<p>The current number of Hosted Galleries is '.$userCount.'.</p>';
	$userCountMsg .= '<p>The maximum number of Galleries permitted is '.$maxUserCount.'.</p>';
	$userCountMsg .= '<p>New Galleries can not be added at this time. Existing Galleries can be deleted.</p> <section>';
}
$_SESSION['userCountMsg'] = $userCountMsg;

// log the user in
if($output === '') {
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">'.
	'<h1 style="color:indigo;">Logon Portal</h1>'.
	'<h2 style="color:purple;">This page manages logons using your Facebook account.</h2>'.
	'<p style="display:block;padding:1vw;" id="mustLoginNotice">To manage content in this application you must log in as a Facebook user and you must agree to the <a href="../TermsOfService.html" title="jump to the Terms of Service agreement">&ldquo;Terms of Service&ldquo;</a></p>'.
	'<p style="display:block;padding:1vw;">We would appreciate a Facebook &ldquo;Like&rdquo; for the Synthetic Reality Gallery Builder application, and you can do that easily with a click...<br><div class="fb-like" data-href="https://www.facebook.com/profile.php?id=100057452229331" data-width="47" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div></p><br>';
	if($userCountMsg != '') {
		echo $userCountMsg;
	}	
	echo '<!-- the facebook login button -->'.
	$FBloginButton;
	echo '</section>';
}

// user is logged in
if ($output != '') {
$postsCount = $_SESSION['posts'];
	if($postsCount == 0) {
		echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">'.
	'<h1 style="color:indigo;">Logon Portal</h1>'.
	'<h2 style="color:purple;">Welcome. You are logged on to the Synthetic Reality Gallery Builder.</h2>'.
	'<div style="color:#ff8000;border: .3vw solid blue;width:70vw;margin: 2vw;background:#d0d0d0;">';
		if($userCountMsg != '') {
			echo $userCountMsg.'</div></section>';
		} else {
			echo
			'<h3 style="color:indigo;">Click Next in the Footer below to create a Gallery</h3></div></section>';
		}
	} else {
	// user is logged in and has a Gallery
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">'.
		'<h1 style="color:indigo;">Logon Portal</h1>'.
		'<h2 style="color:purple;">Welcome. You are logged on to the Synthetic Reality Gallery Builder.</h2>'.
		'<h3 style="color:DarkBlue;">You can Share your Gallery to Facebook.</h3>'.
		'<form class="msgBox" id="shareForm" action="/GalleriesUser/Share.php" method="post">'.
		'<label style="color:DarkBlue;text-align:center;">Share the Gallery on Facebook:<input class="checkbox" type="checkbox" id="shareCheckbox" name="shareCheckbox" value="1" checked hidden><br>'.
		'<input type="submit" value="&emsp; Click here to Share the Gallery on Facebook."></label></form><br>'.
		'<hr style="padding: .3vw;width: 60vw;height: .2vw;background-color: red;"><br>'.
		'<h3 style="color:DarkBlue;text-align:center;">Each User may have ONE, and ONLY ONE, Gallery at a time.<br>Since you already have a Gallery you must delete it before you can create another one.</h3>'.
		'<h3 style="color:#000000;text-align:center;margin-top:1vw;"><span class="msgBox" style="color:DeepPink;">&emsp;NOTE THAT THE DELETE ACTION CANNOT BE UNDONE !&emsp;</span><br>After your account and content is deleted you may log back in to create a new Gallery.</h3>';
		echo //'<!-- the magic delete user form -->'.
		'<form class="msgBox" id="confirmForm" action="./GallerysUser/contentManager.php" method="post">'.
		'<label style="color:DarkBlue;text-align:center;">Delete your Storybook user content:<br><input class="checkbox" type="checkbox" id="deleteCheckbox" name="deleteALL" value="1">&ensp;Check this box to confirm that you wish to delete ALL of your uploaded image content and account data from the SyntheticReality Storybook Gallery Builder application.<br><br>'.
		'<input type="submit" name="submit" value="&ensp;Click here to&ensp;DELETE ALL OF YOUR IMAGE CONTENT AND ACCOUNT DATA.&ensp;"/></label>'.
		'</form></section>';
	}

	// in either case display the user profile
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-4 px-sm-0 infoBox"><div class=" profile-data-box" style="display:block;" id="profile">'.
	'<!-- the facebook profile info -->'.
	'<br>'.
	$output . '</div></section>';
}

if ($output == '') {
		echo
		'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 orngBox" id="ComicFooter">'.
		'<nav><p><a id="prevpagebutton" href="/Galleries/Galleries.php" title="return to the Galleries">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
	<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
	fill="#000000" stroke="none">
	<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
	c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
	0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
	-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
	c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
	13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
	-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
	-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
	-51z"/>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'</p></nav>'.
		'</footer>';
}

if ($output != '') {
	$postsCount = $_SESSION['posts'];
	if($postsCount == 0) {
		//echo $postsCount.'<br>';
		echo
		'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 orngBox" style="margin-left:0;" id="ComicFooter">'.
		'<p><nav><a id="prevpagebutton" href="/Galleries/Galleries.html" title="return to the Galleries">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
	<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
	fill="#000000" stroke="none">
	<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
	c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
	0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
	-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
	c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
	13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
	-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
	-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
	-51z"/>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./index.php" title="go to the Galleries Builder">Next ❯</a></nav></p>'.
		'</footer>';
	} else {
		echo
		'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 orngBox" style="margin-left:0;" id="ComicFooter">'.
		'<p><nav><a id="prevpagebutton" href="/Galleries/Galleries.html" title="return to the Galleries">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
	<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
	fill="#000000" stroke="none">
	<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
	c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
	0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
	-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
	c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
	13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
	-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
	-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
	-51z"/>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'</nav></p>'.
		'</footer>';
	}
}
echo
'</main>'.
'<!-- End of the web page display -->'.
'<!-- ====================== -->'.
'<script src="../js/jquery.min.js"></script>'.
'<script src="../js/context.js"></script>'.
'<script src="../js/isoblockLogo.js"></script>'.
'<!-- +++++++++++++++++++++++ -->'.
'<!-- End of the web page -->'.
'</body>'.
'</html>';
?>