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
if (isset($_GET['customer_id'])){
	$customer_id = $_GET['customer_id'];
}else{
	header("Location: error/pageNotFound.html");
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
                     <center><h2>Customer Details</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<a href="customer.php" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<!-- Panel Info -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Customer
					</div>-->
					<div class="panel-body">

					<a href="update_customer.php?customer_id=<?php echo $customer_id; ?>" class="btn btn-primary pull-right">
						<i class="fa fa-edit "></i>Edit
					</a>

					<center>
					<table style="width:90%;">
						<?php showCustomer_details($customer_id); ?>
					</table>
					</center>
		
					</div>
				</div>
				<!-- /. Panel Info-->
				<center>
					<a href="create_quotation.php?customer_id=<?php echo $customer_id; ?>" class="btn btn-info btn-lg">Create Quotation</a>
				</center><br><br>
				<!--    Striped Rows Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Quotation List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Quotation ID</th>
                                            <th>Project Name</th>
                                            <th>Project Date</th>
											<th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $quantity_quotation = showQuotations($customer_id);?>
                                    </tbody>
                                </table>
                            </div>
							<p>Total Row(s): <?php echo $quantity_quotation ;?></p>
                        </div>
                    </div>
                <!--  End  Striped Rows Table  -->
				
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

function showQuotations($customer_id){
$quantity_quotation = 0;
/*
JSON 
http://stackoverflow.com/questions/19758954/get-data-from-json-file-with-php

*/
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Quotation.inc");

$quote = new Quotation();	
$json_quotations_customer = $quote -> get_Quotations_by_Customer_id($customer_id);

/*	Print the JSON	*/
/* echo $json_customer; */

$json = json_decode($json_quotations_customer, true); // decode the JSON into an associative array

/*	Print the Array Structure	*/
/* echo '<pre>' . print_r($json, true) . '</pre>'; */

/* Example Array Json */
/* $name_custom = $json["Result"][1]["name"]; */


if ($json_quotations_customer){
	foreach ($json["Result"] as $field) {
		//$quotation_id, $customer_id, $created_by, $project_name, $project_description
		$quotation_number = $field['quotation_number'];
		$country = $field['country'];
		$service_type= $field['service_type'];
		$project_name = $field['project_name'];
		$project_description = $field['project_description'];
		$project_date = $field['project_date'];	
		$created_by = $field['created_by'];	
		
		$customer = new Customer();
		$customer_id_format = $customer -> format_customer_id($customer_id);
		
		$quotation_id = $quote -> format_quotation($service_type, $quotation_number, $customer_id_format);

		echo '<tr>';
		echo '<td>' . $quotation_id . '</td>';
		echo '<td>' . $project_name . '</td>';
		echo '<td>' . $project_date . '</td>';
		echo '<td> <a href="view_quotation.php?quotation_number='.$quotation_number.'" >View</a></td>';
		echo '</tr>';
		
		$quantity_quotation = $quantity_quotation+1;
	}
}else{
	header("Location: error/errorPage.html");
}
return $quantity_quotation;		
}

function showCustomer_details($customer_id){
/*
JSON 
http://stackoverflow.com/questions/19758954/get-data-from-json-file-with-php

*/
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Customer.inc");

$customer = new Customer();	
$json_customer = $customer -> get_Customer($customer_id);

/*	Print the JSON	*/
/* echo $json_customer; */

$json = json_decode($json_customer, true); // decode the JSON into an associative array

/*	Print the Array Structure	*/
/* echo '<pre>' . print_r($json, true) . '</pre>'; */

/* Example Array Json */
/* $name_custom = $json["Result"][1]["name"]; */

if ($json_customer){
	foreach ($json["Result"] as $field) {
		//$customer_id, $name, $company, $email, $country, $city, $phone, $created_date, $created_by	
		$country = $field['country'];
		$customer_id = $field['customer_id'];
		$name = $field['name'];
		$company = $field['company'];
		$email = $field['email'];	
		$phone = $field['phone'];
		$city = $field['city'];
		$created_date = $field['created_date'];
		$created_by = $field['created_by'];
		
		
		$customer_id_format = $customer -> format_customer_id($customer_id);
		/*
		echo '<h5>Customer ID: '.$customer_id_format.'</h5>';
		echo '<h5>Name: '.$name.'</h5>';
		echo '<h5>Company: '.$company.'</h5>';
		echo '<h5>Email: '.$email.'</h5>';
		echo '<h5>Phone: '.$phone.'</h5>';
		echo '<h5>Created Date: '.$created_date.'</h5>';
		echo '<h5>Created By: '.$created_by.'</h5>';
		*/

		echo '<tr>';
		echo '<td>ID:</td>';
		echo '<td>' .$customer_id_format.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td> Name:</td>';
		echo '<td>' .$name.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Company:</td>';
		echo '<td>' .$company.'</td>';
		echo '</tr>';
		echo '<td>Email:</td>';
		echo '<td>' .$email.'</td>';
		echo '</tr>';
		echo '<td>Phone:</td>';
		echo '<td>' .$phone.'</td>';
		echo '</tr>';
		echo '<td>Country:</td>';
		echo '<td>' .$country.'</td>';
		echo '</tr>';
		echo '<td>City:</td>';
		echo '<td>' .$city.'</td>';
		echo '</tr>';
		echo '<td>Created Date:</td>';
		echo '<td>' .$created_date.'</td>';
		echo '</tr>';
		echo '<td>Created By:</td>';
		echo '<td>' .$created_by.'</td>';
		echo '</tr>';		

	}
}else{
	header("Location: error/errorPage.html");
}
	
}


?>

