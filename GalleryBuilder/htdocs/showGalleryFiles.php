<?php
/*
 * filename: listGallery.php
 * this code lists the database gallery files
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");
//	session_start();
require_once("/home/bitnami/includes/Gallery.class.php");
    $gallery = new Gallery();

$galleryname = $_SESSION['galleryname'];
echo 'The gallery name is '.$galleryname.'<br>';

$imageList = $gallery->listGallery($galleryname);
echo '<br>List of records for the gallery name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

$imageList = $gallery->listGallery($galleryname, true);
echo '<br>List of records for the extended gallery name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

/*
$imageList = $gallery->deleteGallery($galleryname);
echo '<br>List of DELETED records for the gallery name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

$imageList = $gallery->listGallery($galleryname);
echo '<br>List of records for the gallery name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';
*/
?>

