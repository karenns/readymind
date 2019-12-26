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
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	
	$quotation_number = $_GET['quotation_number'];
	$newStatus_Id = $_GET['new_status'];

	echo $newStatus_Id;
	$quote = new Quotation();
	$result = $quote -> set_StatusID($quotation_number, $newStatus_Id, $user_id);
	
	if ($result == true){
		showMessage();
		redirect('view_quotation.php?quotation_number='.$quotation_number);
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