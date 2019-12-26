<?php
session_start();
if($_SESSION['user']){
	$user_id = $_SESSION['user'];	
}
else{
	header("location:index.php");
}

?>

<?php
if (isset($_GET['revision_id'])){
	$revision_id = $_GET['revision_id'];
	//session_start();
	//$_SESSION['quotation_number'] = $quotation_number;
	
}else{
	header("Location: error/pageNotFound.html");
}
?>

<?php
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Revision.inc");

$revision = new Revision();
$quotation_number  = $revision -> get_quotation_Number($revision_id);
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
											<form role="form" action="update_status_revision.php" method="get">	
												<input type="hidden" name="revision_id" value="<?php echo $revision_id; ?>" />
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
                     <center><h2>Revision Details</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<a href="view_quotation.php?quotation_number=<?php echo $quotation_number; ?>" role="button" class="btn-md btn-default"><i class="fa fa-long-arrow-left"></i>&nbsp;Back</a>
				<br>
				<!-- Panel Revision Info -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Quotation
					</div>-->
					<div class="panel-body">

					<a href="update_revision.php?revision_id=<?php echo $revision_id; ?>" class="btn btn-primary pull-right">
						<i class="fa fa-edit "></i>Edit
					</a>

					<center>
					<table style="width:90%;">
						<?php get_Revision_details($revision_id); ?>
					</table>
					</center>					
					</div>
					<!-- <div class="panel-footer">
                            Panel Footer
                    </div>-->
				</div>
				<!-- /. Panel Revision Info-->
				
				<!-- Panel Quotation Info -->
				<div class="panel panel-default">
				<div class="panel-heading">
                     Quotation Information
					</div>
					<div class="panel-body">
					<center>
					<table style="width:100%;">
						<?php get_Quotation_details($quotation_number); ?>
					</table>
					</center>					
					</div>
					<!-- <div class="panel-footer">
                            Panel Footer
                    </div>-->
				</div>
				<!-- /. Panel Quotation Info-->
				
				<!-- Panel Files -->
				<div class="panel panel-default">
					<div class="panel-heading">
                     Attached Files
					</div>
					<div class="panel-body">
					<!--<i class="fa fa-file "></i>&nbsp;&nbsp;<a href="#">quotation_number001_Leonard-20150901.pdf</a>
					<br/> -->
					<?php getAll_Files($quotation_number,$revision_id);?>
					<br/>
					<br/>
					</div>
				</div>
				<!-- /. Panel Files-->	
				<!--
				<center>
					<a href="#" class="btn btn-info btn-md"><i class="fa fa-file "></i>&nbsp;Upload File</a>
				</center>
				-->
					<form role="form" action="upload_revision_file.php" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>Upload file</label>
									<input type="hidden" name="revision_id" value="<?php echo $revision_id; ?>" />
									<input type="hidden" name="quotation_number" value="<?php echo $quotation_number; ?>" />
								    <input type="file" name="fileToUpload" id="fileToUpload"><br>
									<input type="submit" name="submit" value="Upload File" />
							</div>
						</form>
				
					
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

function get_Quotation_details($quotation_number){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	require_once(PHP_CLASS_PATH . "/Status.inc");
	
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
			$project_name = $field['project_name'];	

			//Format customer_id pattern 001
			$customer = new Customer();
			$customer_id_format = $customer-> format_customer_id($customer_id);
			
			//Format quotation pattern
			$quotation_id_frmt = $quotation -> format_quotation($service_type, $quotation_number, $customer_id_format);
			
			echo '<tr>';
			echo '<td>Quotation ID:</td>';
			echo '<td>' .$quotation_id_frmt.'</td>';
			echo '</tr>';

			echo '<td>Project Name:</td>';
			echo '<td>' .$project_name.'</td>';
			echo '</tr>';
			
		}
	}else{
		header("Location: error/errorPage.html");
	}
	
}

function get_Revision_details($revision_id){
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	require_once(PHP_CLASS_PATH . "/Status.inc");
	
	$revision = new Revision();
	$json_quotation = $revision -> get_Revision_details($revision_id);
	$json = json_decode($json_quotation, true); // decode the JSON into an associative array

	if ($json_quotation){
		foreach ($json["Result"] as $field) {	
			$revision_letter = $field['revision_letter'];
			$revision_name = $field['revision_name'];
			$revision_description = $field['revision_description'];
			$revision_date = $field['revision_date'];	
			$created_date = $field['created_date'];
			$created_by = $field['created_by'];
			$status_id = $field['status_id'];

			//GEt status name
			$status = new Status();
			$status_name = $status -> getStatus_Name($status_id);
			
			//Choose Button Color according the status
			$class_button = $status -> getColor_Status($status_id);
			
			echo '<tr>';
			echo '<td>Status:</td>';
			
			// Class according the Status Color
			echo '<td><button class="btn btn-'.$class_button.' btn-xs" data-toggle="modal" data-target="#myModal">'.$status_name.'</td>';

			echo '</tr>';
		
			echo '<tr>';
			echo '<td>Revision Date:</td>';
			echo '<td>' .$revision_date.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Revision Name:</td>';
			echo '<td>' .$revision_name.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Revision Description:</td>';
			echo '<td>' .$revision_description.'</td>';
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

function getAll_Files($quotation_number,$revision_id){
	
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Revision_Files.inc");
	require_once(PHP_CLASS_PATH . "/Revision.inc");

	$file = new Revision_Files();	
	$json_files = $file -> get_Files_by_revision_id($revision_id);
	$json = json_decode($json_files, true); // decode the JSON into an associative array
	if ($json_files){
		foreach ($json["Result"] as $field) {
			$file_name = $field['file_name'];
			
			//Get the revision letter
			$rev = new Revision();
			$revision_letter = $rev -> get_revisionLetter($revision_id);		
			
			$url = 'uploads/'.$quotation_number.'/'.$revision_letter.'/'.$file_name;
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
			
			echo '<tr>';
			echo '<td>' . $revision_letter . '</td>';
			echo '<td>' . $revision_name . '</td>';
			echo '<td>' . $revision_date . '</td>';
			echo '<td> <a href="view_revision.php?quotation_number='.$quotation_number.'&revision_letter='.$revision_letter.'" >View</a></td>';
			echo '</tr>';
		}
	}
	
	
}

?>
