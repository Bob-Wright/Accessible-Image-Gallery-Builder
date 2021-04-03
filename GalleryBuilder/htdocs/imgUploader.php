<?php
/*
 * filename: imgUploader.php
 * this code processes the image files uploaded by the Upload form
 * we got here by an AJAX call from the javascript form handler
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("GalleryBuilder");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// Include Gallery class
require_once("/home/bitnami/includes/Gallery.class.php");

// set some variables 
//$galleryname = 'Gallery1';
// localpath for the image files
$uploadDir = "/home/bitnami/uploads/";
$_SESSION['uploadDir'] = $uploadDir;
// filename for the clean image file 
$cleanImage = 'KleenImuge.jpg'; 
// data for verbose report
$rindex = 0;
$report = array();
$Erindex = 0;
$Ereport = array();
$Errindex = 0;
$ErrReport = array();
// ***
// process the upload
// ***
echo '<script> alert("here we are"); </script>';
$vpb_size_total = 0;
//if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!(empty($_POST) && empty($_FILES) && ($_SERVER['CONTENT_LENGTH'] > 0)))) {
	if ((file_exists($_FILES["upload_file"]["tmp_name"])) && (is_uploaded_file($_FILES["upload_file"]["tmp_name"]))) {
	$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
	$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file list
	$vpb_final_location = $uploadDir . $vpb_file_name; //Directory to save file plus the file to be saved
	// move the uploaded file to our folder
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
			$report[$rindex] = "Uploaded Filename: " . $vpb_file_name . "<br>";
			$rindex = $rindex+1;
	$xmlFile = pathinfo($vpb_file_name);

	// check the filetype/extension, filename length, invalid filenames, allowed characters, and minimum-maximum file size
	if (!(preg_match('/jpeg|jpg|gif|png/i', ($xmlFile['extension'])))) {
			$ErrReport[$Errindex] = "Invalid filetype/extension. ".$vpb_file_name."<br>";$Errindex = $Errindex+1;}
	$vpb_file_nameLen = (strlen($xmlFile['filename']));
			$report[$rindex] = "Uploaded Filename length: " . $vpb_file_nameLen . "<br>";
			$rindex = $rindex+1;
	if (($vpb_file_nameLen > 255) || ($vpb_file_nameLen = 0)) {
			$ErrReport[$Errindex] = "Invalid filename length.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^(?!^(?:PRN|AUX|CLOCK\$|NUL|CON|COM\d|LPT\d)(?:\..+)?$)(?:\.*?(?!\.))[^\x00-\x1f\\?*:\";|\/<>]+(?<![\s.])$/', $xmlFile['filename']))) {
			$ErrReport[$Errindex] = "Invalid filename.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^([A-Za-z0-9]*[!_\-\+\'\.\(\)\s^]?)*$/', ($xmlFile['filename'])))) {
			$ErrReport[$Errindex] = "Invalid filename characters.<br>";$Errindex = $Errindex+1;}

	list($width, $height, $type, $attr) = getimagesize($uploadDir.$vpb_file_name);
			$report[$rindex] = "Uploaded File type code: " . $type . "<br>";
			$rindex = $rindex+1;

	// 16 Megabytes = 16,777,215 10 Megabytes = 10485760 Bytes, 8 Megabytes = 8388608 Bytes
	// 5 Megabytes = 5,242,880 Bytes, 3 Megabytes = 3,145,728, 2 Megabytes = 2,097,152, 1 Megabytes = 1,048,576, 500 Kbytes = 524,288
   switch ($type)
     {case 1:   //   gif
		$vpb_file_type = 'gif';
        $minW = 120; $minH = 120; $minSize = 1024;
		$maxW = 640; $maxH= 640; $maxSize = 3145728;
        break;
      case 2:   //   jpeg
		$vpb_file_type = 'jpg';
        $minW = 300; $minH = 300; $minSize = 1024;
		$maxW = 1600; $maxH= 1600; $maxSize = 5242880;
        break;
      case 3:  //   png
		$vpb_file_type = 'png';
        $minW = 300; $minH = 300; $minSize = 1024;
		$maxW = 1600; $maxH= 1600; $maxSize = 5242880;
        break;
     }
		$report[$rindex] = "Uploaded File type: " . $vpb_file_type . "<br>";
		$rindex = $rindex+1;

	$vpb_file_size = $_FILES["upload_file"]["size"];
			$report[$rindex] = "Uploaded Image file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;
	if (($vpb_file_size < $minSize) || ($vpb_file_size > $maxSize)) {
			// echo "File Size out of range."
			$ErrReport[$Errindex] = "File Size out of range.<br>";$Errindex = $Errindex+1;}

	if ((($width >= $minW) && ($height >= $minH)) || (($width <= $maxW) && ($height <= maxH))) {
		$report[$rindex] = "Image pixel dimensions: " . $width . " wide X " . $height . " high<br>";
		$rindex = $rindex+1;
	} else {
		// echo "File Size out of range."
		$ErrReport[$Errindex] = "File pixel dimensions are out of range " . $width . " wide X " . $height . " high<br>";$Errindex = $Errindex+1;
	}
if($vpb_file_type == 'jpg'){
	$img = imagecreatefromjpeg($uploadDir.$vpb_file_name);
	imagejpeg($img, $uploadDir.$vpb_file_name, 100);
}
if($vpb_file_type == 'png'){
	$img = imagecreatefrompng($uploadDir.$vpb_file_name);
	imageAlphaBlending($img, true);
	imageSaveAlpha($img, true);
	imagepng($img, $uploadDir.$vpb_file_name);
}
// if($vpb_file_type = 'gif'){
	// imagecreatefromgif doesn't like animations
	//$img = imagecreatefromgif($uploadDir.$vpb_file_name);
	//imagegif($img, $uploadDir.$cleanImage);}
if (isset($img)) { imagedestroy ($img);} 

	$tmp = file_get_contents($uploadDir.$vpb_file_name);
	$imageHash = hash('sha256', $tmp);
			$report[$rindex] = "Clean Image file hash: " . $imageHash . "<br>";
			$rindex = $rindex+1;
	$imageKey = hash('sha256', $tmp . strval(time()));
			$report[$rindex] = "Image file key: " . $imageKey . "<br>";
			$rindex = $rindex+1;
	$vpb_file_size = strlen($tmp);
			$report[$rindex] = "Clean Image file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;

	// have four categories of images
	$galleryname = $_SESSION['galleryname'];
	$pageimage = $_SESSION['pageimage'];
	// destination setup
	if(!(is_dir('/home/bitnami/Galleries/htdocs/'.$galleryname))) {
		mkdir('/home/bitnami/Galleries/htdocs/'.$galleryname, 0775, true);
	}
	$targetDir = '/home/bitnami/Galleries/htdocs/'.$galleryname.'/';
	// page background image
	if(($_SESSION['pageimage']) == 'BKGND'){ //BKGND or background image
		$backgroundimgfile = $galleryname.$pageimage.'.'.$vpb_file_type;
		rename($uploadDir.$vpb_file_name, $targetDir.$backgroundimgfile);
			$report[$rindex] = "Target file: " . $targetDir.$backgroundimgfile . "<br>";
			$rindex = $rindex+1;
		$_SESSION['bkgndImage'] = $backgroundimgfile;
		$galleryname = $galleryname.$pageimage;
			// write the gallery css file
		//$response = writeCSS($targetDir,$galleryname,$backgroundimgfile);
		//if ($response == FALSE) {
			//$ErrReport[$Errindex] = "Failed to write background CSS file.<br>";$Errindex = $Errindex+1;}
	}
	//logo images
	if(($_SESSION['pageimage']) == 'LOGO'){ //LOGO images
		$logoCount = $_SESSION['logoCount'];
		$logoCount = $logoCount + 1;
		$_SESSION['logoCount'] = $logoCount;
		$logoimgfile = $galleryname.$pageimage.$logoCount.'.'.$vpb_file_type;
		rename($uploadDir.$vpb_file_name, $targetDir.$logoimgfile);
			$report[$rindex] = "Target file: " . $targetDir.$logoimgfile . "<br>";
			$rindex = $rindex+1;
			// write the gallery logo file list
		$response = file_put_contents($targetDir.$galleryname.'.LL',$logoimgfile.',', FILE_APPEND);
		if ($response == FALSE) {
			$ErrReport[$Errindex] = "Failed to write logolist file.<br>";$Errindex = $Errindex+1;}
		$galleryname = $galleryname.$pageimage;
	}
	// an OG Meta Tag image for Facebook shares
	if(($_SESSION['pageimage']) == 'OGIMG'){ //OG Meta tag Image
		$ogimgfile = $galleryname.$pageimage.'.'.$vpb_file_type;
		//rename($uploadDir.$vpb_file_name, '/home/bitnami/Galleries/htdocs/'.$ogimgfile);
		rename($uploadDir.$vpb_file_name, $targetDir.$ogimgfile);
			$report[$rindex] = "Target file: " . $ogimgfile . "<br>";
			$rindex = $rindex+1;
		$galleryname = $galleryname.$pageimage;
	}
	// gallery image collection
	if(($_SESSION['pageimage']) == 'GALLERY'){ //images for the gallery
	$galleryname = $_SESSION['galleryname'];
	// destination setup
	if(!(is_dir($targetDir.'gallery'))) {
	mkdir($targetDir.'gallery', 0775, true);
	}
	$targetDir = $targetDir.'gallery/';
	rename($uploadDir.$vpb_file_name, $targetDir.$vpb_file_name);
			$report[$rindex] = "Target file: " . $targetDir.$vpb_file_name . "<br>";
			$rindex = $rindex+1;
	}

if(file_exists($uploadDir.$vpb_file_name)) {
	unlink($uploadDir.$vpb_file_name);}
	
	$_SESSION['report'] = $report;
	$_SESSION['ErrReport'] = $ErrReport;
	//$_SESSION['galleryname'] = $galleryname;

	if(empty($ErrReport)) { 
    // Initialize Image Gallery class
    $gallery = new Gallery();
    // set up the gallery data array
	/*	TABLE `galleryData`
	 `gallery_id (auto)`
	 `gallery_name`
	 `oauth_id`
	 `image_hash`
	 `image_key`
	 `filename`
	 `filetype`
	 `width`
	 `height`
	 `created`
	*/
	$galleryData = array();
    $galleryData['gallery_name']   = $galleryname;
    $galleryData['oauth_id'] = $_SESSION['oauth_id'];
    $galleryData['image_hash'] = $imageHash;
    $galleryData['image_key']	 = $imageKey;
    $galleryData['filename']   = $vpb_file_name;
    $galleryData['filetype']   = $vpb_file_type;
    $galleryData['width']   	= $width;
    $galleryData['height']   = $height;
    
    // Store image data in the session
    $_SESSION['galleryData'] = $galleryData;
	// Insert image data to the database
	$Data = $gallery->insertGallery($galleryData);
    // Store image data in the session
    //$_SESSION['galleryData'] = $Data;
	// notify the user of our success
		//Display the file id
	echo $vpb_file_id;
		}
	else
		{
		//Display general system error
		echo 'general_system_error';
		}
	}
	//echo '<p>SESSION imageData<br>'; print_r($_SESSION['galleryData']); echo'</p>';
}} // end upload handler
exit;

