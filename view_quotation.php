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
if (isset($_GET['quotation_number']) ){
	$quotation_number = $_GET['quotation_number'];
	//session_start();
	$_SESSION['quotation_number'] = $quotation_number;
	
}else{
	header("Location: error/pageNotFound.html");
}
?>
<?php
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Quotation.inc");
$quote = new Quotation();
$customer_id  = $quote -> get_Customer_id($quotation_number);

?>

<?php
	$quotation = new Quotation();
	$status_id = $quotation -> get_StatusID($quotation_number);

?>
<?php
require_once(PHP_CLASS_PATH . "/Status.inc");
$status = new Status();

$status_name1 = $status -> getStatus_Name(1);
$status_name2 = $status -> getStatus_Name(2);
$status_name3 = $status -> getStatus_Name(3);
$status_name4 = $status -> getStatus_Name(4);
?>

<?php
include 'header.php';
create_header('quotation');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
					<div class="col-md-4">
                      
                     <!--  Modals-->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Change the Status</h4>
                                        </div>
                                        <div class="modal-body">              
											<form role="form" action="update_status.php" method="get">	
												<input type="hidden" name="quotation_number" value="<?php echo $quotation_number; ?>" />
												<br>
												<label>NEW Status:</label>
												<select class="form-control" name="new_status">
													<option selected value="1"><?php echo strtoupper($status_name1); ?></option>
													<option value="2"><?php echo strtoupper($status_name2); ?></option>
													<option value="3"><?php echo strtoupper($status_name3); ?></option>
													<option value="4"><?php echo strtoupper($status_name4); ?></option>
												</select>
											<!-- /. ROW -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" name="update" class="btn btn-primary">Save changes</button>
                                            <!--<button type="button" class="btn btn-primary" name="submit">Save changes</button>-->
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>
                     <!-- End Modals-->
					</div>
                </div>
				<!-- MoDAL End -->
			
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Quotation Details</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<!--<a href="view_customer.php?customer_id=<?php echo $customer_id; ?>" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a> -->
				<a href="quotation.php" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<!-- Panel Info -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Quotation
					</div>-->
					<div class="panel-body">

					<a href="update_quotation.php?quotation_number=<?php echo $quotation_number; ?>" class="btn btn-primary pull-right">
						<i class="fa fa-edit "></i>Edit
					</a>

					<center>
					<table style="width:90%;">
						<?php get_Quotation_details($quotation_number); ?>
					</table>
					</center>					
					</div>
					<!-- <div class="panel-footer">
                            Panel Footer
                    </div>-->
				</div>
				<!-- /. Panel Info-->

				<h4 style="color:red;">&nbsp;&nbsp;Customer</h4>	
				<!-- Panel Customer -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Customer 
					</div> -->
					<div class="panel-body">
					<a href="view_customer.php?customer_id=<?php echo $customer_id; ?>" class="btn btn-default pull-right">
						<i class="fa fa-search "></i>View
					</a>
					<center>
					<table style="width:90%;">
						<?php showCustomer_details($customer_id); ?>
					</table>
					</center>

					</div>
				</div>
				<!-- /. Panel Customer -->				

				<!-- Panel REVISION -->
				<div class="panel panel-default">
				<div class="panel-heading">
                     Revisions
				</div>
					<div class="panel-body">
					<!--<center>
					</center> -->
					        <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Letter</th>
											<th>Status</th>
                                            <th>Name</th>
											<th>Date</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
											showAll_Revisions($quotation_number);

										?>
										
                                   </tbody>
                                </table>
                            </div>
					
					</div>
				</div>
				<!-- /. Panel REVISION-->
				<center>
				<?php 
					if (($status_id == 1)||($status_id == 2)){
						echo '
							<button type="button" disabled class="btn btn-primary btn-md"><i class="fa fa-pencil "></i>&nbsp;&nbsp;NEW REVISION</button>
						';
					}else{
						echo '
							<a href="create_revision.php?quotation_number='.$quotation_number.'" class="btn btn-primary btn-md">
							<i class="fa fa-pencil "></i>&nbsp;&nbsp;NEW REVISION
							</a>
						';
					}				
				?>

				</center><br><br>
				
				<!-- Panel Files -->
				<div class="panel panel-default">
					<div class="panel-heading">
                     Attached Files
					</div>
					<div class="panel-body">
					<!--<i class="fa fa-file "></i>&nbsp;&nbsp;<a href="#">quotation_number001_Leonard-20150901.pdf</a>
					<br/> -->
					<?php getAll_Files($quotation_number);?>
					<br/>
					<br/>
					</div>
				</div>
				<!-- /. Panel Files-->	
				<!--<center>
					<a href="#" class="btn btn-info btn-md"><i class="fa fa-file "></i>&nbsp;Upload File</a>
				</center>
				-->
					<form role="form" action="upload_quotation_file.php" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>Upload file</label>
								    <input type="file" name="fileToUpload" id="fileToUpload"><br>
									<input type="submit" name="submit" value="Upload File" />
							</div>
					</form>
				
								<!-- Panel INVOICES -->
				<div class="panel panel-default">
				<div class="panel-heading">
                     Invoices
				</div>
					<div class="panel-body">
					<!--<center>
					</center> -->
					        <div class="table-responsive">
                                <table id="tblListInvoice" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
											<th>Date</th>
											<th>Value</th>
											<th>Status</th>
                                            <th>View/Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>										
                                   </tbody>
                                </table>
                            </div>
					
					</div>
				</div>
				<!-- /. Panel INVOICES-->	
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->

