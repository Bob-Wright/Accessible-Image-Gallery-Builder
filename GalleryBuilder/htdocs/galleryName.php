<?php
/*
 * filename: galleryName.php
 * this code saves the SQL database gallery name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
//$galleryname = 'AnImageGallery'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['galleryname'] == '')) { // empty POST then fallback value
		$_SESSION["galleryname"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "<h2>$galleryname is <strong>NOT</strong> a valid string.</h2>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['galleryname'])) && ($_POST['galleryname'] != '')) {
	$galleryname = trim($_POST['galleryname']);
	//sanitize string
	if (preg_match('/^([A-Za-z0-9]+$)/', $galleryname)) {
		$_SESSION["galleryname"] = $galleryname;
		$returnMsg = "<h2>$galleryname is a valid string.</h2>";

		// list of galleries
		$galleriesBase = '/home/bitnami/Galleries/htdocs/';
		if ($handle = opendir($galleriesBase)) {
			//echo "Directory handle: $handle\n";
			//echo "Entries:\n";

			/* loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if(!(is_dir($galleriesBase.$entry))) {
					$filenameArray = explode('.', $entry);
					// check the filetype/extension for HTML files
					if (preg_match('/html/i', $filenameArray[1])) {
						//$navmenu .= '<li class="menuEntry"><a href="./Galleries/'.$entry.'">'.$filenameArray[0].'</a></li>';
						if ($galleryname == $filenameArray[0]) {
							$returnMsg = "<h2>$galleryname is already being used!</h2>";
							$galleryname = '';
							$_SESSION["galleryname"] = $galleryname;
						}
					}
				}
			}
		closedir($handle);
		}

	} else {
		$_SESSION["galleryname"] = '';
		$returnMsg = "<h2>$galleryname is <strong>NOT</strong> a valid string.</h2>";
	}

	header("Refresh: 2; URL=./index.php");
	echo $returnMsg;
}
?>
