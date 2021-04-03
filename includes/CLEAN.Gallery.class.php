<?php
error_reporting(E_ALL); // disable this for production code
ini_set('display_errors', TRUE);
/*
 * Gallery Class
 * This class is used for gallery database related (connect, insert, update, and delete) operations
*/
	/*	TABLE `galleryData`
	 `gallery_id`
	 `gallery_name`
	 `oauth_id`
	 `image_hash`
	 `image_key`
	 `filename`
	 `filetype`
	 `width`
	 `height`
	 `created`
	 `lastview`
	 `views`
	*/

class Gallery {
	// Database configuration
    private $dbHost     = 'localhost'; //MySQL_Database_Host
    private $dbUsername = 'user'; //MySQL_Database_Username
    private $dbPassword = 'password'; //MySQL_Database_Password
    private $dbName     = 'gallerydata'; //MySQL_Database_Name
    private $galleryTbl    = 'gallerydata';

    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){ // limit information displayed on error
                die("Failed to connect with database. "/* . $conn->connect_error*/);
            }else{
                $this->db = $conn;
            }
        }
    }
    
	/* --------------------
	create the gallery table
	*/
public function createTable(){
   // Check whether user gallery data already exists in database
	$checkQuery = "SELECT * FROM ".$this->galleryTbl;
		// echo $prevQuery."<br>";
	$checkResult = $this->db->query($checkQuery);
	if($checkResult != NULL){
	$drop = "DROP TABLE ".$this->galleryTbl.";";
		if ($this->db->query($drop) === TRUE) {
				echo "Gallery Table dropped successfully<br>";
				} else {
				echo "Error dropping Gallery Table: <br>"; // leave off $conn->error;
	}}
	$sql =
	 "CREATE TABLE IF NOT EXISTS `gallerydata` (
	 `gallery_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	 `gallery_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `oauth_id` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `image_hash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `image_key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `filetype` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `width` int (5) NOT NULL,
	 `height` int (5) NOT NULL,
	 `created` datetime DEFAULT NULL
	 ) COLLATE=utf8mb4_unicode_ci;
	";
	if ($this->db->query($sql) === TRUE) {
		echo "Gallery Table created successfully<br>";
		} else {
		echo "Error creating Gallery Table: <br>"; // leave off $conn->error;
	}
}
	
	// ----------------------------
	// insert gallery data into table
public function insertGallery($galleryData){
	if(!empty($galleryData)){
		// Check whether user gallery data already exists in database
		$prevQuery = "SELECT * FROM `".$this->galleryTbl."` WHERE image_key = '".$galleryData['image_key']."' AND gallery_name = '".$galleryData['gallery_name']."'";
		//$_SESSION['prevQuery'] = $prevQuery;
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 0){
			// Insert gallery data
			$query = "INSERT INTO `".$this->galleryTbl."` (gallery_name, oauth_id, image_hash, image_key, filename, filetype, width, height, created) VALUES ('".$galleryData['gallery_name']."', '".$galleryData['oauth_id']."', '".$galleryData['image_hash']."', '".$galleryData['image_key']."', '".$galleryData['filename']."', '".$galleryData['filetype']."', '".$galleryData['width']."', '".$galleryData['height']."', now())";
			$insert = $this->db->query($query);
			/*	$_SESSION['insertQuery'] = $query;
			if ($insert === TRUE) {
				$_SESSION['resultMsg'] = "Record updated successfully";
				//$_SESSION['insertCount'] = $_SESSION['insertCount'] + 1;
			} else {
				$_SESSION['resultMsg'] = "Error updating record"; // leave off $conn->error;
			} */
		}
		// Get gallery data from the database
		$result = $this->db->query($prevQuery);
		$galleryData = $result->fetch_assoc();
	}
    // Return gallery data
    return $galleryData;
}

	// ---------------------------------
	// return an array of gallery record keys by gallery name
public function listGallery($gallery_name, $like = false){
	if(!empty($gallery_name)){
		// gallery data exists in database
		$UserGallery = array();
		// execute function
		if($like === true) {
			$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE gallery_name LIKE '".$gallery_name."%'";
		} else {
			$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE gallery_name LIKE '".$gallery_name."'";
		}
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // image_key values into an array
			while($arr = $Result->fetch_assoc()) {
				$UserGallery[] = $arr['image_key'];
			}
			$_SESSION['listGalleryResult'] = $UserGallery;
		}
	// Return gallery data
	return $UserGallery;
	}
}

	// ---------------------------------
	// return an array of gallery record keys by oauth_id
