<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
//	@session_start();
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");
include("/home/bitnami/includes/Gallery.class.php");
    $gallery = new Gallery();
include './rrmdir.php';

$_SESSION['gallerysaved'] = 0;
$usedSavedConfig = 0;
$_SESSION['usedSavedConfig'] = $usedSavedConfig;

/*
// delete records and galleries older than this time in hours
$age = 12;

// get an array of all the aged records
$agedList = $gallery->listAgedGallery($age);
//echo '<br>List of all records older than the time value in hours<br>';
//echo '<pre>';print_r($agedList);echo '</pre>';

// go through the list
$OldGalleryname = '';
for ($i = 0; $i <  count($agedList); $i++) {
	$imageIndex=key($agedList);
	$imageKey=$agedList[$imageIndex];
	if ($imageKey<> ' ') {
		// split an entry
		$agedListEntry = explode(',', $imageKey);
		//echo '<pre>';echo $imageIndex.' ';print_r($agedListEntry);echo '</pre>';
		$galleryname = $agedListEntry[0];
		// see if this record has a different galleryname
		if(!($galleryname === $OldGalleryname)) {
			// echo '<pre>';echo $imageIndex.' ';print_r($agedListEntry);echo '</pre>';
			// update the gallery name
			$OldGalleryname = $galleryname;
			// might not need the key
			// $gallerykey = $agedListEntry[1];
			// if the galleryname is a folder delete it
			// and clean the GalleryBuilder database
			if(is_dir('/home/bitnami/Galleries/htdocs/'.$galleryname)) {
				$folder = '/home/bitnami/Galleries/htdocs/'.$galleryname;
				rrmdir($folder);
				// echo 'Deleted '.$galleryname.' folder.<br>';
				//$imageList = $gallery->listGallery($galleryname, true);
				$imageList = $gallery->deleteGallery($galleryname);
				// echo 'Deleted '.$galleryname.' database.<br>';
			}
		}
	}
next($agedList);
}
*/
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>WebGallery Builder</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Web Image Gallery Builder">
	<meta name="copyright" content="Copyright 2021 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="web page">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/GalleryBuilder/">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="/Galleries/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
    <link href="/Galleries/css/DT_bootstrap.css" rel="stylesheet" type="text/css" >
	<link href="/Galleries/css/GalleryCreator.css" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/GalleryBuilder.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="./favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
</head>
<body>
<main class="pageWrapper" id="container">
EOT2;
echo $head2;
echo
// announce who we are
'<center>'.
'<h1 style="color:blue; text-align:center;">Web Gallery Builder</h1>'.
'</center>';

