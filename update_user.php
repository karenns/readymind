<?php
session_start();
if($_SESSION['user']){
		
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];
?>

<?php
if (isset($_GET['system_user_id']) ){
	$system_user_id = $_GET['system_user_id'];
	
}else{
	header("Location: error/pageNotFound.html");
}
?>

<?php
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/User.inc");
	
	$user = new User();
	$json_users = $user -> get_User_details($system_user_id);
	$json = json_decode($json_users, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* echo '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_users){
		foreach ($json["Result"] as $field) {	
		//$quotation_number, $country, $service_type, $customer_id, $created_by, $project_name, $project_description
			$name = $field['name'];
			$email = $field['email'];
			$created_date = $field['created_date'];
			$created_by = $field['created_by'];
		}
	}

?>


<?php
include 'header.php';
create_header('user');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Edit User</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<a href="user.php" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br><br>
				<!-- Panel Info -->
				<div class="panel panel-default">
					<!--<div class="panel-heading">
						 Edit User
					</div> -->
					<div class="panel-body">
						<div class="col-md-6 col-md-offset-3">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>User ID:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $system_user_id;?>" disabled />
                                </div>
								<div class="form-group">
									<label>Name</label>
									<input class="form-control" type="text" name="name" maxlength="100" value="<?php echo $name; ?>" />
                                </div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" name="email" maxlength="100" value="<?php echo $email; ?>"/>
                                </div>								
								<div class="form-group">
                                    <label>Created Date:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $created_date;?>" disabled />
                                </div>
								<div class="form-group">
                                    <label>Created By:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $created_by;?>" disabled />
                                </div>
								<br />
								
								<!-- <a href="view_quotation.php?quotation_number=<?php echo $quotation_number;?>" role="button" class="btn btn-default">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
								<button type="submit" name="update" class="btn btn-primary">SAVE</button>
							</form>
						</div>				
					</div>
					<!-- <div class="panel-footer">
                            Panel Footer
                    </div>-->
				</div>
				<!-- /. Panel Info-->

				
				<!-- Change Password -->
				<div class="panel panel-default">
					<div class="panel-heading">
						Reset Password
					</div>
					<div class="panel-body">
	                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form role="form" method="post">								
							        <div class="form-group">
                                        <label>NEW Password</label>
                                        <input type="password" name="password1" class="form-control" maxlength="20" required="required"/>
                                    </div>
									<div class="form-group">
                                        <label>Confirm NEW Password</label>
                                        <input type="password" name="password2" class="form-control" maxlength="20" required="required"/>
                                    </div>
									
								<br>
								<center><button type="submit" name="change" class="btn btn-primary">CHANGE PASSWORD</button></center>
                                </form>

                            </div>
                        </div>
					</div>
				</div>
				<!-- /. Change Password -->					
					
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->

<?php
include 'footer.php';
?>

<?php
if (isset($_POST['update'])){
	require_once(PHP_CLASS_PATH . "/User.inc");
		$name = $_POST['name'];
		$email = $_POST['email'];

	$user = new User();	
	$result = $user->update_User($system_user_id, $name, $email);

	if ($result == true){
		showMessage('User was updated');
		redirect('update_user.php?system_user_id='.$system_user_id);
	}else{
		redirect('error/errorPage.html');
	}
		
}


if (isset($_POST['change'])){
	//$old_password = $_POST['old_password'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	
	$user = new User();
	$password_match = check_Passwords_match($password1, $password2);
	
	if ($password_match == false){
		showMessage('NEW Passwords do not match');
	}else{
		$password = $password1;
		$password_hash = $user-> hashPassword($password);
		$result = $user-> update_Password($system_user_id, $password_hash);	
		if ($result){
			showMessage('Password was changed');
		}else{
			redirect('error/errorPage.html');
		}
	}	
	
}

function check_Passwords_match($password1, $password2){
	if ($password1 === $password2){
		return true;
	}else{
		return false;
	}	
}
?>


<?php 
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
