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

if (isset($_GET['update'])){
	require_once(PHP_CLASS_PATH . "/Revision.inc");
	$revision_id = $_GET['revision_id'];
	$newStatus_Id = $_GET['new_status'];

	echo $newStatus_Id;
	$revision = new Revision();
	$result = $revision -> set_StatusID($revision_id, $newStatus_Id, $user_id);
	
	if ($result == true){
		showMessage();
		redirect('view_revision.php?revision_id='.$revision_id);
	}else{
		redirect('error/errorPage.html');
	}
	
}

function showMessage(){

      echo '  <script>
				alert("Status Updated");
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