if((isset($_SESSION['userCountMsg'])) && ($_SESSION['userCountMsg'] != '')) {
	$userCountMsg = $_SESSION['userCountMsg'];
	echo
	'<hr class="new3">'.
	'<hr class="new4">'.
	'<center>'.
	$userCountMsg.
	'<p style="color:red;">We are sorry for any inconvenience.</p>'.
	'</center>'.
	'<hr class="new3">'.
	'<center>'.
	'<h2 style="color:purple;">Please check back a bit later, and thanks for your patronage and your patience!</h2>'.
	'</center>'.
	'<hr class="new4">'.
	'<hr class="new3">'.
	'<div id="galleryFooter"><a id="prevpagebutton" href="../GalleryBuilder/closeGalleryBuilder.php">❮ Previous</a>&emsp;Design and Contents &copy; 2019 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@syntheticreality.net">Bob Wright.</a>&nbsp;Last modified <!--#echo var="LAST_MODIFIED" --></div>';
} else {

$offline = false;
	if((file_exists("/home/bitnami/includes/offline.txt")) && (file_exists("/home/bitnami/includes/options.txt")) && (getenv('QUERY_STRING') === '')) {
		$offline = true;
		echo
			'<hr class="new3">'.
			'<hr class="new4">'.
			'<center>'.
			'<h2 style="color:red;">Web Gallery Builder is being updated. We are sorry for any inconvenience.</h2>'.
			'</center>'.
			'<hr class="new3">'.
			'<center>'.
			'<h2 style="color:purple;">Please check back a bit later, and thanks for your patronage and your patience!</h2>'.
			'</center>'.
			'<hr class="new4">'.
			'<hr class="new3">'.
			'<div id="galleryFooter"><a id="prevpagebutton" href="../GalleryBuilder/closeGalleryBuilder.php">❮ Previous</a>&emsp;Design and Contents &copy; 2019 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@syntheticreality.net">Bob Wright.</a>&nbsp;Last modified <!--#echo var="LAST_MODIFIED" --></div>';
	} else {

$uploadDir = "/home/bitnami/uploads/";
//$usedSavedConfig = 0;
$buoy = false;
$host = false;
	if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$host = true;}
if(getenv('QUERY_STRING') != '') {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	// see if valid URL query string keys AND the magic key file exists
	if((array_key_exists('buoy', $pstrings)) && (file_exists("/home/bitnami/includes/buoy.txt"))) {
		$buoy = true;}
	if((array_key_exists('Gallery', $pstrings)) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$galleryFoldername = $pstrings['Gallery'];
		$_SESSION['$galleryFoldername'] = $galleryFoldername;
		if(file_exists('/home/bitnami/Galleries/htdocs/'.$galleryFoldername.'/'.$galleryFoldername.'.php')) {
			include '/home/bitnami/Galleries/htdocs/'.$galleryFoldername.'/'.$galleryFoldername.'.php';
			$_SESSION['usedSavedConfig'] = 1;
		}
	}
}

/*
 * -----------------------
 * Each field has a form to sanitize and validate content
 *
*/
echo
'<center>'.
'<h2 style="color:blue;">Enter the Gallery Page configuration values requested below.</h2>'.
'</center>'.
'<p style="color:purple;"><strong>You may click an "Apply" button without entering data to insert the default or example value. You may reenter a value, or you may make changes or corrections to a value. For each item save the changes by clicking the associated "Apply" button. To clear an entry and delete its value enter a single space and click "Apply".</strong></p><br>'.
'<hr class="new4">'.
'<hr class="new3">';

//$_SESSION["siteurl"] = './';
// site URL calls siteURL.php $host is FALSE
if($host == true) {
// get our host URL
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/"; 
$siteurl = $link;
$_SESSION["siteurl"] = $siteurl;
echo
'<form id="siteURL" action="siteURL.php" method="post" enctype="text">'.
'This URL will be the <em>site base address</em>. This value is an absolute URL that will become part of the <em>page URL</em> and will be used as the canonical URL in the HTML "head section", and it will be used along with the <em>gallery page name</em> to create an optional <em>OG URL</em> used when the web page is shared on Facebook. The value is set by the Gallery Builder.<br>'.
'<label>The hosted gallery base address (set by Gallery Builder):<br><input disabled type="text" name="siteurl" id="siteurl" size="80" value="'.$siteurl.'"></label>'.
'</form><br>';
} else {
if(isset($_SESSION["siteurl"])){
	$siteurl =  $_SESSION["siteurl"];
	} else {$siteurl = '';}
echo
'<form id="siteURL" action="siteURL.php" method="post" enctype="text">'.
'Enter a URL to use for the <em>site base address</em>. Use an absolute URL like "http://mydomain.com/" for a web host (domain), or you may use the relative URL "./" to display the site from a CD-ROM or a local drive, or other devices such as USB thumb drives. Leave out the quotes used here in the examples. If this value is an absolute URL it will become part of the <em>page URL</em> and will be used as the canonical URL in the HTML "head section", and it will be used along with the <em>gallery page name</em> to create an optional <em>OG URL</em>.<br>'.
	'<label>The hosted gallery domain (required):<br><input type="text" name="siteurl" id="siteurl" size="80" value="'.$siteurl.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';
}
// page URL calls galleryName.php
if(isset($_SESSION["galleryname"])){
	$galleryname =  $_SESSION["galleryname"];
	} else {$galleryname = '';}
echo
'<form id="galleryName" action="galleryName.php" method="post" enctype="text">'.
'Enter a <em>gallery page name</em> up to 32 alphabetic or numeric characters in length. This value will become part of the <em>page URL</em> and will also be used along with the <em>site base address</em> to create an optional <em>OG URL</em>. No whitespace characters or symbols are allowed. Do not include the HTML filetype, only provide the filename portion of the gallery page name, as for example "MyGalleryPageName" and not "MyGalleryPageName.html" (leave out the quotes used here in the examples).<br>'.
	'<label>The hosted gallery name (required):<br><input type="text" name="galleryname" id="galleryname" size="32" value="'.$galleryname.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>'.
'<hr class="new3">'.
'<hr class="new3">';

// page html title calls pageTitle.php
if(isset($_SESSION["pagetitle"])){
	$pagetitle =  $_SESSION["pagetitle"];
	} else {$pagetitle = '';}
echo
'<form id="pageTitle" action="pageTitle.php" method="post" enctype="text">'.
'Enter a page title up to 20 characters in length for the <em>HTML header title</em> to display on the browser tab. This name will also be used if the page is bookmarked. <br>'.
	'<label>The gallery page title (required):<br><input type="text" name="pagetitle" id="pagetitle" size="20" value="'.$pagetitle.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>'.
'<hr class="new3">'.
'<hr class="new3">';

// page SiteName for header calls siteName.php
if(isset($_SESSION["sitename"])){
	$sitename =  $_SESSION["sitename"];
	} else {$sitename = '';}
echo
'<form id="siteName" action="siteName.php" method="post" enctype="text">'.
'Enter a website or domain name up to 10 characters in length to be shown as the <em>SiteName</em> in the Header banner at the top of the Gallery Page.<br>'.
	'<label>Site Name (required):<br><input type="text" name="sitename" id="sitename" size="10" value="'.$sitename.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';

// page Site Subtitle for header calls siteSubtitle.php
if(isset($_SESSION["sitesubtitle"])){
	$sitesubtitle =  $_SESSION["sitesubtitle"];
	} else {$sitesubtitle = '';}
echo
'<form id="siteSubtitle" action="siteSubtitle.php" method="post" enctype="text">'.
'Enter an optional subtitle up to 40 characters in length to be shown as the <em>Site Name Subtitle</em> in the Header banner at the top of the Gallery Page.<br>'.
	'<label>Site Name Subtitle (optional):<br><input type="text" name="sitesubtitle" id="sitesubtitle" size="40" value="'.$sitesubtitle.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';

if(ISSET($_SESSION["noZoomSitename"])) {
	$noZoomSitename =  $_SESSION["noZoomSitename"];
	} else {
	$noZoomSitename = 0;
	$_SESSION["noZoomSitename"] = $noZoomSitename;}
echo
'<form id="noZoomSitename" action="./noZoomSitename.php" method="post">'.
'Check the box to <span style="color:purple;">DISABLE</span> animation of the <em>Site Name</em> and the <em>Site Name Subtitle</em> on web page load.<br>';
	if($noZoomSitename === 0) {
		echo '<label>Check to Disable Animation:<br><input class="checkbox" type="checkbox" id="zoomCheckbox" name="zoomCheckbox" value="0"></label><br>';
	} else {
		echo '<label>Uncheck to Enable Animation:<br><input class="checkbox" type="checkbox" id="zoomCheckbox" name="zoomCheckbox" value="1"></label><br>';
	}
echo
'<input type="submit" value="Apply selection">'.
'</form><br>'.
'<hr class="new3">'.
'<hr class="new3">';

// if buoy include a menu bar
if($buoy === true) {
// navigation menu display calls navMenu.php
if(isset($_SESSION["navmenu"])){
	$navmenu =  $_SESSION["navmenu"];
	} else {$navmenu = 'none';}
echo
'<script>'.
'function uncheck(check) {'.
'	var prim = document.getElementById("displayCheckbox");'.
'	var secn = document.getElementById("hideCheckbox");'.
'	if (prim.checked == true && secn.checked == true) {'.
'		if(check == 1) {'.
'			secn.checked = false;'.
'			checkRefresh();}'.
'		else'.
'		if(check == 2) {'.
'			prim.checked = false;'.
'			checkRefresh();}'.
'	}'.
'}'. 
'</script>'.

'<div id="navMenuDisplay"><form id="navMenuDisplay" action="./navMenu.php" method="post">'.
'Check one of these two boxes to enable a <em>Navigation Menu</em> bar on the gallery page.<br>If either one of these two boxes is checked, a "view/hide menu button" appears at the top right corner of the page to switch the display of the Navigation Menu between visible and hidden. These checkboxes enable the Navigation Menu and select its intial display condition.&nbsp;<strong>If both boxes are unchecked, no Navigation Menu will be available.</strong><br><br>'.
'<label>Open Nav Menu (optional):<br><input class="checkbox" type="checkbox" id="displayCheckbox" name="displayCheckbox" value="1" onClick="uncheck(1);"';
if ($navmenu == 'show') {echo ' checked';}
echo
'></label>&ensp;Enable the Navigation Menu and open the page with the site navigation menu visible.<br>'.
'<strong>OR</strong><br>'.
'<label>Closed Nav Menu (optional):<br><input class="checkbox" type="checkbox" id="hideCheckbox" name="hideCheckbox" value="2" onClick="uncheck(2);"';
if ($navmenu == 'hide') {echo ' checked';}
echo
'></label>&ensp;Enable the Navigation Menu and open the page with the site navigation menu hidden.<br><br>'.
'<input type="submit" value="Apply selection">'.
'</form></div>'.
'<hr class="new3">'.
'<hr class="new3">';
} else {
	$navmenu = 'none';
	$_SESSION["navmenu"] = $navmenu;
}

// image for the Gallery background calls getBkgnd.php
	$pageimage = 'BKGND';
	$_SESSION["pageimage"] = $pageimage;
echo
'<form id="bkgndimage" action="getBkgnd.php" method="post" enctype="text">'.
'This dialog will allow you to select an image to display as the Gallery background. This image will appear behind your image content. <br>'.
'<label>The Gallery Background image (optional):<br><input type="text" name="bkgndimage" id="bkgndimage" size="64" value="'.$pageimage.'" hidden></label>'.
'<br><input type="submit" value="Select an Image">'.
'</form><br>';

// title for the image gallery calls galleryDisplayName.php
if(isset($_SESSION["gallerydisplayname"])){
	$gallerydisplayname =  $_SESSION["gallerydisplayname"];
	} else {$gallerydisplayname = '';}
echo
'<form id="galleryDisplayName" action="galleryDisplayName.php" method="post" enctype="text">'.
'Enter a gallery name or <em> Gallery Title</em> up to 60 characters in length to display on the page. This title will appear below the Header (and below the Menu bar if one is present).<br>'.
	'<label>Gallery Title (required):<br><input type="text" name="gallerydisplayname" id="gallerydisplayname" size="60" value="'.$gallerydisplayname.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';

// subtitle for the gallery calls galleryDesc.php
if(isset($_SESSION["gallerydesc"])){
	$gallerydesc =  $_SESSION["gallerydesc"];
	} else {$gallerydesc = '';}
echo
'<form id="galleryDesc" action="galleryDesc.php" method="post" enctype="text">'.
'Enter a gallery <em>Subtitle</em> up to 80 characters in length to display on the page. This subtitle will appear just below the gallery name or title entered above.<br>'.
	'<label>Gallery Subtitle (required):<br><input type="text" name="gallerydesc" id="gallerydesc" size="80" value="'.$gallerydesc.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';

// gallery comment calls galleryComment.php
if(isset($_SESSION["gallerycomment"])){
	$gallerycomment =  $_SESSION["gallerycomment"];
	} else {$gallerycomment = '';}
echo
'<form id="galleryComment" action="galleryComment.php" method="post" enctype="text">'.
'Enter a short <em>description of the gallery</em> up to 400 characters in length to display on the page. This description will appear just below the gallery subtitle.<br>'.
'<label>Gallery Description (optional):<br><textarea name="gallerycomment" id="gallerycomment" rows="5" cols="80">'.$gallerycomment.'</textarea></label><br>'.
	'<input type="submit" value="Apply">'.
'</form><br>'.
'<hr class="new3">'.
'<hr class="new3">';

// page Email calls galleryEmail.php
if(isset($_SESSION["galleryemail"])){
	$galleryemail =  $_SESSION["galleryemail"];
	} else {$galleryemail = '';}
echo
'<form id="galleryEmail" action="galleryEmail.php" method="post" enctype="text">'.
'Enter an <em>Email address</em> to display in the page Footer that will appear at the bottom of the browser window.<br>'.
	'<label>Gallery Email Address (required):<br><input type="text" name="galleryemail" id="galleryemail" size="80" value="'.$galleryemail.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';
//'<hr class="new3">';

// artist's or creator's name for author copyright calls artistName.php
if(isset($_SESSION["artistname"])){
	$artistname =  $_SESSION["artistname"];
	} else {$artistname = '';}
echo
'<form id="artistName" action="artistName.php" method="post" enctype="text">'.
'Enter an <em>Artist</em> or content creator name up to 60 characters in length to display on the page. This name will appear in the page copyright and author credits.<br>'.
	'<label>Artist Name (required):<br><input type="text" name="artistname" id="artistname" size="60" value="'.$artistname.'"></label>&emsp;'.
	'<input type="submit" value="Apply">'.
'</form><br>';

/*
 * -----------------------
 * end of configuration selections
 *
*/
echo
'<hr class="new3">'.
'<hr class="new4">'.
'<h2 style="color:blue;">Current Configuration Settings.</h2>'.
'<div id="configDisplay">'.
'<div id="configValuesBox">'.
'<div id="configValuesBkgnd">';
include './getConfigValues.php';
echo
'</div>'.
'<div id="configValues">';
include './getConfigValues.php';
echo
'</div>'.
'</div><br>'.
'<div id="saveconfigDisplay">';
if($_SESSION['usedSavedConfig'] == 1) { //because of query string, already checked ownership
	echo
	'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
	'You may replace your current Configuration files with the displayed values.<br>You can also choose whether or not to delete any other Gallery contents.<br>Leave the box unchecked to delete the current '.$galleryname.' contents or check the box to leave the current Gallery contents as they are.<br>'.
	'<label>Check to preserve any present content:&emsp;<input class="checkbox" type="checkbox" id="saveCheckbox" name="saveCheckbox" value="0" unchecked></label><br>'.
	'<label>Save the Configuration data:&emsp;<input type="submit" value="Apply"></label></form><br>';
} else {
	if(!(isset($_SESSION['galleryname']))) {
		echo
		'<p>No Gallery Name is specified. No actions may be taken.</p>';
	} else {
		$thisOauthID = '';
		if(isset($_SESSION['oauth_id'])) {
			$thisOauthID = $_SESSION['oauth_id'];}
		if(!(file_exists('/home/bitnami/Galleries/htdocs/'.$galleryname.'/'.$galleryname.'.php'))) {
			echo
			'<p>No Configuration Data file exists with Gallery Name matching '.$galleryname.'</p>'.
			'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
			'You may save new Configuration and Gallery card files with the displayed values.<br>This will start building your '.$galleryname.' Gallery.<br>'.
			'<label style="opacity: 0;">Check to preserve any present content:&emsp;<input class="checkbox" type="hidden" id="saveCheckbox" name="saveCheckbox" value="1" checked></label><br>'.
			'<label>Save the Configuration and Card data:&emsp;<input type="submit" value="Apply"></label></form><br>';
		} else {
			$configFileContents = file_get_contents('/home/bitnami/Galleries/htdocs/'.$galleryname.'/'.$galleryname.'.php');
			if( preg_match_all('/('.preg_quote($thisOauthID,'/').')/i', $configFileContents, $matches)){
				//print_r($matches);
			echo
			'<p>Configuration Data file exists with matching oauth_id '.$thisOauthID.'</p>'.
			'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
			'You may replace your current saved Configuration and Gallery card files with the displayed values.<br>You can also choose whether or not to delete any other Gallery contents.<br>Leave the box unchecked to delete the current '.$galleryname.' contents or check the box to leave the current Gallery contents as they are.<br>'.
			'<label>Check to preserve any present content:&emsp;<input class="checkbox" type="checkbox" id="saveCheckbox" name="saveCheckbox" value="0" unchecked></label><br>'.
			'<label>Save the Configuration and Card data:&emsp;<input type="submit" value="Apply"></label></form><br>';
			} else {
				'<p>Configuration Data file exists but oauth_id '.$thisOauthID.' does not match. You may not modify this Gallery.</p>';
			}
		}
	}
}

echo
'</div>'.
'<hr class="new3">'.
'<hr class="new4">'.
'<br></div>'.
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="navFooter">'.
	'<nav id="GalleryFooter"><p><a id="prevpagebutton" href="./Portal.php" title="return to login page">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./getGallery.php" title="get Gallery images">Next ❯</a></p></nav>'.
		'</footer>';
}
}
?>
</main>
	<script src="/Galleries/js/jquery.min.js"></script>
	<script src="/Galleries/js/bootstrap.js"></script>
</body>
</html>