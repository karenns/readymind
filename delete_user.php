<?php
require_once("config/config.php");

if (isset($_GET['system_user_id'])  ){
	echo 'test';
	$system_user_id = $_GET['system_user_id'];
	
	require_once(PHP_CLASS_PATH . "/User.inc");
	$user = new User();

	$has_Madetransactions = $user -> user_has_Madetransactions($system_user_id);
	
	if($has_Madetransactions === true){
		showMessage('The User cannot be deleted because it has already used the System');
		redirect('user.php');
	}else{
		$result = $user -> delete_User($system_user_id);
		if ($result){
			showMessage('User was Deleted');
			redirect('user.php');
		}else{
			showMessage('Error');
			redirect('user.php');
		}
		
	}
}else{
	redirect('error/pageNotFound.html');
}



function showMessage($message){

      echo '<script>
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