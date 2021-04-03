<?php
/*
* makeGallery.php actually builds and then saves the gallery
* using _SESSION data values and database values
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// be sure we are here by a POST request
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['galleryname'])) && ($_POST['galleryname'] != '')) {
// Start session
//if ((session_status() == PHP_SESSION_NONE) || (session_status() !== PHP_SESSION_ACTIVE)) {
	session_name("GalleryBuilder");
	//if(isset($_COOKIE['GalleryBuilder'])) {
	//	session_id($_COOKIE['GalleryBuilder']);}
	require_once("/home/bitnami/session2DB/Zebra.php");
//}
$showFigCntr = false;
$galleryname = $_SESSION['galleryname'];
$siteurl = $_SESSION['siteurl'];
$Galleries = '/home/bitnami/Galleries/htdocs/';
if(is_file($Galleries.$galleryname.'/'.$galleryname.'FONTS.php')) {
	include($Galleries.$galleryname.'/'.$galleryname.'FONTS.php');
}
// set up to buffer output
ob_start();
// begin generated web page content
$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
EOT1;
echo $head1;
echo '<title>'.$_SESSION['pagetitle'].'</title>';
echo '<meta NAME="Last-Modified" CONTENT="'. date ("F d Y H:i:s.", getlastmod()).'">';
echo '<meta name="copyright" content="Site design and code Copyright 2020 by IsoBlock.com, Artistic Content Copyright 2020 by '.$_SESSION['artistname'].'">';
$head3 = <<< EOT3
	<meta name="description" content="A Storybook image Gallery">
	<meta name="generator" content ="IsoBlock Synthetic Reality Storybook Image Gallery Builder">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="comics,images,art,graphics,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"/> 
EOT3;
echo $head3;
if((is_file($Galleries.$galleryname.'/'.$galleryname.'OGIMG.jpg')) || (is_file($Galleries.$galleryname.'/'.$galleryname.'OGIMG.png'))) {
	echo '<meta property="og:url" content="'.$_SESSION['siteurl'].'Galleries/'.$galleryname.'.html" >';
	echo '<meta property="og:type" content="website" >';
	echo '<meta property="og:title" content= "'.$_SESSION['pagetitle'].'" >';
	echo '<meta property="og:description" content="A Gallery by '.$_SESSION['artistname'].'">';
	if(is_file($Galleries.$galleryname.'/'.$galleryname.'OGIMG.jpg')) {
		echo '<meta property="og:image:type"       content="image/jpg" >';
	} else {
		echo '<meta property="og:image:type"       content="image/png" >';
	}	
	echo 
		 '<meta property="og:image:width"      content="1800" >'.
		 '<meta property="og:image:height"     content="960" >';
	if(is_file($Galleries.$galleryname.'/'.$galleryname.'OGIMG.jpg')) {
		echo '<meta property="og:image" content="'.$siteurl.'Galleries/'.$galleryname.'/'.$galleryname.'OGIMG.jpg" >';
	} else {
		echo '<meta property="og:image" content="'.$siteurl.'Galleries/'.$galleryname.'/'.$galleryname.'OGIMG.png" >';
	}	
	echo
		'<meta property="fb:app_id" content="1297101973789783" >';
}
echo '<base href="'.$_SESSION['siteurl'].'Galleries/">';
echo '<link href="'.$_SESSION['siteurl'].'Galleries/'.$galleryname.'.html" rel="canonical">';
$head4 = <<< EOT4
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="/Galleries/css/bootstrap.min.css">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="/Galleries/css/mdb.min.css">
	<link rel="stylesheet" href="/Galleries/css/GalleryStyles.css">
	<!-- Your custom styles (optional)
	<link rel='stylesheet' href="/Galleries/css/colorPalette.css">
	<link rel='stylesheet' href="/Galleries/css/textColorPalette.css">
	<link rel='stylesheet' href="/Galleries/css/LiteThemes.css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico"/>
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
<style>
* {
 box-sizing: border-box;
}
@font-face {
	font-family: "Comic Neue";
	src: url("./Fonts/ComicNeue-Regular.ttf") format("truetype");
  }
body {
 font-family: "Comic Neue";
}
EOT4;
echo $head4;
if(isset($_SESSION['pfontinfo'])) {
	$pfontinfo = $_SESSION['pfontinfo'];
	echo $pfontinfo;
} else {
	echo
		'@font-face {'.
		'font-family: "Merriweather";'.
		'src: url("./Fonts/Merriweather-Regular.ttf") format("truetype"); }'.
		'p {font-family: Merriweather; font-size: 1.5vw; }';
}
if(isset($_SESSION['hfontinfo'])) {
	$hfontinfo = $_SESSION['hfontinfo'];
	echo $hfontinfo;
} else {
	echo
		'@font-face {'.
		'font-family: "Roboto";'.
		'src: url("./Fonts/Roboto-Regular.ttf") format("truetype"); }'.
		'h1 { font-family: Roboto; text-align: left; font-size: 2vw; }'.
		'h2 { font-family: Roboto; text-align: left; font-size: 1.75vw; }'.
		'h3 { font-family: Roboto; text-align: left; font-size: 1.5vw; }';
}
if(isset($_SESSION['cbinfo'])) {
	$cbinfo = $_SESSION['cbinfo'];
	echo $cbinfo;
} else {
	echo
		'.xmplc {'.
		'background-color: #b0bec5; }';
}
if(isset($_SESSION['bkgndImage'])) {
	$bkgndImage = $_SESSION['bkgndImage'];
$headC1 = <<< EOTC1
	#container:before {
	content: ' ';
	display: block;
	position: fixed;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	z-index: -1;
	opacity: 0.2;
EOTC1;
echo $headC1;
echo
'background-image: url("./'.$galleryname.'/'.$bkgndImage.'");';
$headC2 = <<< EOTC2
background-position: top center;
	background-repeat: no-repeat;
	-ms-background-size: 100% 100%;
	-o-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;
	}
EOTC2;
echo $headC2;
}
$head5 = <<< EOT5
</style>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->
<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
EOT5;
echo $head5;
//include "/home/bitnami/Galleries/htdocs/includes/browserupgrade.ssi";
include "/home/bitnami/Galleries/htdocs/includes/GalleryHeader.php";
//echo 'ID = '.session_id();
//if(isset($_COOKIE['GalleryBuilder'])) {
	//echo '<h2>GalleryBuilder Cookie is = '. ($_COOKIE['GalleryBuilder']) .'</h2><br>';}
	
if (isset($_SESSION['navmenu'])) {
	if (($_SESSION['navmenu'] === 'show') || ($_SESSION['navmenu'] === 'hide')){ 
		include "/Galleries/includes/NavigateGalleries.php"; }
	if ($_SESSION['navmenu'] === 'none') {
		if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
$headhome = <<< EOT99
	<!-- +++++++++++++++++++++++ -->
<div class="row justify-content-end fixed-top" style="padding-right: .5vw;">
     <nav title="jump to the Galleries page" class="btn btn-sm btn-yellow accent1">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="galleriesHome" class="bi-layout-wtf"
		 width="60.000000px" height="42.000000px" viewBox="0 0 60.000000 42.000000">
		<g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)"
		fill="black" stroke="black" stroke-width="5">
		<path d="M467 413 c-2 -2 -32 -4 -67 -4 -53 -1 -67 -5 -87 -26 l-25 -24 -43
		21 c-36 17 -58 20 -136 18 l-93 -3 3 -150 c1 -82 6 -153 10 -158 4 -4 24 -1
		44 8 41 17 85 19 107 5 11 -7 6 -10 -22 -10 -40 0 -121 -31 -133 -51 -9 -13
		-1 -12 75 16 51 19 97 14 149 -16 l34 -20 22 27 c20 25 25 26 92 22 48 -2 78
		-9 90 -20 22 -20 73 -34 73 -20 0 5 -24 21 -53 36 -43 21 -69 26 -127 26 -65
		0 -71 2 -59 16 13 16 35 16 197 -2 l52 -6 0 79 c0 43 5 109 10 147 6 38 7 73
		3 77 -9 7 -110 18 -116 12z m88 -70 c-4 -26 -9 -86 -11 -133 l-3 -85 -28 1
		c-15 1 -59 7 -97 14 -64 11 -70 11 -97 -9 -26 -20 -29 -20 -38 -3 -9 15 -10
		15 -11 -5 0 -27 2 -27 -61 -7 -48 16 -112 15 -152 -1 -16 -7 -17 3 -17 129 l0
		136 69 0 c70 0 149 -21 163 -43 4 -7 8 -40 8 -74 0 -35 4 -63 10 -63 6 0 10
		30 10 69 0 52 5 74 19 92 17 23 26 24 131 27 l112 3 -7 -48z"/>
		</g><a xmlns="http://www.w3.org/2000/svg" id="anchor" xlink:href="./Galleries.php" xmlns:xlink="http://www.w3.org/1999/xlink" target="_top"><rect x="0" y="0" width="100%" height="100%" fill-opacity="0"/></a>
		</svg>
    </nav>
</div>
EOT99;
echo $headhome;
		}
	}
}
echo
	'<h1 class="sr-only">'.$_SESSION['pagetitle'].'</h1>';
$head6 = <<<EOT6
<!-- ++++++++++++++++++++ -->
<!--  build gallery pages -->
<!-- ++++++++++++++++++++ -->
<main  id="container" class="imgblock row flex-row row-no-gutters justify-content-center">
EOT6;
echo $head6;
echo '<center><h1>'.$_SESSION['gallerydisplayname'].'</h1>';
echo '<h2>'.$_SESSION['gallerydesc'].'</h2></center>';
echo '<p>'.$_SESSION['gallerycomment'].'</p>';

echo '<h3><strong>Click an image to see it full screen.</strong></h3>',
'</body>'.
'</html>';
// Include Gallery class
	/*	TABLE `galleryData`
	 `gallery_id`
	 `gallery_name`
			
	 `image_has`
	 `image_key`
	 `filename`
	 `filetype`
	 `width`
	 `height`
	 `created`
	*/
