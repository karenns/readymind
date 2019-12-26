<!-- HEADER  -->
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Ready Mind</title>
	<!-- BOOTSTRAP STYLES-->
    <link href='assets/css/bootstrap.css' rel='stylesheet' />
     <!-- FONTAWESOME STYLES-->
    <link href='assets/css/font-awesome.css' rel='stylesheet' />
    <!-- CUSTOM STYLES-->
    <link href='assets/css/custom.css' rel='stylesheet' />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body style="background-color:#f3f3f3;">

        <nav class='navbar navbar-default navbar-cls-top ' role='navigation' style='margin-bottom: 0'>
            <div class='navbar-header'>
                <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.sidebar-collapse'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </button>
                <a class='navbar-brand' href='home.php'>Ready Mind&nbsp;<img src='assets/img/ready_mind_transp.png' width='30px' height='35px'/></a> 
            </div>
        </nav>   
        <!-- /. NAV TOP  -->



<!-- /. HEADER  -->
<div class="row">
<br>
<br>
    <div class="col-md-6 col-md-offset-3">
        <!-- Form Elements -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
						<center><h2>SIGN IN</h2></center>
						<br><br>
                        <form role="form" method="post">
                            <div class="form-group">
                            <div class="form-group">
								<label>User ID</label>
                                <input type="text" name="user_id" class="form-control"  required="required">
                                <!--<span class="input-group-addon">@sheerindustries.com</span>-->

                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required="required" />
                            </div>
                            <br>
                            <center><button type="submit" name="submit" class="btn btn-default">ENTER</button></center>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<?php include 'footer.php'; ?>

<?php


// load up your config file
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/User.inc");

if (isset($_POST['submit'])){
	$user_id = $_POST['user_id'];
	$password = $_POST['password'];
	
	$user = new User();
	//$password_hash = $user -> hashPassword($password);
	$sign_in_authentication = $user -> is_correct_authentication($user_id, $password);
	
	if ($sign_in_authentication){
		//Create a session
		session_start();
		$_SESSION['user'] = $user_id; //set the username in a session. This serves as a global variable
		redirect('home.php');
	}else{
		//echo 'Username or password incorrect';
		showMessage('Username or password incorrect');
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