// write the gallery page background image CSS file
/*function writeCSS($targetDir, $galleryname, $backgroundimgfile) {
	$galleryCSS = '';
	$galleryCSS .= '.pageWrapper:before {';
	$galleryCSS .= "content: ' ';";
	$galleryCSS .= 'display: block;';
	$galleryCSS .= 'position: fixed;';
	$galleryCSS .= 'left: 0;';
	$galleryCSS .= 'top: 0;';
	$galleryCSS .= 'width: 100%;';
	$galleryCSS .= 'height: 100%;';
	$galleryCSS .= 'z-index: -1;';
	$galleryCSS .= 'opacity: 0.4;';
	$galleryCSS .= 'background-image: url("./'.$backgroundimgfile.'");';
	$galleryCSS .= 'background-position: top center;';
	$galleryCSS .= 'background-repeat: no-repeat;';
	$galleryCSS .= '-ms-background-size: 100% 100%;';
	$galleryCSS .= '-o-background-size: 100% 100%;';
	$galleryCSS .= '-moz-background-size: 100% 100%;';
	$galleryCSS .= '-webkit-background-size: 100% 100%;';
	$galleryCSS .= 'background-size: 100% 100%;';
	$galleryCSS .= '}';
	
	$cssfilename = $targetDir.$galleryname.'.css';
	$response = file_put_contents($cssfilename, $galleryCSS);
return $response;
}
*/
?>