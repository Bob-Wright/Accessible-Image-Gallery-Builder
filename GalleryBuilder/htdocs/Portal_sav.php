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
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="facebook application">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/">
<!--	<link href="https://SyntheticReality.net" rel="canonical"> -->
	<link href="/Galleries/css/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link href="/Galleries/css/main.css" rel="stylesheet"> -->
	<link href="/Galleries/css/PrivacyPolicy.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="/Galleries/css/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./GalleriesUser/favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./GalleriesUser/favicon.ico" type="image/x-icon">
<!-- set up our cache choices -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
</head>
<body style="cursor: default;">
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
#galleryFooter{
	text-align: center;
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 1.8vw;
	margin: auto;
	width: 100%;
	border: .2vw solid red;
	background: #f0f0f0;
}
</style>
<!-- # include file="/Galleries/includes/browserupgrade.ssi" -->
<main class="pageWrapper" id="container">
<!-- ++++++++++++++++++++++ -->
<!-- Logo and name -->
EOT2;
echo $head2;

$logolist = file_get_contents("https://syntheticreality.net/images/IsoBlock.LL");
if((substr($logolist, -1)) == ',') {    // strip trailing comma
	$logolist = substr($logolist, 0, -1);
}
$logofiles = explode(",", $logolist);
$logocount = count($logofiles);
$js_array = json_encode($logofiles);

echo
'<!-- ++++++++++++++++++++++ -->'.
'<!-- Logo and name -->'.
'<header class= "myHeader" id="myHeader">'.
'<script>'.
'var logocount = '.$logocount.';'.
'var logoindex = logocount - 1;'.
'function toggleLogo() {'.
'var logo = '.$js_array.';'.
'var logofile = logo[logoindex];'.
'document.getElementById("Logo").src = "https://syntheticreality.net/images/" + logofile;'.
'if(logoindex == 0) {'.
'logoindex = logocount-1;'.
'}else{'.
'logoindex = logoindex - 1;'.
'}}'.
'</script>'.
'<img class="Logo" id="Logo" src = "https://syntheticreality.net/images/'.$logofiles[1].'" alt="Logo"><button class="toggleLogo" onclick="toggleLogo()"></button><div class="sitename" id="sitename" >IsoBlock</div>'.
'<span class="siteSubtitle">Synthetic Reality Division</span>'.
'</header>'.
'<button class="toggleMenu" id="toggleMenu"><div><a href="https://syntheticreality.net/Galleries.php"><strong><span class="mdi mdi-home"></span></strong></a></div></button>';

//display the page function message
$pagetask1 = <<<EOT1
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- the message -->
<div class="article-wrapper">
<article class="textcontent">
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
	$userCountMsg .= '<p>The current number of Hosted User Galleries is '.$userCount.'.</p>';
	$userCountMsg .= '<p>The maximum number of User Galleries permitted is '.$maxUserCount.'.</p>';
	$userCountMsg .= '<p>New Galleries can not be added at this time. Existing Galleries can be deleted.</p>';
}
$_SESSION['userCountMsg'] = $userCountMsg;

// log the user in
if($output === '') {
	echo
	'<h1 style="text-align:center;margin-top:1vw;">Logon Portal</h1>'.
	'<h2 style="text-align:center;">This page manages logons using your Facebook account.</h2>'.
	'<p style="display:block;" id="mustLoginNotice"><strong>To manage content in this application you must log in as a Facebook user and you must agree to the &ldquo;Terms of Service".</strong></p>';
	if($userCountMsg != '') {
		echo $userCountMsg;
	}	
	}
// display the login button
if($output === '') {
	echo
	'<!-- the facebook login button -->'.
	$FBloginButton;
}

