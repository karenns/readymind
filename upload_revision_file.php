<?php
session_start();
if($_SESSION['user']){
	$user_id = $_SESSION['user'];	
}
else{
	header("location:index.php");
}


?>

<?php
require_once("config/config.php");

if (isset($_POST["submit"])) {

$quotation_number =$_POST['quotation_number'];
$revision_id =$_POST['revision_id'];


require_once(PHP_CLASS_PATH . "/Revision.inc");

$revision = new Revision();
$revision_letter = $revision -> get_revisionLetter($revision_id);
	
/* CREATE FOLDER IF IT DOES NOT EXISTS	*/
$dir = 'uploads/'.$quotation_number.'/'.$revision_letter.'/';
//echo $dir;
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$target_dir = $dir;
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


	/*
	// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
	*/
	$uploadOk = 1;
	$file_name = basename( $_FILES["fileToUpload"]["name"]);
	// Check if file already exists
	if (file_exists($target_file)) {
		//echo "Sorry, file already exists.";
		showMessage("Sorry, file already exists.");
		$uploadOk = 0;
	}
	// Check file size
	//If the file is larger than 10MB, an error message is displayed. Ex:500000=500KB
	if ($_FILES["fileToUpload"]["size"] > 100000000) {
		//echo "Sorry, your file is too large.";
		showMessage("Sorry, your file is too large.");
		$uploadOk = 0;
	}
	// Allow certain file formats
	/*
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	*/
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		//echo "Sorry, your file was not uploaded.";
		showMessage("Sorry, your file was not uploaded. Try again.");
	// if everything is ok, try to upload file
	} else {
		if ((move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) && (save_onDatabase($revision_id,$file_name,$user_id))) {
			//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			showMessage("The file has been uploaded.");
			redirect('view_revision.php?revision_id='.$revision_id);
		} else {
			//echo "Sorry, there was an error uploading your file.";
			showMessage("Sorry, there was an error uploading your file.");
		}
	}

}

function save_onDatabase($revision_id,$file_name,$user_id){
	include_once('inc/Revision_Files.inc');
	$file = new Revision_Files();
	$sucess = $file -> add_File($revision_id, $file_name, $user_id);
	
return $sucess;
}

?>

<?php 
function showMessage($message){

      echo '  <script>
				alert("'.$message.'");
			  </script>';
}

function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
      header('Location: ' . $url);
      die();
	}    
}

?>