require("/home/bitnami/includes/Gallery.class.php");
    $gallery = new Gallery();
$galleryname = $_SESSION['galleryname'];
$uploadDir = '/home/bitnami/Galleries/htdocs/'.$galleryname.'/gallery/';
$imageFolder = './'.$galleryname.'/gallery/';
$imageList = $gallery->listGallery($galleryname);
$_SESSION['imageList'] = $imageList;
//echo '<p>'; echo var_dump($imageList); echo '</p>';
/*
$constring = print_r($imageList);
echo '<script>console.log('.$constring.')</script>';
*/
echo
	'<!-- ++++++++++++++++++++ -->'.
	'<div class="galleryRow">';
// build the gallery	
for ($i = 0; $i <  count($imageList); $i++) {
	$imageIndex=key($imageList);
	$imageKey=$imageList[$imageIndex];
	if ($imageKey<> ' ') {
	   //echo $imageIndex ." = ".  $imageKey ." <br> ";
	   $imageIndex = $imageIndex + 1;
		//echo $val .".jpg<br> ";
		//$imageKey = $val;
 	// get image data from the database
    $imageData = $gallery->returnImage($imageKey);
    // Store image data in the session
    $_SESSION['imageData'] = $imageData;
	//echo '<p>'; echo var_dump($imageData); echo '</p>';
	$imageKey = $_SESSION['imageData']['image_key'];
	$filename = $_SESSION['imageData']['filename'];
	$filenameNoExt = (substr($filename, 0, -4));
		//$captionStr = substr($filename, 0, 14);
	$filetype = $_SESSION['imageData']['filetype'];
	$width = $_SESSION['imageData']['width'];
	$height = $_SESSION['imageData']['height'];
	$created = $_SESSION['imageData']['created'];
	$galleryFigDesc = $filenameNoExt; //<br>It has <strong>'.$views.'</strong> views.';
	//$FigCntr = '[ '.$imageIndex.' of '.count($imageList).' ]';
	$FigCntr = '[&nbsp;p&emsp;'.$imageIndex.'&nbsp;]';

	// now have an array of values for this image
	// see if we have alt text for this image
	// !!! every image should have an alt text description !!!
	$altText = $galleryFigDesc; // fallback to file name as alt text
	if(is_dir($Galleries.$galleryname.'/altText/')) {
		$altTextDir = $Galleries.$galleryname.'/altText/';
		$pattern = '/\s/';
		$replacement = '';
		$altTextFile = $filenameNoExt.'.txt';
		$altTextFile = preg_replace($pattern, $replacement, $altTextFile);
		// check for txt file
		if(is_file($altTextDir.$altTextFile)) {
			$altText = (file_get_contents($altTextDir.$altTextFile));
			$altDesc = 'There is an alt text file named '.$altTextDir.$altTextFile.'.';
		}
	}
	// see if we have an optional caption for this image
	// we can have captions with no images for text only content
	$caption = '';
	if(is_dir($Galleries.$galleryname.'/captions/')) {
		$captionDir = $Galleries.$galleryname.'/captions/';
		$pattern = '/\s/';
		$replacement = '';
		$captionFile = $filenameNoExt.'.txt';
		$captionFile = preg_replace($pattern, $replacement, $captionFile);
		// check for txt file
		if(is_file($captionDir.$captionFile)) {
			$caption = (file_get_contents($captionDir.$captionFile));
			$capDesc = 'There is a caption text file named '.$captionDir.$captionFile.'.';
		}
	}
// we now have a collection of variables for this image
echo
	'<div class="galleryColumn">'.
	'<figure class="galleryFigure">'.
	'<details>'.
	'<summary><figcaption class="galleryFigCap xmplc">';
//echo '<span class="mdi mdi-message-plus"></span>';
echo
	'&emsp;'.$galleryFigDesc.'</figcaption></summary>'.
	'<div class="galleryFigDesc xmplc">'.$caption.'</div>'.
	'</details>'.
	'<img src="'.$imageFolder.$filename.'" alt="'.$altText.'" style="width:100%;" onclick="openModal();currentSlide('.$imageIndex.')" class="hover-shadow cursor">'.
	'</figure>'.
	'</div>'; 
}
	next($imageList);
}
echo '</div><br>';
echo
	'<!-- ++++++++++++++++++++ -->'.
	'<!-- modal image display -->'.
	'<div id="myModal" class="modal">'.
	'<div class="modal-content">';
