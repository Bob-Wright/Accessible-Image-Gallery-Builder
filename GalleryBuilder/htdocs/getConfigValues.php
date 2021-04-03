<?php
/*
 * filename: getConfigValues.php
 * this code displays the gallery config values from the SESSION
*/

$configContent = '';

	$configContent .= '<p>';
	if(isset($_SESSION["siteurl"])){
		$siteurl = $_SESSION["siteurl"];
		$configContent .= 'the [siteurl] is ['.$siteurl.']';
		} else {
		$configContent .= 'the [siteurl] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["galleryname"])){
		$galleryname =  $_SESSION["galleryname"];
		$configContent .= 'the [galleryname] is ['.$galleryname.']';
		} else {
		$configContent .= 'the [galleryname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["pagetitle"])){
		$pagetitle = $_SESSION["pagetitle"];
		$configContent .= 'the [pagetitle] is ['.$pagetitle.']';
		} else {
		$configContent .= 'the [pagetitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["bkgndImage"])){
		$bkgndImage = $_SESSION["bkgndImage"];
		$configContent .= 'the [bkgndImage] is ['.$bkgndImage.']';
		} else {
		$configContent .= 'the [bkgndImage] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["sitename"])){
		$sitename = $_SESSION["sitename"];
		$configContent .= 'the [sitename] is ['.$sitename.']';
		} else {
		$configContent .= 'the [sitename] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["sitesubtitle"])){
		$sitesubtitle = $_SESSION["sitesubtitle"];
		$configContent .= 'the [sitesubtitle] is ['.$sitesubtitle.']';
		} else {
		$configContent .= 'the [sitesubtitle] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["noZoomSitename"])){
		$noZoomSitename = $_SESSION["noZoomSitename"];
		$configContent .= 'the [noZoomSitename] is ['.$noZoomSitename.']';
		} else {
		$configContent .= 'the [noZoomSitename] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["navmenu"])){
		$navmenu = $_SESSION["navmenu"];
		$configContent .= 'the [navmenu] is ['.$navmenu.']';
		} else {
		$configContent .= 'the [navmenu] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["gallerydisplayname"])){
		$gallerydisplayname = $_SESSION["gallerydisplayname"];
		$configContent .= 'the [gallerydisplayname] is ['.$gallerydisplayname.']';
		} else {
		$configContent .= 'the [gallerydisplayname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["gallerydesc"])){
		$gallerydesc = $_SESSION["gallerydesc"];
		$configContent .= 'the [gallerydesc] is ['.$gallerydesc.']';
		} else {
		$configContent .= 'the [gallerydesc] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["gallerycomment"])){
		$gallerycomment = $_SESSION["gallerycomment"];
		$configContent .= 'the [gallerycomment] is ['.$gallerycomment.']';
		} else {
		$configContent .= 'the [gallerycomment] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["galleryemail"])){
		$galleryemail = $_SESSION["galleryemail"];
		$configContent .= 'the [galleryemail] is ['.$galleryemail.']';
		} else {
		$configContent .= 'the [galleryemail] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["artistname"])){
		$artistname = $_SESSION["artistname"];
		$configContent .= 'the [artistname] is ['.$artistname.']';
		} else {
		$configContent .= 'the [artistname] is not set';
		}
	$configContent .= '<br>';
	if(isset($_SESSION["oauth_id"])){
		$oauth_id = $_SESSION["oauth_id"];
		$configContent .= 'the [oauth_id] is ['.$oauth_id.']';
		} else {
		$configContent .= 'the [oauth_id] is not set';
		}
	$configContent .= '</p>';
echo $configContent;
?>
