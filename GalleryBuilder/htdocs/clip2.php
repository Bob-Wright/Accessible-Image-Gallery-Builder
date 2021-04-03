require("/home/bitnami/includes/Gallery.class.php");
    $gallery = new Gallery();
$galleryname = $_SESSION['galleryname'];
$uploadDir = '/home/bitnami/Galleries/htdocs/'.$galleryname.'/gallery/';
$imageFolder = './'.$galleryname.'/gallery/';
$imageList = $gallery->listGallery($galleryname);
$_SESSION['imageList'] = $imageList;
//echo '<p>'; echo var_dump($imageList); echo '</p>';
/*
$constring = print_r($imageList);
echo '<script>console.log('.$constring.')</script>';
*/
echo
	'<!-- ++++++++++++++++++++ -->'.
	'<div class="galleryRow">';
// build the gallery	
for ($i = 0; $i <  count($imageList); $i++) {
	$imageIndex=key($imageList);
	$imageKey=$imageList[$imageIndex];
	if ($imageKey<> ' ') {
	   //echo $imageIndex ." = ".  $imageKey ." <br> ";
	   $imageIndex = $imageIndex + 1;
		//echo $val .".jpg<br> ";
		//$imageKey = $val;
 	// get image data from the database
    $imageData = $gallery->returnImage($imageKey);
    // Store image data in the session
    $_SESSION['imageData'] = $imageData;
	//echo '<p>'; echo var_dump($imageData); echo '</p>';
	$imageKey = $_SESSION['imageData']['gallery_key'];
	$filename = $_SESSION['imageData']['filename'];
	$filenameNoExt = (substr($filename, 0, -4));
		//$captionStr = substr($filename, 0, 14);
	$filetype = $_SESSION['imageData']['filetype'];
	$width = $_SESSION['imageData']['width'];
	$height = $_SESSION['imageData']['height'];
	$created = $_SESSION['imageData']['created'];
	$views = $_SESSION['imageData']['views'];
	$galleryFigDesc = 'This file is named&emsp;'.$filename.'.'; //<br>It has <strong>'.$views.'</strong> views.';
	//$FigCntr = '[ '.$imageIndex.' of '.count($imageList).' ]';
	$FigCntr = '[&nbsp;p&emsp;'.$imageIndex.'&nbsp;]';

	// now have an array of values for this image
	// see if we have alt text for this image
	// !!! every image should have an alt text description !!!
	$altText = $FigDesc; // fallback to file name as alt text
	if(is_dir($Galleries.$galleryname.'/altText/')) {
		$altTextDir = $Galleries.$galleryname.'/altText/';
		$pattern = '/\s/';
		$replacement = '';
		$altTextFile = $filenameNoExt.'.txt';
		$altTextFile = preg_replace($pattern, $replacement, $altTextFile);
		// check for txt file
		if(is_file($altTextDir.$altTextFile)) {
			$altText = (file_get_contents($altTextDir.$altTextFile));
			$altDesc = 'There is an alt text file named '.$altTextDir.$altTextFile.'.';
		}
	}
	// see if we have an optional caption for this image
	// we can have captions with no images for text only content
	$caption = '';
	if(is_dir($Galleries.$galleryname.'/captions/')) {
		$captionDir = $Galleries.$galleryname.'/captions/';
		$pattern = '/\s/';
		$replacement = '';
		$captionFile = $filenameNoExt.'.txt';
		$captionFile = preg_replace($pattern, $replacement, $captionFile);
		// check for txt file
		if(is_file($captionDir.$captionFile)) {
			$caption = (file_get_contents($captionDir.$captionFile));
			$capDesc = 'There is a caption text file named '.$captionDir.$captionFile.'.';
		}
	}
// we now have a collection of variables for this image
/*echo
	'<div class="galleryColumn">'.
	'<figure class="galleryFigure">'.
	'<details>'.
	'<summary><figcaption class="galleryFigCap">';
echo '<span class="mdi mdi-message-plus"></span>';
echo
	'&emsp;'.$caption.'</figcaption></summary>'.
	'<div class="galleryFigDesc">'.$galleryFigDesc.'</div>'.
	'</details>'.
	'<img src="'.$imageFolder.$filename.'" alt="'.$altText.'" style="width:100%;" onclick="openModal();currentSlide('.$imageIndex.')" class="hover-shadow cursor">'.
	'</figure>'.
	'</div>'; */
}
	next($imageList);
}
$head9 = <<< EOT9
	<!-- +++++++++++++++++++++++ -->
<div class="row justify-content-end fixed-top">
    <nav title="jump to the Comics gallery" class="btn btn-sm btn-yellow accent1">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="comicsHome" class="bi-layout-wtf"
		 width="60.000000px" height="42.000000px" viewBox="0 0 60.000000 42.000000">
		<g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)"
		fill="black" stroke="black" stroke-width="5">
		<path d="M467 413 c-2 -2 -32 -4 -67 -4 -53 -1 -67 -5 -87 -26 l-25 -24 -43
		21 c-36 17 -58 20 -136 18 l-93 -3 3 -150 c1 -82 6 -153 10 -158 4 -4 24 -1
		44 8 41 17 85 19 107 5 11 -7 6 -10 -22 -10 -40 0 -121 -31 -133 -51 -9 -13
		-1 -12 75 16 51 19 97 14 149 -16 l34 -20 22 27 c20 25 25 26 92 22 48 -2 78
		-9 90 -20 22 -20 73 -34 73 -20 0 5 -24 21 -53 36 -43 21 -69 26 -127 26 -65
		0 -71 2 -59 16 13 16 35 16 197 -2 l52 -6 0 79 c0 43 5 109 10 147 6 38 7 73
		3 77 -9 7 -110 18 -116 12z m88 -70 c-4 -26 -9 -86 -11 -133 l-3 -85 -28 1
		c-15 1 -59 7 -97 14 -64 11 -70 11 -97 -9 -26 -20 -29 -20 -38 -3 -9 15 -10
		15 -11 -5 0 -27 2 -27 -61 -7 -48 16 -112 15 -152 -1 -16 -7 -17 3 -17 129 l0
		136 69 0 c70 0 149 -21 163 -43 4 -7 8 -40 8 -74 0 -35 4 -63 10 -63 6 0 10
		30 10 69 0 52 5 74 19 92 17 23 26 24 131 27 l112 3 -7 -48z"/>
		</g><a xmlns="http://www.w3.org/2000/svg" id="anchor" xlink:href="./Comics.php" xmlns:xlink="http://www.w3.org/1999/xlink" target="_top"><rect x="0" y="0" width="100%" height="100%" fill-opacity="0"/></a>
		</svg>
    </nav>
</div>

  <!-- =========================== -->
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<!-- ++++++++++++++++++++ -->
<!-- Java script section -->
  <!-- jQuery -->
  <script type="text/javascript" id="" src="/Galleries/js/jquery.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" id="" src="/Galleries/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" id="" src="/Galleries/js/mdb.min.js"></script>
<script src="/Galleries/js/comicReader.js"></script>
<script >
  //conditionally enable/disable right mouse click //
$(document).ready( function() {
		//Disable cut copy paste
		$('body').bind('cut copy paste', function (e) {
        e.preventDefault();
		});
		//Disable mouse right click
		$("body").on("contextmenu",function(e){
			return false;
		});
		console.info("no context");
})
</script>
<!-- End of the Java script section-->
<!-- ======================= -->
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
EOT9;
//echo $head9;
