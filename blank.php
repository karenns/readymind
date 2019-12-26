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
include 'header.php';
create_header('blank');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Title</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
   
			</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->

<?php
include 'footer.php';
?>
