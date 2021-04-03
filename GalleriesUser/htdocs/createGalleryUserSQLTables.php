<?php
error_reporting(E_ALL); //disable for production
ini_set('display_errors', TRUE);

// Start session
session_name("GalleryBuilder");
require_once("/home/bitnami/session2DB/Zebra.php");
//include 'https://isoblock.com/GalleriesUser/Image.class.php';
//include 'https://isoblock.com/GalleriesUser/User.class.php';
//include './GalleriesUser/Image.class.php';
include '/home/bitnami/GalleriesUser/htdocs/User.class.php';
//    $image = new Image();
	$user = new User();

	// try to create new image data table
//    $imageData = $image->createTable();
	// and user data table
	$userData = $user->createTable();
?>