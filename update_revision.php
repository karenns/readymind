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
if (isset($_GET['revision_id'])  ){
	$revision_id = $_GET['revision_id'];
	
}else{
	header("Location: error/pageNotFound.html");
}
?>
<?php
require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Revision.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	
	$revision = new Revision();
	$json_revision = $revision -> get_Revision_details($revision_id);
	$json = json_decode($json_revision, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* echo '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_revision){
		foreach ($json["Result"] as $field) {	
		//$quotation_number, $country, $service_type, $customer_id, $created_by, $project_name, $project_description
			$quotation_number = $field['quotation_number'];

			$revision_name = $field['revision_name'];	
			$revision_description = $field['revision_description'];	
			$created_date = $field['created_date'];
			$created_by = $field['created_by'];
			$revision_date = $field['revision_date']; 
			$revision_letter = $field['revision_letter']; 
		}
	}
	
	$quotation = new Quotation();
	//Format quotation pattern
	$quotation_id_frmt = $quotation -> format_quotation2($quotation_number);
	
	//Format quotation plus letter
	$quotation_id_frmt_revision = $quotation_id_frmt . $revision_letter;

?>

<?php
include 'header.php';
create_header('quotation');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Edit Revision</h2></center>      
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
									<input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $quotation_id_frmt_revision;?>" disabled />
                                </div>
								<div class="form-group">
									<label>Revision Date:</label>
									<input class="form-control" type="date" name="revision_date" maxlength="10" value="<?php echo $revision_date; ?>"/>
                                </div>
								<div class="form-group">
									<label>Revision Name:</label>
									<input class="form-control" type="text" name="revision_name" maxlength="100" required="required" value="<?php echo $revision_name; ?>"/>
                                </div>
								<div class="form-group">
									<label>Revision Description:</label>
									<textarea class="form-control" rows="20" name="revision_description" maxlength="5000" maxlength="500"><?php echo $revision_description; ?></textarea>
									
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
							
								<!--<a href="view_revision.php?revision_id=<?php echo $revision_id;?>" role="button" class="btn btn-default">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
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
	require_once(PHP_CLASS_PATH . "/Revision.inc");	
		$revision_name = $_POST['revision_name'];
		$revision_description = $_POST['revision_description'];
		$revision_date = $_POST['revision_date'];
		
		$updated_by = $user_id;

	$revision = new Revision();	
	$result = $revision -> update_Revision($revision_id, $revision_name, $revision_date, $revision_description, $updated_by);

	if ($result == true){
		showMessage();
		redirect('view_revision.php?revision_id='.$revision_id);
	}else{
		redirect('error/errorPage.html');
	}
		
}


?>

<?php 
function showMessage(){

      echo '  <script>
				alert("Revision Updated");
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
