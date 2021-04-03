<?php
/*
 * filename: downloadZip.php
 * this code downloads the arcived gallery files
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

//		foreach ($_POST as $key=>$val)
//		echo '['.$key.'] => '.$val.'<br/>';
//		echo '<br><hr class="new3">';

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['galleryname'])) && ($_POST['galleryname'] != '')) {
	$galleryname = trim($_POST['galleryname']);

// Download Web Image Gallery ZIP File
if(file_exists('/home/bitnami/Galleries/htdocs/'.$galleryname.'.zip')) {
// http headers for zip downloads
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$galleryname.".zip");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($galleryname.".zip"));
flush();
readfile('/home/bitnami/Galleries/htdocs/'.$galleryname.'.zip');
}
exit;
}
?>