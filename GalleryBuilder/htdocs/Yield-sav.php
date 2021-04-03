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
	<meta name="keywords" content="art,drawing,sketching,watercolor,ink,pencils,artist,graphics,poetry,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/GalleryBuilder/">
	<link href="https://syntheticreality.net" rel="canonical">
	<link href="/Galleries/css/normalize.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryCreator.css" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="/Galleries/css/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryBuilder.css" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<script>
// use <img onload="countdown()" src="../images/1x1pixel.png">
// and <h2>There are <span id="timeLeft"></span> seconds remaining.</h2>

// simple on timeout change page
//function timeoutDelay() {
//	setTimeout(loadPage, 30*1000);
//}
//function loadPage() {
//	alert("reached timeoutDelay");
	//window.location.replace("https://syntheticreality.net/GalleryBuilder.php");
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

<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body>
<main class="pageWrapper" id="container">
<!-- ++++++++++++++++++++++ -->
<!-- Logo and name -->
EOT2;
echo $head2;
//echo 'ID = '.session_id();
// if(isset($_COOKIE['GalleryBuilder'])) {
	//echo '<h2>'. ($_COOKIE['GalleryBuilder']) .'</h2><br>';}

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
'</header>';

$head3 = <<< EOT3
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- the message -->
<div class="article-wrapper">
<article class="textcontent">
<h1 style="text-align:center;color:red;">GalleryBuilder Creator</h1>
EOT3;
echo $head3;

// see if we are hosting the web gallery
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && ("/home/bitnami/includes/options.txt")) {$host = true;}
	if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] === 0)) {
		if($host === true) {
			echo
			'<div style="border: .3vw solid red;width:90vw;"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates and hosts an image gallery webpage using the information that you supplied. It also makes a ZIP archive of that content for you to optionally download.</h2></div>';
		} else {
			echo
				'<div style="border: .3vw solid red;width:90vw;"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates a ZIP archive download for an image gallery webpage using the information that you supplied.</h2><hr style="width: 60vw;height: .3vw;background-color: blue;"><p style="color: #a00020;background: #ffff00;padding: 1vw;">After the gallery archive is generated and prepared for downloading it will be deleted. There is no storage on this site for the generated web gallery archives. The only way to preserve your web image gallery is to download it.</p></div>';
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
			'<div style="width:95vw;">'.
			'<h3>Gallery Data from SESSION</h3>'.
			'<div id="configValues">';
			include '/home/bitnami/GalleryBuilder/htdocs/getConfigValues.php';
			echo
			'</div>';
	} else {
		echo
			'<div style="width:95vw;">'.
			'<h3>No Gallery Data from SESSION</h3>'.
			'<br><hr class="new3">'.
			'</div>';
	}
} else {
	if((isset($_SESSION['galleryname'])) && ($_SESSION['galleryname'] != '')) {
		$galleryname = $_SESSION['galleryname'];}
}

// see if options are enabled and we have a query string
$galleryFoldername = '';
$skippyLives = false;
if($host === true) {
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
	if(array_key_exists('gallery', $pstrings)) {
		$galleryFoldername = $pstrings['gallery'];
		if(file_exists($Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php')) {
			include $Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php';
			$_SESSION['galleryFoldername'] = $galleryFoldername;
			echo
				'<div style="width:95vw;">'.
				'<h3>Gallery Data from the Saved Configuration File</h3>';
				'<div id="configValues">';
				include '/home/bitnami/GalleryBuilder/htdocs/getConfigValues.php';
			echo
				'</div>'.
				'<br><hr class="new3">'.
				'</div>';
		} else {
			$galleryFoldername = '';
			$_SESSION['galleryFoldername'] = '';
			echo
				'<div style="width:95vw;">'.
				'<h3>No Saved Configuration File found</h3>'.
				'<br><hr class="new3">'.
				'</div>';
		}
	}
}

if(($galleryname === '') && ($galleryFoldername === '')) {
	echo
	'<div style="border: .3vw solid red;width:90vw;margin: 2vw;"><center><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">No gallery specified!&emsp;No HTML File was written.</h3><hr style="width:
 60vw;height: .2vw;background-color: blue;"><h3 style="color: #a00020;background: #ffff00;margin: 2vw;padding: 1vw;">Returning to Gallery Builder</h3></center></div>';
	// see if we are hosting the web gallery
	$host = false;
	if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$host = true;
		include "/home/bitnami/htdocs/includes/GalleryHostFooter.php";
		echo $GBfooter1;
		echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
		echo $GBfooter2;
	} else {
		include "/home/bitnami/htdocs/includes/GalleryBuilderFooter.php";
		echo $GBfooter1;
		echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
		echo $GBfooter2;
	}
	echo
	'<script>(setTimeout(function(){window.location.replace("https://syntheticreality.net/GalleryBuilder/closeGalleryBuilder.php");}, 5000))();</script>';
	die();
}

