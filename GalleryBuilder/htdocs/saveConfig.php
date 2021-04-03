<?php
/*
 * filename: saveConfig.php
 * this code saves the gallery config file
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

$checkbox = '';
$configDir = '';
$configContent = '';
$saveconfigDir = '';
$saveconfig = '';
$clearedGallery = '';
$clearedDB = '';
$noGalleryname = '';
// Galleries folder path
$galleriesDir = '/home/bitnami/Galleries/htdocs/';

// check that form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['saveCheckbox'])) { $checkbox = 1; } else { $checkbox = 0;}
	if((isset($_SESSION["galleryname"])) && ($_SESSION["galleryname"] != '')){
		$galleryname = trim($_SESSION['galleryname']);
		// clear the gallery content?
		if($checkbox == 0) { //clean up gallery files?
												 
										 
																				  
   

							   
					  
			// Comics folder path
			//$galleriesDir = '/home/bitnami/Galleries/htdocs/';
			require("./rrmdir.php");

			if(file_exists($galleriesDir.$galleryname.'.zip')) {
				$result = unlink($galleriesDir.$galleryname.'.zip');}
			if(file_exists($galleriesDir.$galleryname.'OGIMG.png')) {
				$result = unlink($galleriesDir.$galleryname.'OGIMG.png');}
			if(file_exists($galleriesDir.$galleryname.'OGIMG.jpg')) {
				$result = unlink($galleriesDir.$galleryname.'OGIMG.jpg');}
			if(file_exists($galleriesDir.$galleryname.'.html')) {
				$result = unlink($galleriesDir.$galleryname.'.html');}
			/*if(file_exists($galleriesDir.$galleryname.'.card')) {
				$result = unlink($galleriesDir.$galleryname.'.card');}
			if(file_exists($galleriesDir.'coversImg/'.$galleryname.'CARD.jpg')) {
				$result = unlink($galleriesDir.'coversImg/'.$galleryname.'CARD.jpg');}
			if(file_exists($galleriesDir.'coversImg/'.$galleryname.'CARD.gif')) {
				$result = unlink($galleriesDir.'coversImg/'.$galleryname.'CARD.gif');}
			if(file_exists($galleriesDir.'coversImg/'.$galleryname.'CARD.png')) {
				$result = unlink($galleriesDir.'coversImg/'.$galleryname.'CARD.png');} */
			$folder = $galleriesDir.$galleryname;
			rrmdir($folder);
			$clearedGallery = "Cleared the ' . $galleryname . ' content.<br>";
			// clean the GalleryBuilder database
			require("/home/bitnami/includes/Gallery.class.php");
				$gallery = new Gallery();
			$imageList = $gallery->listGallery($galleryname, true);
			$imageList = $gallery->deleteGallery($galleryname);
			$clearedDB = 'Cleared the database<br>';
		}

		if(!(is_dir('/home/bitnami/Galleries/htdocs/'.$galleryname))) {
			mkdir('/home/bitnami/Galleries/htdocs/'.$galleryname, 0775, true);
		}
		$saveconfigDir = '/home/bitnami/Galleries/htdocs/'.$galleryname.'/';
		$saveconfig = $galleryname;
	}

	$configContent = '';
	$configContent .= '<?php ';
	//$configContent .= 'session_name("GalleryBuilder");';
	//$configContent .= 'require_once("/home/bitnami/session2DB/Zebra.php");';*/

	if(isset($_SESSION["siteurl"])){
		$siteurl = $_SESSION["siteurl"];
		$configContent .= '$_SESSION["siteurl"] = "'.$siteurl.'";';
		} else {
		$configContent .= '$_SESSION["siteurl"] = "";';
		}
	if(isset($_SESSION["galleryname"])){
		$galleryname =  $_SESSION["galleryname"];
		$configContent .= '$_SESSION["galleryname"] = "'.$galleryname.'";';
		} else {
		$configContent .= '$_SESSION["galleryname"] = "";';
		}
	if(isset($_SESSION["pagetitle"])){
		$pagetitle = $_SESSION["pagetitle"];
		$configContent .= '$_SESSION["pagetitle"] = "'.$pagetitle.'";';
		} else {
		$configContent .= '$_SESSION["pagetitle"] = "";';
		}
	if(isset($_SESSION["bkgndImage"])){
		$bkgndImage = $_SESSION["bkgndImage"];
		$configContent .= '$_SESSION["bkgndImage"] = "'.$bkgndImage.'";';
		} else {
		$configContent .= '$_SESSION["bkgndImage"] = "";';
		}
	if(isset($_SESSION["sitename"])){
		$sitename = $_SESSION["sitename"];
		$configContent .= '$_SESSION["sitename"] = "'.$sitename.'";';
		} else {
		$configContent .= '$_SESSION["sitename"] = "";';
		}
	if(isset($_SESSION["sitesubtitle"])){
		$sitesubtitle = $_SESSION["sitesubtitle"];
		$configContent .= '$_SESSION["sitesubtitle"] = "'.$sitesubtitle.'";';
		} else {
		$configContent .= '$_SESSION["sitesubtitle"] = "";';
		}
	if(isset($_SESSION["noZoomSitename"])){
		$noZoomSitename = $_SESSION["noZoomSitename"];
		$configContent .= '$_SESSION["noZoomSitename"] = "'.$noZoomSitename.'";';
		} else {
		$configContent .= '$_SESSION["noZoomSitename"] = 1;';
		}
	if(isset($_SESSION["navmenu"])){
		$navmenu = $_SESSION["navmenu"];
		$configContent .= '$_SESSION["navmenu"] = "'.$navmenu.'";';
		} else {
		$configContent .= '$_SESSION["navmenu"] = "";';
		}
	if(isset($_SESSION["gallerydisplayname"])){
		$gallerydisplayname = $_SESSION["gallerydisplayname"];
		$configContent .= '$_SESSION["gallerydisplayname"] = "'.$gallerydisplayname.'";';
		} else {
		$configContent .= '$_SESSION["gallerydisplayname"] = "";';
		}
	if(isset($_SESSION["gallerydesc"])){
		$gallerydesc = $_SESSION["gallerydesc"];
		$configContent .= '$_SESSION["gallerydesc"] = "'.$gallerydesc.'";';
		} else {
		$configContent .= '$_SESSION["gallerydesc"] = "";';
		}
	if(isset($_SESSION["gallerycomment"])){
		$gallerycomment = $_SESSION["gallerycomment"];
		$configContent .= '$_SESSION["gallerycomment"] = "'.$gallerycomment.'";';
		} else {
		$configContent .= '$_SESSION["gallerycomment"] = "";';
		}
	if(isset($_SESSION["galleryemail"])){
		$galleryemail = $_SESSION["galleryemail"];
		$configContent .= '$_SESSION["galleryemail"] = "'.$galleryemail.'";';
		} else {
		$configContent .= '$_SESSION["galleryemail"] = "";';
		}
	if(isset($_SESSION["artistname"])){
		$artistname = $_SESSION["artistname"];
		$configContent .= '$_SESSION["artistname"] = "'.$artistname.'";';
		} else {
		$configContent .= '$_SESSION["artistname"] = "";';
		}
	if(isset($_SESSION["oauth_id"])){
		$oauth_id = $_SESSION["oauth_id"];
		$configContent .= '$_SESSION["oauth_id"] = "'.$oauth_id.'";';
		} else {
		$configContent .= '$_SESSION["oauth_id"] = "";';
		}
	$configContent .= ' ?>';
