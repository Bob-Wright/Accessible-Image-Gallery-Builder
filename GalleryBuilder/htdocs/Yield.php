<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// -----------------------
// Start session
//require_once '../session2DB/Zebra.php';
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");
include './ZipListOfFilesOrFolders.php';
include './rrmdir.php';
require("/home/bitnami/includes/Gallery.class.php");
	$gallery = new Gallery();
// Galleries folder path
$Galleries = '/home/bitnami/Galleries/htdocs/';
require("/home/bitnami/GalleriesUser/htdocs/User.class.php");

$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>GalleryBuilder Creator</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Art, Images, & Prosody by Bob Wright">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="comics,art,drawing,sketching,watercolor,ink,pencils,artist,graphics,poetry,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/GalleryBuilder/">
	<link href="https://syntheticreality.net" rel="canonical">
    <!-- Bootstrap core CSS -->
	<link href="/Galleries/css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="/Galleries/css/mdb.min.css">
	<link rel="stylesheet" href="/Galleries/css/LiteThemes.css">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryCreator.css" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryBuilder.css" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<script>
// use <img onload="countdown()" src="./images/1x1pixel.png">
// and <h2>There are <span id="timeLeft"></span> seconds remaining.</h2>

// simple on timeout change page
//function timeoutDelay() {
//	setTimeout(loadPage, 30*1000);
//}
//function loadPage() {
//	alert("reached timeoutDelay");
	//window.location.replace("https://syntheticreality.net/GalleryBuilder/closeGalleryBuilder.php");
//};

// timeout with countdown timer
var timecount = 11;
function countdown() {
	timecount = timecount - 1;
	if (timecount === 0) { loadPage();}
	timecount = checkTime(timecount);
	document.getElementById('timeLeft').innerHTML = timecount;
	setTimeout(countdown, 1000);
}
function checkTime(timecount) {
	if (timecount < 10) {timecount = "0" + timecount};  // pad numbers < 10*
	  return timecount;
}
function loadPage() {
	//alert("reached timeoutDelay");
	//window.location = self.location.href;  //Reloads current page for test
	window.location.replace("https://syntheticreality.net/GalleryBuilder/closeGalleryBuilder.php");
}
function idleTimer() {
    window.onmousemove = resetTimer; // catch mouse
    //window.onmousedown = resetTimer;
    window.onclick = resetTimer;
    window.onscroll = resetTimer; // scrolling
    window.onkeypress = resetTimer;  // keyboard
function resetTimer() {
	clearTimeout();
	timecount = 11;
	console.info("Timer Reset");
}
}
idleTimer();
</script>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->

</head>
<!-- Build out the page -->
<!-- +++++++++++++++++++++++ -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
<!--#include file="./includes/browserupgrade.ssi" -->
<main class="pageWrapper row flex-row row-no-gutters justify-content-center" id="container">
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>
<header><img id="Logo" src = "./images/IsoBlockLOGO.gif" alt="rotating IsoBlock sphere" width="200px" height="200px">
<h2 class="sr-only">This is the entry page for the Image Gallery creator.</h2>
</header>
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>

<!-- ++++++++++++++++++++ -->
<!--  build gallery pages -->
<!-- ++++++++++++++++++++ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- announce who we are -->
<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">
<h1 style="color:blue;">Image Gallery Creator</h1>
</section>
EOT2;
echo $head2;

//echo 'ID = '.session_id();
// if(isset($_COOKIE['Gallery Builder'])) {
	//echo '<h2>'. ($_COOKIE['Gallery Builder']) .'</h2><br>';}

// see if we are hosting the web Gallery
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {$host = true;}
	if((!(isset($_SESSION['gallerysaved']))) || ((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] == 0))) {
		if($host == true) {
			echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 redBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates and hosts an Image Gallery web page using the content that you supplied. It also makes a ZIP archive of the Gallery for you to optionally download.</h2></section>';
		} else {
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 redBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates a ZIP archive download for an Image Gallery webpage using the information that you supplied.</h2><hr style="width: 60vw;height: .3vw;background-color: blue;"><p style="color: #a00020;background: #ffff00;padding: 1vw;">After the Image Gallery archive is generated and prepared for downloading it will be deleted. There is no storage on this site for the generated web Image Gallery archives. The only way to preserve your web Image Gallery is to download it.</p></section>';
		}
	}