// check to see if we are to use existing content or make a new HTML file
if($useC === false) {
if(!(isset($_SESSION['gallerysaved']))) {$_SESSION['gallerysaved'] = 0;}
if($_SESSION['gallerysaved'] === 0) {
	if(($galleryFoldername != '') && (file_exists($Galleries.$galleryFoldername.'/'.$galleryFoldername.'.php'))) {
		echo '<p>GalleryBuilder will use the Saved Configuration values</p>';
		$galleryname = $galleryFoldername;
	} else {
		echo '<p>GalleryBuilder will use the SESSION Configuration values</p>';
	}
	echo
	// Gallery.php actually generates the web page
	'<div style="border: .3vw solid red;width:90vw;margin: 2vw;"><center><form id="savegallery" action="../Gallery.php" method="post">'.
	'<input type="text" id="galleryname" name="galleryname" size="60" value="'.$galleryname.'" hidden>'.
	//'<input type="submit" hidden>'.
	'<input type="submit" value=" Click to continue! ">'.
	'</form>'.
	'</center></div>';
	//echo '<script>document.getElementById("savegallery").submit();</script>';
	// set the gallerysaved flag in gallery
	// $_SESSION['gallerysaved'] = 1;
} else {
	// be sure GalleryBuilder created the web page
	if(file_exists($Galleries.$galleryname.'.html')) {
		if((isset($_SESSION['galleryFoldername'])) && ($_SESSION['galleryFoldername'] != '')) {
			echo '<p>GalleryBuilder used the Saved Configuration values</p>';
		} else {
			echo '<p>GalleryBuilder used the SESSION Configuration values</p>';
		}
			echo
			'<div id="galleryCreated"><center><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Image Gallery Files were created.</h3></center></div><br>';

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

//<center><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Image Gallery Files were created.</h3></center>
		echo
		'<div style="border: .3vw solid blue;width:90vw;margin: 2vw;background:#808080;">'.
		'<h2 style="color:#ff8000;text-align:center;margin-top:1vw;">You can Share your Gallery to Facebook.</h2>'.
		'<center><form id="shareForm" name="shareForm"action="../GalleriesUser/Share.php" method="post">'.
		'<input class="checkbox" type="checkbox" id="shareCheckbox" name="shareCheckbox" value="1" checked hidden>&ensp;'.
		'<input type="submit" value="&emsp; Click here to Share the Gallery on Facebook.&emsp;"></form></center></div>';

		if($skippyLives === true) {
			echo
			'<img onload="countdown()" src="../images/1x1pixel.png">'.
			'<br>';
			if($host === true) {
				echo
				'<div id="timeoutMsg"><h3>You will be redirected to your newly created gallery page in <span id="timeLeft"></span> seconds.</h3></div>';
			} else {
				echo
				'<div id="timeoutMsg"><h3>You will be returned to the Gallery Builder home page in <span id="timeLeft"></span> seconds.</h3>';
			}
			echo '<hr class="new4">';
		}
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
	echo 'No HTML file!<br>';
	echo 'use current option needs a current HTML file<br>';
		if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
			$host = true;
			include "/home/bitnami/htdocs/includes/GalleryHostFooter.php";
			echo $GBfooter1;
			echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
			echo $GBfooter2;
		} else {
			include "/home/bitnami/htdocs/includes/GalleryBuilderFooter.php";
			echo $GBfooter1;
			echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
			echo $GBfooter2;
		}
	echo
	'<script>(setTimeout(function(){window.location.replace("https://syntheticreality.net/GalleryBuilder/closeGalleryBuilder.php");}, 3000))();</script>';
	die();
}

// if no skippy option present create the ZIP
if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] === 1)) {
if(($skippyLives === false) && (file_exists($Galleries.$galleryname.'.html'))) {
	if(file_exists($Galleries.$galleryname.'OGIMG.png')) {
		$ziplist = $Galleries.$galleryname.', '. $Galleries.'Fonts, '. $Galleries.$galleryname.'.html, '. $Galleries.'favicon.ico ,'. $Galleries.'Robots.txt, '. $Galleries.'js, '. $Galleries.'CSS, '. $Galleries.'Images, '. $Galleries.$galleryname.'OGIMG.png';
	} else {
		$ziplist = $Galleries.$galleryname.', '. $Galleries.'Fonts, '. $Galleries.$galleryname.'.html, '. $Galleries.'favicon.ico ,'. $Galleries.'Robots.txt, '. $Galleries.'js, '. $Galleries.'CSS, '. $Galleries.'Images';
	}
	//echo 'The ZIP contents will be<br>'.$ziplist.'<br>';
	Zip($ziplist, $Galleries.$galleryname.'.zip', true);

	//clean up gallery files?
	if($saveC === false) {
		if(file_exists($Galleries.$galleryname.'OGIMG.png')) {
			$result = unlink($Galleries.$galleryname.'OGIMG.png');}
		if(file_exists($Galleries.$galleryname.'.html')) {
			$result = unlink($Galleries.$galleryname.'.html');}
		$folder = $Galleries.$galleryname;
		rrmdir($folder);
	}

/*	if($saveDB === false) {
		// clean the GalleryBuilder database
		//$imageList = $gallery->listGallery($galleryname, true);
		$imageList = $gallery->deleteGallery($galleryname);
	}
*/
	if(file_exists($Galleries.$galleryname.'.zip')) {
		// allow user time limit download gallery archive
		echo
		'<center><form name="downloadZip" id="downloadZip" action="downloadZip.php" method="post" enctype="text">'.
		'<h3>The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Image Gallery Files were saved as a ZIP archive.</h3>'.
		'<input type="text" name="galleryname" id="galleryname" size="32" value="'.$galleryname.'" hidden>'.
		'<input style="width: 85vw;" type="submit" value="&emsp;Click here to download the '.$galleryname.' Gallery archive.&emsp;" id="Apply">'.
		'</form></center>';
		echo
		'<img onload="countdown()" src="../images/1x1pixel.png">'.
		'<br>';
		if($host === true) {
			echo
			'<div id="timeoutMsg"><h3>You will be redirected to your newly created gallery page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.</h3><h2>Please download your <span id="galleryname">'.$galleryname.' ZIP</span> archive now!</h2></div>';
		} else {
			echo
			'<div id="timeoutMsg"><h3>You will return to the Gallery Builder home page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.</h3><h2>Please download your <span id="galleryname">'.$galleryname.' ZIP</span> archive now!</h2></div>';
		}
		echo '<hr class="new4">';
	} else {
		if((isset($_SESSION['gallerysaved'])) && ($_SESSION['gallerysaved'] === 1)) {
			echo '<div id="noZipMadeMsg"><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">The&nbsp;<span id="galleryname">'.$galleryname.'</span>&nbsp;Web Image Gallery Files were NOT saved as a ZIP archive.</h3></div>';
		}
	}
}
}

// see if we are hosting the web gallery
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
	$host = true;
	include "/home/bitnami/htdocs/includes/GalleryHostFooter.php";
	echo $GBfooter1;
	echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
	echo $GBfooter2;
} else {
	include "/home/bitnami/htdocs/includes/GalleryBuilderFooter.php";
	echo $GBfooter1;
	echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
	echo $GBfooter2;
}

?>
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<script src="../js/isoblockLogo.js"></script>
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