// now have the config data as a string

if($saveconfigDir === '') {
	$noGalleryname = 'No Configuration Data!!!<br>';
	$deletedOldConfig = '';
	$wroteNewConfig = '';
	$clearedDB = '';
	$clearedGallery = '';
} else {
	$file = $saveconfigDir.$saveconfig.'.php';
	$deletedOldConfig = '';
	if(file_exists($file)) {
		unlink($file);
		$deletedOldConfig = "Deleted previous Configuration File<br>";}
	$return = file_put_contents($file, $configContent);
	$wroteNewConfig = '';
	if($return !== false) {
		$wroteNewConfig = 'Wrote a new Config File ' . $saveconfig . '<br>'; }
}
header("Refresh: 2; URL=./index.php");
if(!($saveconfig === '')) {
	echo "$saveconfig is a valid filename string.<br/><br/>";}
echo "checkbox was ' . $checkbox . '<br>";
if(!($noGalleryname === '')) {
	echo $noGalleryname; }
if(!($deletedOldConfig === '')) {
	echo $deletedOldConfig; }
if(!($clearedGallery === '')) {
	echo $clearedGallery; }
if(!($clearedDB === '')) {
	echo $clearedDB; }
if(!($wroteNewConfig === '')) {
	echo $wroteNewConfig; }
}

?>