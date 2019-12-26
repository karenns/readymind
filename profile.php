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
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/User.inc");

	$user = new User();
	$json_users = $user -> get_User_details($user_id);
	$json = json_decode($json_users, true); // decode the JSON into an associative array

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
create_header('profile');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Profile</h2></center> 
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<!-- Panel Profile -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Customer
					</div>-->
					<div class="panel-body">
					    <div class="row">
                            <div class="col-md-6 col-md-offset-3">
								<center>
								<table style="width:90%;">
									<tr>
									<td>Name:</td>
									<td align="center"><?php echo $name;?></td>
									</tr>
									<tr>
									<td>Email:</td>
									<td align="center"><?php echo $email;?></td>
									</tr>

								</table>
								</center>
									
								<br>
								<!--<button type="submit" name="submit" class="btn btn-primary">Create</button>-->
                                <!--<center>
								<a href="update_profile.php?user=<?php echo $user_id; ?>" class="btn btn-primary">
								<i class="fa fa-edit "></i>&nbsp;&nbsp;Edit</a>
								</center>
								-->

                            </div>
                        </div>
					</div>
				</div>
				<!-- /. Panel Profile-->
				
				<!-- Panel Password -->
				<div class="panel panel-default">
					<div class="panel-heading">
                     Change Password
					</div>
					<div class="panel-body">
	                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form role="form" method="post">
							        <div class="form-group">
                                        <label>OLD Password</label>
                                        <input type="password" name="old_password" class="form-control" maxlength="20" required="required"/>
                                    </div>
									
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
				<!-- /. Panel Password-->
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
if (isset($_POST['change'])){
	$old_password = $_POST['old_password'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	
	$user = new User();
	$sign_in_authentication = $user -> is_correct_authentication($user_id, $old_password);
	
	if ($sign_in_authentication){
		$password_match = check_Passwords_match($password1, $password2);
		if ($password_match == false){
			showMessage('NEW Passwords do not match');
		}else{
			$password = $password1;
			$password_hash = $user-> hashPassword($password);
			$result = $user-> update_Password($user_id, $password_hash);	
			if ($result){
				showMessage('Password was changed');
			}else{
				redirect('error/errorPage.html');
			}
		}	
	}else{
		showMessage('Old Password is incorrect');
	}
	
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

function check_Passwords_match($password1, $password2){
	if ($password1 === $password2){
		return true;
	}else{
		return false;
	}	
}

?>