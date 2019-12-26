<?php 
session_start();
if($_SESSION['user']){
		
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];

require_once("config/config.php");

require_once(PHP_CLASS_PATH . "/Customer.inc");
require_once(PHP_CLASS_PATH . "/Quotation.inc");
require_once(PHP_CLASS_PATH . "/Quotation_Files.inc");
require_once(PHP_CLASS_PATH . "/Revision_Files.inc");
require_once(PHP_CLASS_PATH . "/Status.inc");
require_once(PHP_CLASS_PATH . "/Revision.inc");

$customer = new Customer();
$count_customers = $customer -> count_Customer();


$quotation = new Quotation();
$count_quotations = $quotation -> count_Quotation();


$file_quotation = new Quotation_Files();
$count_files_quotation = $file_quotation -> count_Files();

$file_revision = new Revision_Files();
$count_files_revision = $file_revision -> count_Files();
$count_files = $count_files_quotation + $count_files_revision;

$revision = new Revision();
$count_revisions = $revision -> count_Revision();


$status = new Status();
$name_status1 = $status -> getStatus_Name(1);
$name_status2 = $status -> getStatus_Name(2);
$name_status3 = $status -> getStatus_Name(3);
$name_status4 = $status -> getStatus_Name(4);

$color_status1 = $status -> getColor_Status(1);
$color_status2 = $status -> getColor_Status(2);
$color_status3 = $status -> getColor_Status(3);
$color_status4 = $status -> getColor_Status(4);

//Statistics Status
$count_total = $count_quotations + $count_revisions;

$count_quotation_status1 = $quotation ->count_status(1);
$count_quotation_status2 = $quotation ->count_status(2);
$count_quotation_status3 = $quotation ->count_status(3);
$count_quotation_status4 = $quotation ->count_status(4);

$count_revision_status1 = $revision ->count_status(1);
$count_revision_status2 = $revision ->count_status(2);
$count_revision_status3 = $revision ->count_status(3);
$count_revision_status4 = $revision ->count_status(4);

$count_total_status1 = $count_quotation_status1 + $count_revision_status1;
$count_total_status2 = $count_quotation_status2 + $count_revision_status2;
$count_total_status3 = $count_quotation_status3 + $count_revision_status3;
$count_total_status4 = $count_quotation_status4 + $count_revision_status4;

if ($count_total !== 0){
	$perc_status1 = round(floatval($count_total_status1/$count_total)*100);
	$perc_status2 = round(floatval($count_total_status2/$count_total)*100);
	$perc_status3 = round(floatval($count_total_status3/$count_total)*100);
	$perc_status4 = round(floatval($count_total_status4/$count_total)*100);
}

?>

<?php
include 'header.php';
create_header('home');

?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Dashboard</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />				
				
				<a href="customer.php">
				<div class="col-md-3 col-sm-12 col-xs-12">                       
                    <div class="panel panel-primary text-center no-boder bg-color-blue">
                        <div class="panel-body">
                            <i class="fa fa-users fa-5x"></i>
                            <h3><?php echo $count_customers; ?> </h3>
                        </div>
                        <div class="panel-footer back-footer-blue">
                           Customers        
                        </div>
                    </div>
				</div>
				</a>
				
				<a href="quotation.php" >
				<div class="col-md-3 col-sm-12 col-xs-12">  
					<div class="panel panel-primary text-center no-boder bg-color-green">
                        <div class="panel-body">
                            <i class="fa fa-book fa-5x"></i>
                            <h3><?php echo $count_quotations; ?> </h3>
                        </div>
                        <div class="panel-footer back-footer-green">
                           Quotations        
                        </div>
                    </div>
				</div>
				</a>
				
				<!--<a href="quotation.php" >-->
				<div class="col-md-3 col-sm-12 col-xs-12">  
					<div class="panel panel-primary text-center no-boder bg-color-purple">
                        <div class="panel-body">
                            <i class="fa fa-pencil fa-5x"></i>
                            <h3><?php echo $count_revisions;?> </h3>
                        </div>
                        <div class="panel-footer back-footer-purple">
                           Revisions        
                        </div>
                    </div>
				</div>
				<!--</a>-->
				
				<div class="col-md-3 col-sm-12 col-xs-12">  
					<div class="panel panel-primary text-center no-boder bg-color-brown">
                        <div class="panel-body">
                            <i class="fa fa-file fa-5x"></i>
                            <h3><?php echo $count_files; ?> </h3>
                        </div>
                        <div class="panel-footer back-footer-brown">
                           Uploaded Files        
                        </div>
                    </div>
				</div>

				<!-- QUOTATION PROGRESS BARS -->
				
						
				            <div class="col-md-6">
							<br><br>
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Quotation & Revision's Status 
                        </div>
                       
                        <div class="panel-body">
						
						<?php echo $name_status1.'  ('.$count_total_status1.')'; ?><?php echo ' - '.$perc_status1.'%'; ?>
                        <div class="progress progress-striped">
						
						  <div class="progress-bar progress-bar-<?php echo $color_status1; ?>" role="progressbar" aria-valuenow="<?php echo $perc_status1;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $perc_status1;?>%">
						  </div>
						</div>
						<?php echo $name_status2.'  ('.$count_total_status2.')'; ?><?php echo ' - '.$perc_status2.'%'; ?>
						<div class="progress progress-striped">
						  <div class="progress-bar progress-bar-<?php echo $color_status2; ?>" role="progressbar" aria-valuenow="<?php echo $perc_status2;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $perc_status2;?>%">
						  </div>
						</div>
						<?php echo $name_status3.'  ('.$count_total_status3.')'; ?><?php echo ' - '.$perc_status3.'%'; ?>
						<div class="progress progress-striped">
						  <div class="progress-bar progress-bar-<?php echo $color_status3; ?>" role="progressbar" aria-valuenow="<?php echo $perc_status3;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $perc_status3;?>%">
						  </div>
						</div>
						<?php echo $name_status4.'  ('.$count_total_status4.')'; ?><?php echo ' - '.$perc_status4.'%'; ?>
						<div class="progress progress-striped">
						  <div class="progress-bar progress-bar-<?php echo $color_status4; ?>" role="progressbar" aria-valuenow="<?php echo $perc_status4;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $perc_status4;?>%">
							<span class="sr-only">80% Complete</span>
						  </div>
						</div>
                            </div>
                            </div>
                    </div>
				
				<!-- /. QUOTATION PROGRESS BARS -->
				
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
