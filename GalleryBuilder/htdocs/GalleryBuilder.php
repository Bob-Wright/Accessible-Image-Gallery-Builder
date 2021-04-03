<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Gallery Builder</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Art, Images, & Prosody by Bob Wright">
	<meta name="copyright" content="Copyright 2020 by syntheticreality.net">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="art,drawing,sketching,watercolor,ink,pencils,artist,graphics,poetry,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/GalleryBuilder/">
	<link href="https://syntheticreality.net/GalleryBuilder" rel="canonical">
	<link href="/Galleries/css/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link href="/Galleries/css/main.css" rel="stylesheet"> -->
	<link href="/Galleries/css/homestyle.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="/Galleries/css/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="/Galleries/css/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<meta property="og:url" content="https://syntheticreality.net/GalleryBuilder/GalleryBuilder.php" >
<meta property="og:type" content="website" >
<meta property="og:title" content= "IsoBlock Gallery Builder" >
<meta property="og:description" content="by Bob Wright" >
<meta property="og:image:type"       content="image/png" >
<meta property="og:image:width"      content="1800" >
<meta property="og:image:height"     content="960" >
<meta property="og:image" content="https://syntheticreality.net/scenery98gray.png" >
<meta property="fb:app_id" content="2917501244986193" >
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->

<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body>
<!--------------------------------------->
<!-- Include the facebook javascript SDK -->
<script>
window.fbAsyncInit = function() {
	FB.init({
		appId      : '2917501244986193',
		xfbml      : true,
		version    : 'v3.3'
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
<!-- # include file="/Galleries/includes/browserupgrade.ssi" -->
<main class="pageWrapper" id="container">
<!-- ++++++++++++++++++++++ -->
<!-- Logo and name -->
EOT2;
echo $head2;

$logolist = file_get_contents("https://syntheticreality.net/GalleryBuilder/images/IsoBlock.LL");
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
'document.getElementById("Logo").src = "https://syntheticreality.net/GalleryBuilder/images/" + logofile;'.
'if(logoindex == 0) {'.
'logoindex = logocount-1;'.
'}else{'.
'logoindex = logoindex - 1;'.
'}}'.
'</script>'.
'<img class="Logo" id="Logo" src = "https://syntheticreality.net/GalleryBuilder/images/'.$logofiles[1].'" alt="Logo"><button class="toggleLogo" onclick="toggleLogo()"></button><div class="sitename" id="sitename" >IsoBlock</div>'.
'<span class="siteSubtitle">Synthetic Reality Division</span>'.
'</header>';

if(file_exists("/home/bitnami/Galleries/htdocs/includes/NavigateGalleries.php")) {
	include ("/home/bitnami/Galleries/htdocs/includes/NavigateGalleries.php");
	echo $navmenu;
}
echo
'<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->'.
'<!-- the message -->'.
'<div class="article-wrapper">'.
'<article class="textcontent">'.
'<h1 style="text-align:center;">Welcome to the Synthetic Reality Gallery Builder from IsoBlock.</h1>';

// see if we are hosting the web gallery
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
	$host = true;
	echo
	'<div style="border: .3vw solid blue;width:90vw;margin: 2vw;"><h2 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">Gallery Builder is a simple online web application that generates all the code for an image gallery based upon text information that you provide in response to various dialogs, most of which are "fill in the blank" requests, and the images and text caption descriptions that you select and upload to populate the gallery, along with an optional page background image and logos. Gallery Builder will then host the gallery as a page on this website. You may also download a ZIP archive copy of the web page.</h2></div>';
} else {
	echo
	'<div style="border: .3vw solid blue;width:90vw;margin: 2vw;"><h2 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">Gallery Builder is a simple online web application that generates all the code for an image gallery based upon text information that you provide in response to various dialogs, most of which are "fill in the blank" requests, and the images and text caption descriptions that you select and upload to populate the gallery, along with an optional page background image and logos. Gallery Builder is not intended to provide a hosting service to display uploaded galleries and it does not provide storage for image gallery archives. Once Gallery Builder has generated a web gallery archive, the application expects you to download that archive, so that you may then use or host the gallery on your own website or local media.</h2><hr style="width: 60vw;height: .2vw;background-color: red;"><h2 style="color: #a00020;background: #ffff00;margin: 2vw;padding: 1vw;">After the gallery archive is generated and prepared for downloading it will be deleted. There is no storage on this site for the generated web gallery archives. The only way to preserve your web image gallery is to download it.</h2></div>';
}
$common1 = <<< EOT2
<div style="border: .3vw solid red;width:90vw;margin: 2vw;"><h1><center>NOTICE</center></h1><hr style="width: 60vw;height: .2vw;background-color: blue;">
<h2 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">You must be a verified <!--Facebook -->user and you must agree to our <a href="./TermsOfService.php">"Terms of Service"</a> to upload content to be shared through the Synthetic Reality Gallery Builder application. You should also read our <a href="./CookiesPolicy.php">"Cookies Policy"</a> to understand how Synthetic Reality uses cookies. Note also that Synthetic Reality does not use tracking cookies or any form of cookie that contains personal information. Please take a few moments to read the terms that you must agree to in order to use this site and application. Use of this site signifies that you accept these terms.<br><br>
Also note that the Synthetic Reality Gallery Builder application may collect certain information about users who upload content, for example we may verify that upload users are also Facebook users or we may require a valid email address. Only verified users can upload content, we do not allow anonymous uploads. What data or information we collect about you as an upload user is associated with the content you upload, and what we do with that information is detailed in our <a href="./PrivacyPolicy.php">"Privacy Policy"</a> statement. However, as is stated in that policy, <strong>Synthetic Reality will not sell or provide any of your personal information to anyone without your permission.</strong></center></div>
<p>Gallery Builder generates a fixed format gallery, so for example you may change the name of the gallery but you may not determine where and how that name will be displayed.  Gallery Builder supports JPG, PNG, and GIF format images in its galleries and the file formats may be mixed within a gallery.<br>
Gallery Builder uses PHP and mySQLi and other software to generate the image gallery pages; however the web code that Gallery Builder makes and downloads, is all plain HTML, CSS, and javascript so it will run on most any host or media with most browsers. The image gallery uses "responsive design" to allow it to be used on various screen sizes from smartphones to desktops.<br>
More documentation explaining Gallery Builder options is part of the codebase repository on Github. Click the footer below for links. ☺ You can download and install your own free copy of Gallery Builder.</p>
<p>A <a href="https://syntheticreality.net/GalleryBuilder/IsoBlockGalleryBuilder.pdf">"PDF user guide"</a> and a <a href="https://syntheticreality.net/GalleryBuilder/IsoBlockGalleryBuilder.pdf">"video user guide"</a> show the Gallery Builder process. We suggest reviewing those before using Gallery Builder.</p>
<p>At the bottom of each Gallery Builder page there is a <strong><em>Previous / Next</em></strong> dialog to allow you to navigate through the application steps.</p>
<style>
#nextpagebutton {
	margin-left: 70vw;
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 2.4vw;
	padding: .5vw;
  border: .2vw solid red;
  background: #f0f0f0;
}
</style>
<a id="nextpagebutton" href="./Portal.php">Next ❯</a>	
</article>
</div>												   
EOT2;
echo $common1;
// see if we are hosting the web gallery
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
	$host = true;
	include "/home/bitnami/Galleries/htdocs/includes/GalleryHostFooter.php";
	echo $GBfooter1;
	echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
	echo $GBfooter2;
} else {
	include "/home/bitnami/Galleries/htdocs/includes/GalleryBuilderFooter.php";
	echo $GBfooter1;
	echo date ("F d Y H:i:s.", getlastmod()).'</summary>';
	echo $GBfooter2;
}
echo
'</main>'.
'<!-- End of the web page display -->'.
'<!-- ====================== -->';
if(file_exists("/home/bitnami/Galleries/htdocs/includes/GalleriesScriptSection.php")) {
	include ("/home/bitnami/Galleries/htdocs/includes/GalleriesScriptSection.php");
	echo $jsSection;
}
echo
'<script src="../Galleries/js/isoblockLogo.js"></script>'.
'<!-- +++++++++++++++++++++++ -->'.
'<!-- End of the web page -->'.
'</body>'.
'</html>';
?>