<?php
/*
 * filename: clearConfig.php
 * this code clears the previously saved gallery config file name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

$getconfig = 'GalleryConfigs.php';
$uploadDir = "/home/bitnami/uploads/");

if(file_exists("/home/bitnami/uploads/GalleryConfigs.php")) {
	$result = unlink("/home/bitnami/uploads/GalleryConfigs.php");
}
include './closeSession.php';

?>
