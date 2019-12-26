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

if (isset($_GET['customer_id'])){
	$customer_id = $_GET['customer_id'];

}else{
	header("Location: error/pageNotFound.html");
}
	
?>

<?php
require_once(PHP_CLASS_PATH . "/Customer.inc");
	$customer = new Customer();
	$json_customer = $customer -> get_Customer($customer_id);
	
	$json = json_decode($json_customer, true); // decode the JSON into an associative array
	
	if ($json_customer){
		foreach ($json["Result"] as $field) {
			//$customer_id, $name, $company, $email, $country, $city, $phone, $created_date, $created_by	
			$country = $field['country'];
			$customer_id = $field['customer_id'];
			$name = $field['name'];
			$company = $field['company'];
			
		    $customer_id_format = $customer -> format_customer_id($customer_id);
		}
	}else{
		redirect(error/errorPage.html);
	}	

?>

<?php
include 'header.php';
create_header('quotation');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Create Quotation</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<a href="view_customer.php?customer_id=<?php echo $customer_id;?>" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<div class="row">
                <div class="col-md-12">
				
					<!-- Panel Info -->
					<div class="panel panel-default">
					<!--<div class="panel-heading">
                     Customer
					</div>-->
						<div class="panel-body">
						<strong>Customer</strong><br><br>
						<table style="width:90%;">
							<tr>
							<td>ID:</td>
							<td><?php echo $customer_id_format; ?></td>
							</tr>
							<tr>
							<td> Name:</td>
							<td><?php echo $name; ?></td>
							</tr>
							<tr>
							<td>Company:</td>
							<td><?php echo $company; ?></td>
							</tr>
						</table>
	
						</div>
					</div>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                            Edit Customer
                        </div>-->
                        <div class="panel-body">
						<div class="col-md-12">
                            <form role="form" method="post">
								<div class="form-group">
									<label>Country:</label>
									<select class="form-control" name="country">
										<option selected value="US">US</option>
										<option value="SG">SG</option>
									</select>
								</div>
								<div class="form-group">
									<label>Service Type:</label>
									<select class="form-control" name="service_type">
										<option selected value="DV">Development</option>
										<option value="SP">Support</option>
									</select>
								</div>
								<?php require_once(PHP_CLASS_PATH . "/Format.inc"); $format = new Format(); $today=$format->format_date(); ?>
								<div class="form-group">
									<label>Project_Date:</label>
									<input class="form-control" type="date" name="project_date" maxlength="10" value="<?php echo $today; ?>"/>
                                </div>
								<div class="form-group">
									<label>Project Name:</label>
									<input class="form-control" type="text" name="project_name" maxlength="100" required="required"/>
                                </div>
								<div class="form-group">
									<label>Project Description:</label>
									<textarea class="form-control" rows="20" name="project_description" maxlength="5000"></textarea>
									
								</div>
								<div class="form-group">
									<label>Value:</label>
									<!--<span class="input-group-addon">$</span>-->
									<input class="form-control" type="number" step="any" name="project_value" maxlength="10"/>
                                </div>
								<br />
								<button type="submit" name="submit" class="btn btn-primary">CREATE</button>
							</form>
						</div>
						</div>
					</div>
					<!-- /. Form Elements  -->		
				</div>
				</div>
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

if (isset($_POST['submit'])){
	$created_by = $user_id;
	$service_type = $_POST['service_type'];
	$country = $_POST['country'];
	$project_name = $_POST['project_name'];
	$project_description = $_POST['project_description'];
	$project_date = $_POST['project_date'];
	$project_value = $_POST['project_value'];
	//echo $project_date;

require_once(PHP_CLASS_PATH . "/Quotation.inc");

$quote = new Quotation();	
$result = $quote->add_Quotation($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date, $project_value);


if ($result == true){
	//echo 'Result: OK';
	$quotation_number = $quote-> get_Quotation_id($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date);
	
	$customer = new Customer();
	$customer_id_frmt = $customer -> format_customer_id($customer_id);
	$quotation_frmt = $quote -> format_quotation($service_type, $quotation_number, $customer_id_frmt, $country);
	showMessage($quotation_frmt);
	redirect('view_quotation.php?quotation_number='.$quotation_number);

}else{
	//echo 'ERROR';
	redirect('error/errorPage.html');
}

}

?>


<?php 
function showMessage($message){

      echo '  <script>
				alert("Quotation created. Quotation ID:  '.$message.'");
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