//$timeout = ini_get('max_execution_time');
//echo '<p>Execution Timeout in seconds: '.$timeout.'</p>';

// check display session array
$galleryname = '';
if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] === 0)) {
	if((isset($_SESSION['galleryname'])) && ($_SESSION['galleryname'] != '')) {
		$galleryname = $_SESSION['galleryname'];
		echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
			'<h3>Gallery Data from SESSION</h3>'.
			'<div id="configValues">';
			include '/home/bitnami/GalleryBuilder/htdocs/getConfigValues.php';
			echo
			'</section>';
	} else {
		echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
			'<h3>No Gallery Data from SESSION</h3>'.
			'</section>';
	}
} else {
	if((isset($_SESSION['galleryname'])) && ($_SESSION['galleryname'] != '')) {
		$galleryname = $_SESSION['galleryname'];}
}

// see if options are enabled and we have a query string
$galleryFoldername = '';
$skippyLives = false;
if($host == true) {
	$saveC = true;
	} else {
	$saveC = false;}
$saveDB = false;
$useC = false;
if((getenv('QUERY_STRING') != '') && (file_exists("/home/bitnami/includes/options.txt"))) {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	//echo '<p>'; echo var_dump($pstrings); echo '</p>';
	// see if valid URL query string keys exist
	if(array_key_exists('skippy', $pstrings)) {
		$skippyLives = true; }
	if((array_key_exists('saveC', $pstrings)) || ($host === true)) {
		$saveC = true; }
	if(array_key_exists('saveDB', $pstrings)) {
		$saveDB = true; }
	if(array_key_exists('useC', $pstrings)) {
		$useC = true; }

	// retrieve Configuration value selections from a file?
	if(array_key_exists('Gallery', $pstrings)) {
		$galleryFoldername = $pstrings['Gallery'];
		if(file_exists($Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php')) {
			include $Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php';
			$_SESSION['galleryFoldername'] = $galleryFoldername;
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
				'<h3>Gallery Data from the Saved Configuration File</h3>'.
				'<div id="configValues">';
				include '/home/bitnami/GalleryBuilder/htdocs/getConfigValues.php';
			echo
				'</div>'.
				'</section>';
		} else {
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
				'<h3>No Saved Configuration File '.$Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php found</h3>'.
				'</section>';
			$galleryFoldername = '';
			$_SESSION['galleryFoldername'] = '';
		}
	}
}

if(($galleryname == '') && ($galleryFoldername == '')) {
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #ff8800 warning-color-dark lighten-4 px-sm-0 redBox">'.
	'<h2>No Gallery specified!&emsp;No HTML File was written.</h2><br>'.
	'<p>This operation requires a specified gallery -<br></p>'.
	'<p>Returning to the Galleries page.<br></p></section>';
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox"  style="padding-bottom: 0;" id="GalleryFooter">'.
	'<p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p>'.
	'</footer></main>';
	echo
	'<script>setTimeout(function(){window.location.replace("https://syntheticreality.net/GalleryBuilder/closeGalleryBuilder.php");}, 9000);</script></body></html>';
	die();
}

// check to see if we are to use existing content or make a new HTML file
if($useC == false) {
if(!(isset($_SESSION['gallerysaved']))) {$_SESSION['gallerysaved'] = 0;}
if($_SESSION['gallerysaved'] == 0) {
	if(($galleryFoldername != '') && (file_exists($Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php'))) {
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 redBox">'.
		'<h2>Gallery Builder will use the Saved Configuration values</h2>';
		$galleryname = $galleryFoldername;
	} else {
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 h2x-sm-0 redBox">'.
		'<h2>Gallery Builder will use the SESSION Configuration values</h2>';
	}
	echo
	// Gallery.php actually generates and saves the web page
	'<form id="saveComic" action="./makeGallery.php" method="post">'.
	'<label>Create the Gallery:<br><input type="text" id="galleryname" name="galleryname" size="64" value="'.$galleryname.'" hidden>'.
	//'<input type="submit" hidden>'.
	'<input type="submit" value=" Click to create the Gallery! "></label>'.
	'</form>'.
	'</section><br>';
	//echo '<script>document.getElementById("saveComic").submit();</script>';
	// set the gallerysaved flag in Gallery
	// $_SESSION['gallerysaved'] = 1;
} else {
	// be sure Gallery Builder created the web page
	if(file_exists($Galleries.$galleryname.'.html')) {
		//credit the post
		if(isset($_SESSION['oauth_id'])) {
			$UserID = ($_SESSION['oauth_id']);
			// Initialize User class
			$user = new User();
			//echo '<p>SESSION UserData<br>'; print_r($UserData); echo'</p>';
			//credit the post
			$userGallery = $user->updateGalleryname($UserID, $galleryname);
			$userPosts = $user->updatePosts($UserID, 1);
			$userData = $user->returnUser($UserID);
			$_SESSION['userData'] = $userData;
		}
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 msgBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Gallery Files were created using the information that you supplied along with the ';
		if((isset($_SESSION['galleryFoldername'])) && ($_SESSION['galleryFoldername'] != '')) {
			echo
			'Saved Configuration values</h2>';
		} else {
			echo
			'SESSION Configuration values</h2>';
		}
		echo
		'<h2 class="#b0bec5 blue-grey lighten-3" style="color:indigo;padding: 1vw;">You may Share your Gallery to Facebook.</h2>'.
		'<form id="shareForm" name="shareForm"action="../GalleriesUser/Share.php" method="post">'.
		'<label>Share the gallery on Facebook:<br><input class="checkbox" type="checkbox" id="shareCheckbox" name="shareCheckbox" value="1" checked hidden>'.
		'<input type="submit" value="&emsp; Share your Gallery on Facebook.&emsp;"></label></form>';

		if($skippyLives == true) {
			echo
			'<img onload="countdown()" src="./images/1x1pixel.png" alt="dummy image for timer">'.
			'<br>';
			if($host == true) {
				echo
				'<div id="timeoutMsg"><h3>You will be redirected to your newly created Gallery page in <span id="timeLeft"></span> seconds.</h3></div>';
			} else {
				echo
				'<div id="timeoutMsg"><h3>You will be returned to the Galleries home page in <span id="timeLeft"></span> seconds.</h3>';
			}
			//echo
			 //<hr class="new4">';
		}
	echo
		'</section>';
	}
}
/*	if($saveDB === false) {
		// clean the GalleryBuilder database
		//$imageList = $gallery->listGallery($galleryname, true);
		$imageList = $gallery->deleteGallery($galleryname);
	}
*/	
}

if(($useC === true) && !(file_exists($Galleries.$galleryname.'.html'))) {
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #ff8800 warning-color-dark lighten-3 px-sm-0 redBox">'.
	'<h2>No HTML file is present!</h2><br>';
	echo
	'<p>The use current option ($useC) needs a current HTML file!<br></p>'.
	'<p>Returning to the Galleries page.<br></p></section>';
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox" id="ComicFooter">'.
	'<p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p>'.
	'</footer></main>';
	echo
	'<script>setTimeout(function(){window.location.replace("https://syntheticreality.net/GalleryBuilder/closeComicBuilder.php");}, 9000);</script></body></html>';
	die();
}

// if no skippy option present create the ZIP
if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] == 1)) {
if(($skippyLives == false) && (file_exists($Galleries.$galleryname.'.html'))) {
	$ziplist = $Galleries.$galleryname.', '. $Galleries.'Fonts, '. $Galleries.$galleryname.'.html, '. $Galleries.'favicon.ico ,'. $Galleries.'Robots.txt, '. $Galleries.'js, '. $Galleries.'css';
	if(file_exists($Galleries.$galleryname.'OGIMG.png')) {
		$ziplist .= ', '. $Galleries.$galleryname.'OGIMG.png';
	}
	if(file_exists($Galleries.$galleryname.'OGIMG.jpg')) {
		$ziplist .= ', '. $Galleries.$galleryname.'OGIMG.jpg';
	}
/*	if(file_exists($Galleries.$galleryname.'.card')) {
		$ziplist .= ', '. $Galleries.$galleryname.'.card';
	}
	if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.jpg')) {
		$ziplist .= ', '. $Galleries.'coversImg/'.$galleryname.'CARD.jpg';
	}
	if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.gif')) {
		$ziplist .= ', '. $Galleries.'coversImg/'.$galleryname.'CARD.gif';
	}
	if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.png')) {
		$ziplist .= ', '. $Galleries.'coversImg/'.$galleryname.'CARD.png';
	} */
	//echo 'The ZIP contents will be<br>'.$ziplist.'<br>';
	if(file_exists($Galleries.$galleryname.'.zip')) { //make a new zip file
		$result = unlink($Galleries.$galleryname.'.zip');}
	Zip($ziplist, $Galleries.$galleryname.'.zip', true);

	//clean up Gallery files?
	if($saveC === false) {
		if(file_exists($Galleries.$galleryname.'OGIMG.png')) {
			$result = unlink($Galleries.$galleryname.'OGIMG.png');}
		if(file_exists($Galleries.$galleryname.'OGIMG.jpg')) {
			$result = unlink($Galleries.$galleryname.'OGIMG.jpg');}
		if(file_exists($Galleries.$galleryname.'.html')) {
			$result = unlink($Galleries.$galleryname.'.html');}
/*		if(file_exists($Galleries.$galleryname.'.card')) {
			$result = unlink($Galleries.$galleryname.'.card');}
		if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.jpg')) {
			$result = unlink($Galleries.'coversImg/'.$galleryname.'CARD.jpg');}
		if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.gif')) {
			$result = unlink($Galleries.'coversImg/'.$galleryname.'CARD.gif');}
		if(file_exists($Galleries.'coversImg/'.$galleryname.'CARD.png')) {
			$result = unlink($Galleries.'coversImg/'.$galleryname.'CARD.png');} */
		$folder = $Galleries.$galleryname;
		rrmdir($folder);
	}

/*	if($saveDB === false) {
		// clean the Gallery Builder database
		//$imageList = $ComicImages->listComic($galleryname, true);
		$imageList = $ComicImages->deleteComic($galleryname);
	}
*/
	if(file_exists($Galleries.$galleryname.'.zip')) {
		// allow user time limit download Gallery archive
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 infoBox">'.
		'<form name="downloadZip" id="downloadZip" action="downloadZip.php" method="post" enctype="text">'.
		'<h2 class="#b0bec5 blue-grey lighten-3">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Gallery Files were saved as a ZIP archive.</h2>'.
		'<img onload="countdown()" src="./images/1x1pixel.png">';
		if($host == true) {
			echo
			'<div id="timeoutMsg"><h3>You will be redirected to your newly created Gallery page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.<br>Please download your <span id="galleryname">'.$galleryname.' ZIP</span> archive now!</h3></div>'.
			'<label>Download the '.$galleryname.' Archive.<br><input type="text" name="galleryname" id="galleryname" size="64" value="'.$galleryname.'" hidden>'.
			'<input style="width: 85vw;" type="submit" value="&emsp;Download the '.$galleryname.' Archive.&emsp;" id="Apply"></label>'.
			'</form></section>';

		} else {
			echo
			'<div id="timeoutMsg"><h3>You will return to the Gallery Builder home page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.<br>Please download your <span id="galleryname">'.$galleryname.' ZIP</span> archive now!</h3></div>'.
			'<label>Download the '.$galleryname.' Archive.<br><input type="text" name="galleryname" id="galleryname" size="64" value="'.$galleryname.'" hidden>'.
			'<input style="width: 85vw;" type="submit" value="&emsp;Download the '.$galleryname.' Archive.&emsp;" id="Apply"></label>'.
			'</form></section>';
		}
	} else {
		if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] == 1)) {
			echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 redBox">'.
			'<div id="noZipMadeMsg"><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Gallery Files were NOT saved as a ZIP archive.</h3></div></section>';
		}
	}
}
}

	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox" id="ComicFooter">'.
	'<nav><p><a id="prevpagebutton" href="./getOGImg.php" title="return to the get OG Image page">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p></nav>'.
	'</footer>';

?>
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<script src="/Galleries/js/isoblockLogo.js"></script>
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
