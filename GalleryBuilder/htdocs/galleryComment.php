<?php
/*
 * filename: galleryComment.php
 * this code saves the gallery comment in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
// . \ + * ? ^ $ [ ] ( ) { } < > = ! | :
$gallerycomment = 'This is a sample gallery comment or description about the gallery.<br>Line breaks, the Enter key, will echo here as the HTML break tag, like this<br>So line breaks may be included in the text input.<br>input can also include symbols like ~!@#$%^&*()_+|}{:\"?-=[]\;\'/ but less than or greater than symbols are not allowed.'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['gallerycomment'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$gallerycomment = preg_replace($pattern, $replacement, $gallerycomment);
	$_SESSION["gallerycomment"] = $gallerycomment;
	header("Refresh: 1; URL=./index.php");
	echo "$gallerycomment is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['gallerycomment'])) && ($_POST['gallerycomment'] != '')) {
	$gallerycomment = trim($_POST['gallerycomment']);
	//echo '<br>'.$gallerycomment.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$gallerycomment = preg_replace($pattern, $replacement, $gallerycomment);
	//sanitize string
	$gallerycomment = filter_var($gallerycomment, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($gallerycomment != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$gallerycomment = preg_replace($pattern, $replacement, $gallerycomment);
		$_SESSION["gallerycomment"] = $gallerycomment;
		header("Refresh: 1; URL=./index.php");
		echo "$gallerycomment is a valid string.<br/><br/>";
	} else {
		$_SESSION["gallerycomment"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$gallerycomment is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
