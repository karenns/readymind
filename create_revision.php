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

if (isset($_GET['quotation_number'])){
	$quotation_number = $_GET['quotation_number'];

}else{
	header("Location: error/pageNotFound.html");
}
	
?>

<?php
require_once(PHP_CLASS_PATH . "/Quotation.inc");

	$quotation = new Quotation();
	$status_id = $quotation -> get_StatusID($quotation_number);
	
	if (($status_id == 1)||($status_id == 2)){
		showMessage('Cannot create a Revision when status is 1 or 2');
		redirect('view_quotation.php?quotation_number='.$quotation_number);
	}
	
	
?>


<?php

require_once(PHP_CLASS_PATH . "/Customer.inc");
require_once(PHP_CLASS_PATH . "/Quotation.inc");

	$customer = new Customer();
	$quotation = new Quotation();
	$json_customer = $quotation -> get_Quotation_details($quotation_number);
	
	$json = json_decode($json_customer, true); // decode the JSON into an associative array
	
	if ($json_customer){
		foreach ($json["Result"] as $field) {	
			$customer_id = $field['customer_id'];
			$service_type = $field['service_type'];
			$project_name = $field['project_name'];
			
			$customer_id_format = $customer -> format_customer_id($customer_id);
		    $quotation_frmt = $quotation -> format_quotation($service_type, $quotation_number, $customer_id_format);
			
		}
	}else{
		redirect('error/errorPage.html');
	}	

?>

<?php
require_once(PHP_CLASS_PATH . "/Revision.inc");

	$revision = new Revision();
	
	$revision_letter = $revision -> get_LastrevisionLetter($quotation_number);

	$next_revision_letter = $revision -> get_Next_RevisionLetter($revision_letter);
	//echo 'Next Revision letter: ' .$next_revision_letter;

?>

<?php
include 'header.php';
create_header('quotation');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Create Revision</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<div class="row">
                <div class="col-md-12">
				
					<!-- Panel Info -->
					<div class="panel panel-default">
					<div class="panel-heading">
                     Quotation
					</div>
						<div class="panel-body">
						<!--<strong>Customer</strong><br><br>-->
						<table style="width:90%;">
							<tr>
							<td>ID:</td>
							<td><?php echo $quotation_frmt; ?></td>
							</tr>
							<tr>
							<td> Project:</td>
							<td><?php echo $project_name; ?></td>
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
									<label>Revision Letter:</label>
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $next_revision_letter;?>" disabled />
								</div>
								<?php require_once(PHP_CLASS_PATH . "/Format.inc"); $format = new Format(); $today=$format->format_date(); ?>
								<div class="form-group">
									<label>Revision Date:</label>
									<input class="form-control" type="date" name="revision_date" maxlength="10" value="<?php echo $today; ?>"/>
                                </div>
								<div class="form-group">
									<label>Revision Name:</label>
									<input class="form-control" type="text" name="revision_name" maxlength="100" required="required"/>
                                </div>
								<div class="form-group">
									<label>Revision Description:</label>
									<textarea class="form-control" rows="20" name="revision_description" maxlength="5000"></textarea>
									
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
	$revision_name = $_POST['revision_name'];
	$revision_description = $_POST['revision_description'];
	$revision_date = $_POST['revision_date'];
	
	$created_by = $user_id;
	$revision_letter = $next_revision_letter;
	
	$status_id = 1;
	
	$result = $revision->add_Revision($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by);

	if ($result == true){
		//echo 'Result: OK';
		/*$quotation_number = $quote-> get_Quotation_id($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date);
		
		$customer = new Customer();
		$customer_id_frmt = $customer -> format_customer_id($customer_id);
		$quotation_frmt = $quote -> format_quotation($service_type, $quotation_number, $customer_id_frmt, $country);
		*/
		showMessage("Revision created.");
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