// user is logged in
if ($output != '') {
$postsCount = $_SESSION['posts'];
	if($postsCount == 0) {
		echo
		'<h1 style="color:purple;text-align:center;margin-top:1vw;">Your Logon Was Successful. Welcome to the SyntheticReality Gallery Builder.</h1><div style="color:#ff8000;border: .3vw solid blue;width:90vw;margin: 2vw;background:#808080;">';
		if($userCountMsg != '') {
			echo $userCountMsg.'</div>';
		} else {
			echo
			'<h2 style="color:#ff8000;background:#808080;text-align:center;margin-top:1vw;">Click Next in the Footer below to create a Gallery</h2></div>';
		}
	} else {
	// user is logged in and has a gallery
		echo
		'<h1 style="color:purple;text-align:center;margin-top:1vw;">Your Logon Was Successful. Welcome to the SyntheticReality Gallery Builder.</h1>'.
		'<div style="border: .3vw solid blue;width:90vw;margin: 2vw;background:#808080;">'.
		'<h2 style="color:#ff8000;text-align:center;margin-top:1vw;">You can Share your Gallery to Facebook.</h2>'.
		'<center><form id="shareForm" name="shareForm"action="../GalleriesUser/Share.php" method="post">'.
		'<input class="checkbox" type="checkbox" id="shareCheckbox" name="shareCheckbox" value="1" checked hidden>&ensp;'.
		'<input type="submit" value="&emsp; Click here to Share the Gallery on Facebook.&emsp;"></form></center><br>'.
		'<hr style="padding: .3vw;width: 60vw;height: .2vw;background-color: red;">'.
		'<h2 style="color:#ff8000;text-align:center;margin-top:1vw;">Each User may have ONE, and ONLY ONE, Gallery at a time.<br>Since you already have a gallery you must delete it before you can create another one.</h2>'.
		'<h2 style="color:#000000;text-align:center;margin-top:1vw;"><span style="color:#fff000;text-align:center;margin-top:1vw;">NOTE THAT THE DELETE ACTION CANNOT BE UNDONE !</span><br>After your account and content is deleted you may log back in to create a new gallery.</h2>';
		echo //'<!-- the magic delete user form -->'.
		'<center><form id="confirmForm" name="confirmForm" action="./GalleriesUser/contentManager.php" method="post">'.
		'<input class="checkbox" type="checkbox" id="deleteCheckbox" name="deleteALL" value="1">&ensp;Check this box to confirm that you wish to delete ALL of your uploaded image content and account data from the SyntheticReality Gallery Builder application.<br><br>'.
		'<input type="submit" name="submit" value="&ensp;Then click here to&ensp;DELETE ALL IMAGE CONTENT AND ACCOUNT DATA.&ensp;"/>'.
		'</form></center><br>'.
		'</div>';
	}

	// in either case display the user profile
	echo
	'<div class="profile-data-box" style="display:block;" id="profile">'.
	'<!-- the facebook profile info -->'.
	'<br>'.
	$output . '</div>';
}
echo
	'</article>'.
	'</div>';

if ($output == '') {
		echo
		'<footer id="myFooter">'.
		'<div id="galleryFooter"><a id="prevpagebutton" href="../GalleryBuilder.php">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'</div>'.
		'</footer>';
}

if ($output != '') {
	$postsCount = $_SESSION['posts'];
	if($postsCount == 0) {
		echo $postsCount.'<br>';
		echo
		'<footer id="myFooter">'.
		'<div id="galleryFooter"><a id="prevpagebutton" href="../GalleryBuilder.php">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./GalleryBuilder/index.php">Next ❯</a></div>'.
		'</footer>';
	} else {
		echo
		'<footer id="myFooter">'.
		'<div id="galleryFooter"><a id="prevpagebutton" href="../GalleryBuilder.php">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'</div>'.
		'</footer>';
	}
}
echo
'</main>'.
'<!-- End of the web page display -->'.
'<!-- ====================== -->'.
'<script src="./js/jquery.min.js"></script>'.
'<script src="./js/context.js"></script>'.
'<script src="./js/logoSwap.js"></script>'.
'<script src="./js/swipe.js"></script>'.
'<script src="./js/isoblockLogo.js"></script>'.
'<!-- +++++++++++++++++++++++ -->'.
'<!-- End of the web page -->'.
'</body>'.
'</html>';
?>