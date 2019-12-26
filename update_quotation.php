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
if (isset($_GET['quotation_number'])  ){
	$quotation_number = $_GET['quotation_number'];
	
}else{
	header("Location: error/pageNotFound.html");
}
?>
<?php
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	//require_once(PHP_CLASS_PATH . "/Format.inc");
	
	$quotation = new Quotation();
	$json_quotation = $quotation -> get_Quotation_details($quotation_number);
	$json = json_decode($json_quotation, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* echo '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_quotation){
		foreach ($json["Result"] as $field) {	
		//$quotation_number, $country, $service_type, $customer_id, $created_by, $project_name, $project_description
			$quotation_number = $field['quotation_number'];
			$customer_id = $field['customer_id'];
			$service_type = $field['service_type'];
			$country = $field['country'];
			$project_name = $field['project_name'];	
			$project_description = $field['project_description'];	
			$created_date = $field['created_date'];
			$created_by = $field['created_by'];
			$project_date = $field['project_date']; 
			$project_value = $field['value']; 
		}
	}
	//Format customer_id pattern 001
	$customer = new Customer();
	$customer_id_format = $customer-> format_customer_id($customer_id);
			
	//Format quotation pattern
	$quotation_id_frmt = $quotation -> format_quotation($service_type, $quotation_number, $customer_id_format);
	
	//Format currency
	/*
	$frmt = new Format();
	$format_value = $frmt ->format_currency($value);
	$project_value = $format_value ;
	*/

?>

<?php
include 'header.php';
create_header('quotation');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Edit Quotation</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<a href="view_quotation.php?quotation_number=<?php echo $quotation_number; ?>" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                            Edit Customer
                        </div>-->
                        <div class="panel-body">
						<div class="col-md-12">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>ID:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $quotation_id_frmt;?>" disabled />
                                </div>
								<div class="form-group">
									<label>Country:</label>
									 <select class="form-control" name="country">
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
									<label>Service Type:</label>
									 <select class="form-control" name="service_type">
									<?php 
										if ($service_type == 'DV'){
											echo '<option selected value="DV">Development</option>';
											echo '<option value="SP">Support</option>';
										}else {
											echo '<option selected value="SP">Support</option>';
											echo '<option value="DV">Development</option>';
										}
									?> 
									</select>
								</div>
								<div class="form-group">
									<label>Customer ID:</label>
									<input class="form-control" id="disabledInput" type="text" name="customer_id" placeholder="<?php echo $customer_id_format; ?>" disabled />
                                </div>
								<div class="form-group">
									<label>Project_Date:</label>
									<input class="form-control" type="date" name="project_date" maxlength="10" value="<?php echo $project_date; ?>"/>
                                </div>
								<div class="form-group">
									<label>Project Name:</label>
									<input class="form-control" type="text" name="project_name" maxlength="100" required="required" value="<?php echo $project_name; ?>"/>
                                </div>
								<div class="form-group">
									<label>Project Description:</label>
									<textarea class="form-control" rows="20" name="project_description" maxlength="5000" maxlength="500"><?php echo $project_description; ?></textarea>
									
								</div>
								<div class="form-group">
									<label>Value:</label>
									<!--<span class="input-group-addon">$</span>-->
									<input class="form-control" type="number" step="any" name="project_value" maxlength="10" value="<?php echo $project_value; ?>"/>
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
		
if (isset($_POST['update'])){
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
		$country = $_POST['country'];
		$service_type = $_POST['service_type'];
		$project_name = $_POST['project_name'];
		$project_description = $_POST['project_description'];
		$project_date = $_POST['project_date'];
		$project_value = $_POST['project_value'];
		
		$updated_last_by = $user_id;

	$quotation = new Quotation();	
	$result = $quotation->update_Quotation($quotation_number,$country,$service_type,$project_name,$project_description, $project_date, $updated_last_by, $project_value);
	if ($result == true){
		showMessage();
		redirect('view_quotation.php?quotation_number='.$quotation_number);
	}else{
		redirect('error/errorPage.html');
	}
		
}


?>

<?php 
function showMessage(){

      echo '  <script>
				alert("Quotation Updated");
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
