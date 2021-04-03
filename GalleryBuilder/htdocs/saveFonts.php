<?php
/*
 * filename: saveFonts.php
 * this code saves font and background color for captions
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['hfontinfo'])) && ($_POST['pfontinfo'] != '') && ($_POST['cbinfo'] != '')) {
	$galleriesDir = '/home/bitnami/Galleries/htdocs/';
	$hfontinfo = $_POST['hfontinfo'];
	$pfontinfo = $_POST['pfontinfo'];
	$cbinfo = $_POST['cbinfo'];
	$_SESSION["hfontinfo"] = $hfontinfo;
	$_SESSION["pfontinfo"] = $pfontinfo;
	$_SESSION["cbinfo"] = $cbinfo;
	// build the configuration data file content
	$configContent = '<?php ';
	if(isset($_SESSION["hfontinfo"])){
		$hfontinfo = $_SESSION["hfontinfo"];
		$configContent .= '$_SESSION["hfontinfo"] = \''.$hfontinfo.'\';';
		} else {
		$configContent .= '$_SESSION["hfontinfo"] = "";';
		}
	if(isset($_SESSION["pfontinfo"])){
		$pfontinfo = $_SESSION["pfontinfo"];
		$configContent .= '$_SESSION["pfontinfo"] = \''.$pfontinfo.'\';';
		} else {
		$configContent .= '$_SESSION["pfontinfo"] = "";';
		}
	if(isset($_SESSION["cbinfo"])){
		$cbinfo = $_SESSION["cbinfo"];
		$configContent .= '$_SESSION["cbinfo"] = \''.$cbinfo.'\';';
		} else {
		$configContent .= '$_SESSION["cbinfo"] = "";';
		}
		$configContent .= '?>';
	// now have the config data as a string
	// write the config values file
	if(isset($_SESSION["galleryname"])){
		$galleryname = $_SESSION["galleryname"];
	$file = $galleriesDir.$galleryname.'/'.$galleryname.'FONTS.php';
	$deletedOldConfig = '';
	if(file_exists($file)) {
		unlink($file);
		$deletedOldConfig = "Deleted previous Configuration File<br>";}
	$return = file_put_contents($file, $configContent);
	$wroteNewConfig = '';
	if($return !== false) {
		$wroteNewConfig = 'Wrote a new Config File ' . $galleryname . '<br>'; }
	}
	header("Refresh: 0; URL=./captionFonts.php");
	echo "Saved the font and background color choices.<br/><br/>";
}
?>