<?php
include 'footer.php';
?>

<script type="text/javascript">

ajax_show_invoices();

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function ajax_show_invoices(){	
var quotation_number = getUrlParameter('quotation_number');
var formData = "quotation_number="+quotation_number;

//Show All Invoices
	$.ajax({
			  type: 'POST',
			  url: 'php-show_invoices.php',
			  data: formData,
			  success:function(data){
				if (data == false){
					//No results
					$("#tblListInvoice tbody").empty();
				}else{
					// successful request; do something with the data
					$("#tblListInvoice tbody").empty();
					$("#tblListInvoice tbody").append(data);
				}
				
			  },
			  error:function(){
				// failed request; give feedback to user
				alert("Request Failed");
			  }
	});
}	

</script>

<?php

function get_Quotation_details($quotation_number){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	require_once(PHP_CLASS_PATH . "/Status.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
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
			$status_id = $field['status_id'];
			$value = $field['value'];

			//Format customer_id pattern 001
			$customer = new Customer();
			$customer_id_format = $customer-> format_customer_id($customer_id);
			
			//Format quotation pattern
			$quotation_id_frmt = $quotation -> format_quotation($service_type, $quotation_number, $customer_id_format);

			//Get status_id name
			$status = new Status();
			$status_name = $status -> getStatus_Name($status_id); 

			//Choose Button Color according the status
			$class_button = $status -> getColor_Status($status_id);
			
			//Format currency
			$frmt = new Format();
			$format_value = $frmt ->format_currency($value);
			
			echo '<tr>';
			echo '<td>ID:</td>';
			echo '<td>' .$quotation_id_frmt.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Status:</td>';
			
			// Class according the Status Color
			echo '<td><button class="btn btn-'.$class_button.' btn-xs" data-toggle="modal" data-target="#myModal">'.$status_name.'</td>';

			echo '</tr>';
		
			echo '<tr>';
			echo '<td>Project Date:</td>';
			echo '<td>' .$project_date.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Project Name:</td>';
			echo '<td>' .$project_name.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Project Description:</td>';
			echo '<td>' .$project_description.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Value:</td>';
			echo '<td>' .$format_value .'&nbsp; &nbsp;';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Created Date:</td>';
			echo '<td>' .$created_date.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Created By:</td>';
			echo '<td>' .$created_by.'</td>';
			echo '</tr>';
			
			
		}
	}else{
		header("Location: error/errorPage.html");
	}
	
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
		echo '<td>'.$customer_id_format.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td> Name:</td>';
		echo '<td>' .$name.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Company:</td>';
		echo '<td>' .$company.'</td>';
		echo '</tr>';
		/*
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
		*/

	}
}else{
	header("Location: error/errorPage.html");
}
	
}

function getAll_Files($quotation_number){
	
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation_Files.inc");


	$file = new Quotation_Files();	
	$json_files = $file -> get_Files_by_quotation_number($quotation_number);
	$json = json_decode($json_files, true); // decode the JSON into an associative array
	if ($json_files){
		foreach ($json["Result"] as $field) {
			$file_name = $field['file_name'];
			$url = 'uploads/'.$quotation_number.'/'.$file_name;
			echo '<i class="fa fa-file" > </i>';
			echo '&nbsp;&nbsp;<a href="'.$url.'" target="_blank">'.$file_name;
			echo '</a><br>';
		}
	}
	
}

function showAll_Revisions($quotation_number){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Revision.inc");
	
	$revision = new Revision();
	$json_revision = $revision -> get_AllRevisions($quotation_number);
	$json = json_decode($json_revision, true); // decode the JSON into an associative array
	
	if ($json_revision){
		foreach ($json["Result"] as $field) {	
			$revision_letter = $field['revision_letter'];
			$revision_name = $field['revision_name'];
			$revision_date = $field['revision_date'];
			$revision_id = $field['revision_id'];
			$status_id = $field['status_id'];
			
			//Get Status Name
			$status = new Status();
			$status_name = $status -> getStatus_Name($status_id);
			
			echo '<tr>';
			echo '<td>' . $revision_letter . '</td>';
			echo '<td>' . $status_name . '</td>';
			echo '<td>' . $revision_name . '</td>';
			echo '<td>' . $revision_date . '</td>';
			echo '<td> <a href="view_revision.php?revision_id='.$revision_id.'" >View</a></td>';
			echo '</tr>';
		}
	}
	
	
}

?>