// build the modals
$imageList = $_SESSION['imageList'];
for ($i = 0; $i <  count($imageList); $i++) {
		$imageIndex=key($imageList);
		$imageKey=$imageList[$imageIndex];
		if ($imageKey<> ' ') {
		   //echo $imageIndex ." = ".  $imageKey ." <br> ";
		   $imageIndex = $imageIndex + 1;
			//echo $val .".jpg<br> ";
			//$imageKey = $val;
 	// get image data from the database
    $imageData = $gallery->returnImage($imageKey);
    // Store image data in the session
    $_SESSION['imageData'] = $imageData;
	//echo '<p>'; echo var_dump($imageData); echo '</p>';
	$imageKey = $_SESSION['imageData']['image_key'];
	$filename = $_SESSION['imageData']['filename'];
		//$captionStr = substr($filename, 0, 14);
	$filetype = $_SESSION['imageData']['filetype'];
	$width = $_SESSION['imageData']['width'];
	$height = $_SESSION['imageData']['height'];
	$modalFigDesc = 'This file is named&emsp;'.$filename.'.'; //<br>It has <strong>'.$views.'</strong> views.';

// see if we have a caption for this image
if(is_dir($Galleries.$galleryname.'/captions/')) {
	$captionDir = $Galleries.$galleryname.'/captions/';
	$pattern = '/\s/';
	$replacement = '';
	$captionFile = (substr($filename, 0, -4)).'.txt';
	$captionFile = preg_replace($pattern, $replacement, $captionFile);
	// check for txt file
	if(is_file($captionDir.$captionFile)) {
		$modalFigDesc = $modalFigDesc.'<br>'.(file_get_contents($captionDir.$captionFile));
	}
}
echo
	'<figure class="mySlides">'.
	'<details>'.
	'<summary><figcaption class="modalFigCap xmplc">';
//echo '<span class="mdi mdi-message-plus"></span>';
echo
	'&emsp;'.$filename.'</figcaption></summary>'.
	'<p class="modalFigDesc xmplc">'.$modalFigDesc.'</p>'.
	'</details><img class="topfiller" id="'.(900 + $imageIndex).'" src="./Images/1x1pixel.png" width="100%" height="5%" alt="">'.
	'<img class="make-it-fit" id="'.$imageIndex.'" src="'.$imageFolder.$filename.'" width="'.$width.'" height="'.$height.'" alt="">'.
	'</figure>';
	}
	 next($imageList);
	}
