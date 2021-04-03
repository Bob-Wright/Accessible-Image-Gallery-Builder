// comment this following info display block out for production
/*
echo
'<section class="d-flex col-sm-11 flex-column shadow-md #b0bec5 blue-grey lighten-5 px-sm-0">'.
'<p style="color:indigo; font-size:1.7vw;">++++++++++++<br>'.
	$FigDesc.'<br>'.
	$altDesc.'<br>'.
	$capDesc.'<br>'.
	$altImgDesc.'<br>'.
	$altImgTextDesc.'<br>'.
	$altImgMP3Desc.'</p></section>';
*/
// next we assemble them into a page to display
// how the page will appear and act will in turn depend on their values
if($altimg == '') { //no alt image to display
	if(!(($width == 1) && ($height == 1))) { // display image if not the 1px by 1px "no image image"
		echo
		'<img id="" src="./'.$galleryname.'/'.$filename.'" width="'.$width.'" height="'.$height.'" alt="'.$altText.'">';
																					 
	}
	if($caption != '') {
		if(preg_match('/To\sbe\scontinued\./', $caption)) {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-sm-11 d-flex flex-column shadow-md #ef9a9a danger-color-lite lighten-3 px-sm-0">'.
				'<div class="card-body"><h2 style="text-align: center;"><b>To be continued...</b></h2></div>'.
				'</div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		} else {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>';
				if(isset($_SESSION['cbinfo'])) {
					$cbinfo = $_SESSION['cbinfo'];
					echo '<div class="'.$cbinfo.'">';
				} else {
					echo '<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">';}
			echo
				'<div class="card-body">'.$caption.'</div>'.
				'</div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		}
	}
	if($caption == '') {
		echo
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
	if($showFigCntr == true) {
			echo
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
			'<div class="card col-sm-1 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">'.
			'<div class="card-body"><h2>'.$FigCntr.'</h2></div>'.
			'</div>'.
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
	
		   
																
															  
				 
		  
	  
	  

