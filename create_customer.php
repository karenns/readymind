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
include 'header.php';
create_header('customer');

?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Create Customer</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
				
				<a href="customer.php" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
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
									<label>Name:</label>
									<input class="form-control" type="text" name="customer_name" maxlength="100" required="required"  value=""/>
                                </div>
								<div class="form-group">
									<label>Company:</label>
									<input class="form-control" type="text" name="customer_company" maxlength="100" value=""/>
                                </div>
								<div class="form-group">
									<label>Email:</label>
									<input class="form-control" type="email" name="customer_email"maxlength="100" value=""/>
                                </div>
								<div class="form-group">
									<label>Phone:</label>
									<input class="form-control" type="text" name="customer_phone" maxlength="15" value=""/>
                                </div>
								<div class="form-group">
									<label>Country:</label>
									 <select class="form-control" name="customer_country">
										<option selected value="US">US</option>
										<option value="SG">SG</option>
									</select>
								</div>
								<div class="form-group">
									<label>City:</label>
									<input class="form-control" type="text" name="customer_city" value=""/>
                                </div>
								<br />
								<button type="submit" name="create" class="btn btn-primary">CREATE</button>
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

<?php
include 'footer.php';
?>

<?php

require_once(PHP_CLASS_PATH . "/Customer.inc");
	
if (isset($_POST['create'])){
	
	$name = $_POST['customer_name'];
	$company = $_POST['customer_company'];
	$email = $_POST['customer_email'];
	$country = $_POST['customer_country'];
	$city = $_POST['customer_city'];
	$phone = $_POST['customer_phone'];
	$created_by = $user_id;
	


$customer = new Customer();	

//$customer_id = $customer->next_Customer_id();
$result = $customer->add_Customer($name, $company, $email, $country, $city, $phone, $created_by);
	
	
if ($result == true){
	//echo 'Result: OK';
	$customer_id =  $customer->get_Customer_id($name, $company, $email, $country, $city, $phone, $created_by);
	$customer_id_frmt = $customer->format_customer_id($customer_id) ;
	showMessage($customer_id_frmt);
	redirect('view_customer.php?customer_id='.$customer_id);

}else{
	//echo 'ERROR';
	redirect('error/errorPage.html');
}

	
}

?>

<?php 
function showMessage($message){

      echo '  <script>
				alert("Account created. ID customer:  '.$message.'");
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