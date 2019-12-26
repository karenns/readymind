<?php
session_start();

if($_SESSION['user']){
	////Only the user admin is allowed to create users
	if ($_SESSION['user'] == 'admin'){
		
	}else{
		header("location:error/pageNotFound.html");
	}
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];
?>

<?php 
include 'header.php'; 
create_header('user');

?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h2>System User</h2>
                </center>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create an User
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form role="form" method="post">
									<div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" maxlength="100" required="required"/>
										
                                    </div>
									<!--<div class="form-group">
                                        <label>Sheer Red UserID</label>
                                        <input type="text" name="user_id" class="form-control" placeholder="Choose an userID" required="required"/>
                                    </div>-->
									<div class="form-group">
										<label>User ID*</label>
                                        <input type="text" name="system_user_id" class="form-control" placeholder="Choose an userID" maxlength="50" required="required"/>
										<!--<span class="input-group-addon">@sheerindustries.com</span>-->	
										<p class="help-block">*The User ID will be used to access the system</p>
									</div>
									<div class="form-group">
										<label>Email</label>
                                        <input type="text" name="email" class="form-control" placeholder="email@sheerindustries.com" maxlength="100"/>
										<!--<span class="input-group-addon">@sheerindustries.com</span>-->	
                                    </div>
									
							        <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password1" class="form-control" maxlength="20" required="required"/>
                                    </div>
									<div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password2" class="form-control" maxlength="20" required="required"/>
                                    </div>
									
								<br>
								<button type="submit" name="submit" class="btn btn-primary">Create</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <!-- <div class="panel-heading">
                        List
                    </div> -->
                    <div class="panel-body">
						    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
											<th>User ID</th>
                                            <th>Name</th>
											<th>Email</th>
                                            <th>Edit</th>
											<th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											showAll_Users();
										?>
										
                                   </tbody>
                                </table>
							</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<?php include 'footer.php'; ?>

<?php
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/User.inc");

if (isset($_POST['submit'])){
	$system_user_id = $_POST['system_user_id'];
	$name = $_POST['name'];
	//$email = $system_user_id.'@sheerindustries.com';
	$email = $_POST['email'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];

	$user = new User();
	$user_id_Available = $user -> is_User_id_available($system_user_id);

	if ($user_id_Available == false){
		//echo 'Choose another system_user_id';
		showMessage('UserID: '.$system_user_id.' already registered');
	}
	
	/*
	$correct_email = $user -> is_correct_email($email);
	if ($correct_email == false){
		//echo 'Enter a valid @sheerindustries.com email';
		showMessage('Enter a valid @sheerindustries.com email');
	}
	*/
	
	$password_match = check_Passwords_match($password1, $password2);
	if ($password_match == false){
		//echo 'Password do not match';
		showMessage('Password do not match');
	}
	
	//if (($user_id_Available)&&($correct_email)&&($password_match)){
	if (($user_id_Available)&&($password_match)){
		$password = $password1;
		$created_by = $user_id;
		
		//Encrypted password
		$user = new User();
		$password_hash = $user-> hashPassword($password);
		
		$result = $user-> add_User($system_user_id,$name,$email,$password_hash,$created_by);
		
		if ($result){
			showMessage('User '.strtoupper($system_user_id).' was succesfully created');
			redirect('user.php');
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

function showAll_Users(){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/User.inc");
	
	$user = new User();
	$json_users = $user -> get_All_Users();
	$json = json_decode($json_users, true); // decode the JSON into an associative array
	
	if ($json_users){
		foreach ($json["Result"] as $field) {	
			$system_user_id = $field['user_id'];
			$name = $field['name'];
			$email = $field['email'];
			
			echo '<tr>';
			echo '<td>' . $system_user_id . '</td>';
			echo '<td>' . $name. '</td>';
			echo '<td>' . $email . '</td>';
			echo '<td> <a href="update_user.php?system_user_id='.$system_user_id.'" >Edit</a></td>';
			echo '<td> <a href="delete_user.php?system_user_id='.$system_user_id.'">Delete</a></td>';
			echo '</tr>';
		}
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