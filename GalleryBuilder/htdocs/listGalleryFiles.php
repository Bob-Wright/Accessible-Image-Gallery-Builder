<?php
/*
 * filename: listAgedGallery.php
 * this code lists aged database gallery files
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
require_once ("/home/bitnami/session2DB/Zebra.php");
//	session_start();
require_once("/home/bitnami/includes/Gallery.class.php");
    $gallery = new Gallery();
require './rrmdir.php';

// delete records and galleries older than this time in hours
$age = 12;

// get an array of all the aged records
$agedList = $gallery->listAgedGallery($age);
echo '<br>List of all records older than the time value in hours<br>';
echo '<pre>';print_r($agedList);echo '</pre>';

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
			echo '<pre>';echo $imageIndex.' ';print_r($agedListEntry);echo '</pre>';
			// update the gallery name
			$OldGalleryname = $galleryname;
			// might not need the key
			// $gallerykey = $agedListEntry[1];
			// if the galleryname is a folder delete it
			// and clean the GalleryBuilder database
			if(is_dir('../'.$galleryname)) {
				$folder = '../'.$galleryname;
				rrmdir($folder);
				echo 'Deleted '.$galleryname.' folder.<br>';
				//$imageList = $gallery->listGallery($galleryname, true);
				$imageList = $gallery->deleteGallery($galleryname);
				echo 'Deleted '.$galleryname.' database.<br>';
			}
		}
	}
next($agedList);
}
?>