public function listOauthGallery($oauth_id) {
	if(!empty($oauth_id)){
		// gallery data exists in database
		$UserGallery = array();
		// execute function
		$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE oauth_id LIKE '".$oauth_id."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // image_key values into an array
			while($arr = $Result->fetch_assoc()) {
				$UserGallery[] = $arr['image_key'];
			}
			$_SESSION['listGalleryResult'] = $UserGallery;
		}
	// Return gallery data
	return $UserGallery;
	}	
}

	// ---------------------------------
	// return an array of gallery record keys by datetime age
public function listAgedGallery($interval = 8) {
	$UserGallery = array();
	// execute function
	$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE created < DATE_SUB(NOW(), INTERVAL '".$interval."' HOUR)";
	$Result = $this->db->query($Query);
	/* determine number of rows in result set */
	 //printf("Result set has %d rows.<br>", $Result->num_rows);
	if($Result) { // image_key values into an array
		while($arr = $Result->fetch_assoc()) {
			$UserGallery[] = $arr['gallery_name'] . ',' . $arr['image_key'];
		}
	// Return gallery data
	return $UserGallery;
	}
}

// ---------------------------------
	// delete an array of gallery records by gallery name
public function deleteGallery($gallery_name){
	if(!empty($gallery_name)){
		// gallery data exists in database
		$UserGallery = array();
		// execute function
		$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE gallery_name LIKE '".$gallery_name."%'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // image_key values into an array
			while($arr = $Result->fetch_assoc()) {
				$UserGallery[] = $arr['image_key'];
				$image_key = $arr['image_key'];
                $query = "DELETE FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
				//echo $query."<br>";
                $delete = $this->db->query($query);
			}
		// Return gallery data
		return $UserGallery;
		}
	}
}

// ---------------------------------
	// delete an array of gallery records by oauth id
public function deleteOauthGallery($oauth_id){
	if(!empty($oauth_id)){
		// gallery data exists in database
		$UserGallery = array();
		// execute function
		$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE oauth_id LIKE '".$oauth_id."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // image_key values into an array
			while($arr = $Result->fetch_assoc()) {
				$UserGallery[] = $arr['image_key'];
				$image_key = $arr['image_key'];
                $query = "DELETE FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
				//echo $query."<br>";
                $delete = $this->db->query($query);
			}
		// Return gallery data
		return $UserGallery;
		}
	}
}

	// ---------------------------------
	// return a gallery record
public function returnImage($image_key){
	if(!empty($image_key)){
		// Check whether gallery data exists in database
		//echo "gallery_name : ".$userData['gallery_name']."<br>";
		$Query = "SELECT * FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result->num_rows == 1){
		// Get gallery data from the database
		$result = $this->db->query($Query);
		$galleryData = $result->fetch_assoc();
		}
	}
	// Return gallery data
	return $galleryData;
}

	// ------------------------------------
	// update views count and lastview date
public function updateGallery($image_key){
	if(!empty($image_key)){
		// Check whether user gallery data already exists in database
		$prevQuery = "SELECT * FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// Update gallery data if already exists
			// change views = '".$galleryData['views']."', lastview = '".$galleryData['lastview']."',
			$query = "UPDATE `".$this->galleryTbl."` SET views = views+1, lastview = NOW() WHERE image_key = '".$image_key."'";
			//echo $query."<br>";
			$update = $this->db->query($query);
		}
		// Get gallery data from the database
		$result = $this->db->query($prevQuery);
		$galleryData = $result->fetch_assoc();
	}
	// Return gallery data
	return $galleryData;
}

	// ------------------------------------
	// delete a gallery record from the table
public function deleteGalleryRecord($image_key){
	if(!empty($image_key)){
		// Check whether user gallery data already exists in database
		$prevQuery = "SELECT * FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// DELETE gallery data if already exists
			// change views = '".$galleryData['views']."', lastview = '".$galleryData['lastview']."',
			$query = "DELETE FROM `".$this->galleryTbl."` WHERE image_key = '".$image_key."'";
			//echo $query."<br>";
			$delete = $this->db->query($query);
		}
		// Get gallery data from the database
		$result = $this->db->query($prevQuery);
		$galleryData = $result->fetch_assoc();
	}
	// Return gallery data
	return $galleryData;
}
/* close connection */
//$mysqli->close();
}
?>