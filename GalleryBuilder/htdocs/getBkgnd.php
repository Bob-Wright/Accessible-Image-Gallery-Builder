<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// -----------------------
$_SESSION['pageimage'] = 'BKGND';
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Page Background Image Upload</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Multiple Image File Uploader">
	<meta name="copyright" content="Copyright 2019 by IsoBlock.com">
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
</head>
<body>
	<script src="/Galleries/js/jquery.min.js"></script>
	<script src="/Galleries/js/bootstrap.js"></script>
	<script src="/Galleries/js/jquery.dataTables.js" charset="utf-8"></script>
	<script src="/Galleries/js/DT_bootstrap.js" charset="utf-8"></script>
	<script src="/Galleries/js/vpb_uploader.js"></script>
<script>
$(document).ready(function()
{
	// Call the main function
	new vpb_multiple_file_uploader
	({
		vpb_form_id: "form_id", // Form ID
		autoSubmit: true,
		vpb_server_url: "imgUploader.php" 
	});
});
</script>
<main class="pageWrapper" id="container">
<h1 style="color:blue; text-align:center;">Page Background Image Upload</h1>
<!-- quick display of info about the upload requirements -->
<div class="msgBox"><h2 style="color:purple;">This page will let you select and upload the <em>Page Background</em> image for the Gallery.</h2></div><br>

<div class="infoBox"><p>Gallery Builder allows the use of <strong>JPG</strong> and <strong>PNG</strong> image filetypes (case insensitive) for the page background. All images must be in one of these two formats or filetypes and have a valid filename of up to 255 characters. At this time filenames must contain <strong>ONLY</strong> the English alphabetic characters <strong>A</strong> through <strong>Z</strong>, <strong>a</strong> through <strong>z</strong>, and the digits <strong>0</strong> through <strong>9</strong>.  Nonalphanumeric or special characters are limited to <em>spaces, underscores, dashes,</em> or <em>periods</em> and a few others as normal filename use allows.</p>

<p><strong>Gallery Builder will not upload content from another site through a URL; you may only upload image files from your device.</strong> Image files are limited to 5 Megabytes (5 Megabytes = 5,242,880 Bytes) maximum filesize for <strong>JPG</strong> and <strong>PNG</strong> files. Best results will be obtained with the recommended image pixel dimensions. Note that all metadata content (<em>eg</em> EXIF data) will be removed from uploaded image files.</p></div>
<br>
<div class="msgBox"><p style="color:purple;">The specific image that is needed for the <em>Page Background</em> that will be displayed in the Gallery should be a JPG or PNG format and be about 1200 to 1400 pixels on a side. The selected image will be scaled to fill the browser window when the page is being viewed, and it has reduced opacity for a softer background.</p></div>
<br>
<center>
<div class="msgBox">
<form name="form_id" id="form_id" action="javascript:void(0);" enctype="multipart/form-data">
	<label>Select and upload a gallery page background image:<br><input type="file" accept=".jpg,.JPG,.gif,.GIF,.png,.PNG" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple>
	<input type="submit" value="Upload Selected File" id="Upload"></label>
</form>
<br></div>
<hr class="new4">
<table class="table table-striped table-bordered" id="add_files">
	<thead>
		<tr>
			<th style="color:blue; text-align:center;">File Name</th>
			<th style="color:blue; text-align:center;">Status</th>
			<th style="color:blue; text-align:center;">File Size</th>
			<th style="color:blue; text-align:center;">File Date</th>
			<th style="color:blue; text-align:center;">Action</th>
		<tr>
	</thead>
	<tbody>
	
	</tbody>
</table>
</center>
EOT2;
echo $head2;
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center justify-content-end shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" id="navFooter">'.
	'<nav id="GalleryFooter"><p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./index.php" title="return to configuration settings">Next ❯</a></p></nav>'.
		'</footer>';
?>
<script>
         $(function(){
            $("input[type = 'submit']").click(function(){
               var $fileUpload = $("input[type='file']");
               if (parseInt($fileUpload.get(0).files.length) > 1){
                  alert("You are allowed to upload one background image file");
				  window.location.replace("https://syntheticreality.net/ComicBuilder/getBkgnd.php");
               } 
            });
         });
      </script>
</main>
</body>
</html>