//$head7 = <<< EOT7
echo '<div class="bannerLeft"><a class="prev" id="prev" onclick="plusSlides(-1)">';
//echo '<span class="mdi mdi-arrow-left-bold-outline"></span>';
echo
	'&nbsp;Prev</a>'.
	'<span class="numberText" id="numberText">slideIndex of slides.length inserted here</span></div>'.
	'<div class="bannerRight"><span class="closeModalButton cursor" onclick="closeModal()">Close&nbsp;';
//echo '<span class="mdi mdi-close-box"></span>';
echo
	'</span>'.
	'<a class="next" id="next" onclick="plusSlides(1)">Next&nbsp;</a></div>';
//echo '<span class="mdi mdi-arrow-right-bold-outline"></span>';
$head9 = <<< EOT9
</div>
</div>
	<!-- +++++++++++++++++++++++ -->
<div class="row justify-content-end fixed-top">
    <nav title="jump to the Galleries" class="btn btn-sm btn-yellow accent1">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="galleriesHome" class="bi-layout-wtf"
		 width="75px" height="50px" viewBox="0 0 16 12" fill="red" stroke="blue"><path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/><path d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
		<a xmlns="http://www.w3.org/2000/svg" id="anchor" xlink:href="https://syntheticreality.net/Galleries/Galleries.php" xmlns:xlink="http://www.w3.org/1999/xlink" target="_top"><rect x="0" y="0" width="100%" height="100%" fill-opacity="0"/></a>
		</svg>
    </nav>
