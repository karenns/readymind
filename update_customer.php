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
if (isset($_GET['customer_id'])  ){
	$customer_id = $_GET['customer_id'];
	
}else{
	header("Location: error/pageNotFound.html");
}
?>
<?php
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Customer.inc");

$customer = new Customer();	
$json_customer = $customer -> get_Customer($customer_id);

$json = json_decode($json_customer, true); // decode the JSON into an associative array


if ($json_customer){
	foreach ($json["Result"] as $field) {
		//$customer_id, $name, $company, $email, $country, $city, $phone, $created_date, $created_by	
		$country = $field['country'];
		$city = $field['city'];
		$name = $field['name'];
		$company = $field['company'];
		$email = $field['email'];	
		$phone = $field['phone'];
		$created_date = $field['created_date'];
		$created_by = $field['created_by'];
		
		$customer_id_frmt = $customer -> format_customer_id($customer_id);
	}
}
	
?>

<?php
include 'header.php';
create_header('customer');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Edit Customer</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
				<a href="view_customer.php?customer_id=<?php echo $customer_id; ?>" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                            Edit Customer
                        </div>-->
                        <div class="panel-body">
						<div class="col-md-6 col-md-offset-3">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>ID:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $customer_id_frmt;?>" disabled />
                                </div>
								<div class="form-group">
									<label>Name:</label>
									<input class="form-control" type="text" name="customer_name" required="required" maxlength="100" value="<?php echo $name; ?>"/>
                                </div>
								<div class="form-group">
									<label>Company:</label>
									<input class="form-control" type="text" name="customer_company" maxlength="100" value="<?php echo $company; ?>"/>
                                </div>
								<div class="form-group">
									<label>Email:</label>
									<input class="form-control" type="email" name="customer_email" maxlength="100" value="<?php echo $email; ?>"/>
                                </div>
								<div class="form-group">
									<label>Phone:</label>
									<input class="form-control" type="text" name="customer_phone" maxlength="15" value="<?php echo $phone; ?>"/>
                                </div>
								<div class="form-group">
									<label>Country:</label>
									 <select class="form-control" name="customer_country">
									<?php 
										if ($country == 'SG'){
											echo '<option selected value="SG">SG</option>';
											echo '<option value="US">US</option>';
										}else {
											echo '<option selected value="US">US</option>';
											echo '<option value="SG">SG</option>';
										}
									?>
									</select>
								</div>
								<div class="form-group">
									<label>City:</label>
									<input class="form-control" type="text" name="customer_city" maxlength="100" value="<?php echo $city; ?>"/>
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
								<button type="submit" name="update" class="btn btn-primary">SAVE</button>
							</form>
						</div>
						</div>
					</div>
					<!-- /. Form Elements  -->		
				</div>
				</div>
				<!-- /. ROW  -->
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
<!--
<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>
-->
<?php
include 'footer.php';
?>


<?php
		
if (isset($_POST['update'])){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
		$name = $_POST['customer_name'];
		$company = $_POST['customer_company'];
		$email = $_POST['customer_email'];
		$country = $_POST['customer_country'];
		$city = $_POST['customer_city'];
		$phone = $_POST['customer_phone'];
		
		$updated_by = $user_id;

	$customer = new Customer();	
	$result = $customer->update_Customer ($customer_id, $name, $company, $email, $country, $city, $phone, $updated_by);

	
	if ($result == true){
		showMessage();
		redirect('view_customer.php?customer_id='.$customer_id);
	}else{
		redirect('error/errorPage.html');
	}
		
}


?>

<?php 
function showMessage(){

      echo '  <script>
				alert("Customer Updated");
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


