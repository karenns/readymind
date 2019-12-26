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
<?php
if (isset($_GET['quotation_number']) ){
	$quotation_number = $_GET['quotation_number'];
	//session_start();
	$_SESSION['quotation_number'] = $quotation_number;
	
}else{
	header("Location: error/pageNotFound.html");
}
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Invoice</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />
				
				<!-- Quotation Info -->
				<div class="panel panel-default">
				<!--<div class="panel-heading">
                     Quotation
					</div>-->
					<div class="panel-body">
					<a href="view_quotation.php?quotation_number=<?php echo $quotation_number; ?>" class="btn btn-default pull-right">
						<i class="fa fa-search "></i>View
					</a>
					
					<center>
					<table id="tblQuotation" style="width:90%;">
					<tbody>
					
					</tbody>
					</table>
					</center>					
					</div>
					<!-- <div class="panel-footer">
                            Panel Footer
                    </div>-->
				</div>
				<!-- /. Quotation Info-->
				
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
//NOT working
//$(document).ready(function() {
	ajax_show_quotation()
	ajax_show_invoices()
//});
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
};

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

function ajax_show_quotation(){	
var quotation_number = getUrlParameter('quotation_number');
var formData = "quotation_number="+quotation_number;

//Show All Invoices
	$.ajax({
			  type: 'POST',
			  url: 'php-quotation_details.php',
			  data: formData,
			  success:function(data){
				if (data == false){
					//No results
					$("#tblQuotation tbody").empty();
				}else{
					// successful request; do something with the data
					$("#tblQuotation tbody").empty();
					$("#tblQuotation tbody").append(data);
				}
				
			  },
			  error:function(){
				// failed request; give feedback to user
				alert("Request Failed");
			  }
	});
}	
</script>