</div>

  <!-- =========================== -->
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<!-- ++++++++++++++++++++ -->
<!-- Java script section -->
<!-- disable the right click context menu -->
  <script type="text/javascript" id="" src="/Galleries/js/jquery.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" id="" src="/Galleries/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" id="" src="/Galleries/js/mdb.min.js"></script>
<script src="/Galleries/js/modal.js"></script>
<!-- <script src="/Galleries/js/context.js"></script> -->
<script >
  //conditionally enable/disable right mouse click //
$(document).ready( function() {
		//Disable cut copy paste
		$('body').bind('cut copy paste', function (e) {
        e.preventDefault();
		});
		//Disable mouse right click
		$("body").on("contextmenu",function(e){
			return false;
		});
		console.info("no context");
})
</script>
<!-- End of the Java script section-->
<!-- ======================= -->
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
EOT9;
echo $head9;


//nominal end of the generated web page
$page = ob_get_contents();
ob_end_clean();

// strip off the ISP inserted script footer at end of the page
//$page = substr($page, 0, strpos($page, '<!-- End of the web page -->'));
//$page = $page.'<!-- End of the web page --></body></html>';

if(is_file('/home/bitnami/Galleries/htdocs/'.$galleryname.'.html')) {
	unlink('/home/bitnami/Galleries/htdocs/'.$galleryname.'.html');}
$file = fopen('/home/bitnami/Galleries/htdocs/'.$galleryname.'.html', "w");
fwrite($file, $page);
fclose($file);

$_SESSION['gallerysaved'] = 1;
echo
	'<script>window.location.replace("https://syntheticreality.net/GalleryBuilder/Yield.php");</script>';
}
?>