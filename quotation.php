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
create_header('quotation');
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Status.inc");
$status = new Status();

$status_name1 = $status -> getStatus_Name(1);
$status_name2 = $status -> getStatus_Name(2);
$status_name3 = $status -> getStatus_Name(3);
$status_name4 = $status -> getStatus_Name(4);
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
												<input type="hidden" name="quotation_number" value="" />
												<label>Quotation ID:</label>
												<div id="quotation_id" ></div> 
										
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
                     <center><h2>Quotation</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<!-- Search -->	
				<form id="form-search" role="form" method="get" action="javascript:ajax_search_Quotation();">
				<div class="form-group input-group">
					<input id="searchValue" type="text" name="value" class="form-control">
                    <span class="input-group-btn">
                        <button type="submit" name="search" class="btn btn-default"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>	
				</form>
				<!-- /. Search -->	
				
				<!-- Advanced Search -->
				<center>
					<a href="#filter-panel" data-toggle="collapse" data-target="#filter-panel">Advanced Search</a>
					<span class="glyphicon glyphicon-cog"></span> 
				</center>
	
				<div class="row">
					<div class="col-md-12 offset-md-3">
						<div id="filter-panel" class="collapse filter-panel">
							<div class="panel panel-default">
								<!--<div class="panel-heading">Advanced Search
								</div>-->
								<div class="panel-body">
									<center>
									<form class="form-inline" role="form" method="post" action="javascript:ajax_advancedSearch();"> 
										<label>Status:</label>
										<select id="status_id" class="form-control" name="status_id">
											<option selected value="0">Select</option>
											<option value="1"><?php echo strtoupper($status_name1); ?></option>
											<option value="2"><?php echo strtoupper($status_name2); ?></option>
											<option value="3"><?php echo strtoupper($status_name3); ?></option>
											<option value="4"><?php echo strtoupper($status_name4); ?></option>		
										</select>
										&nbsp;										
										<div class="form-group">
											<label>Value ($):</label>
											<input id="min_value" class="form-control" type="number" step="any" name="min_value" maxlength="10" placeholder="min" style = "width:90px;"/>
											<input id="max_value" class="form-control" type="number" step="any" name="max_value" maxlength="10" placeholder="max" style = "width:90px;"/>
										</div>
										&nbsp;&nbsp;	
										<button type="submit" name="adv_search" class="btn btn-primary"><span class="glyphicon glyphicon-record"></span> Search</button>
										<button id="reset-adv_search" type="button" name="clean_search" class="btn btn-default pull-right"><span class="glyphicon glyphicon-trash"></span></button>
									</form>
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<!-- /. Advanced Search -->	
				
				<!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                             Customers
                        </div>-->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tblListQuotation" class="table table-striped table-bordered table-hover" id="dataTables-example" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>Quotation</th>
											<th>Status</th>
                                            <th>Project Name</th>
											<th>Project Date</th>
											<th>Company</th>
											<th>Value</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>	
									
                                   </tbody>
                                </table>
                            </div>
                         <!--<p>Total Row(s): </p>  -->     
                        </div>
                    </div>
                <!--End Advanced Tables --> 
					</br>
					</br>
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
	ajax_showAll_Quotations()
//});

$('#myModal').on('show.bs.modal', function(e) {
	var quotation_number = $(e.relatedTarget).data('quotation-number');
	var quotation_id = $(e.relatedTarget).data('quotation-id');
	$(e.currentTarget).find('input[name="quotation_number"]').val(quotation_number);
	$('#quotation_id').text(quotation_id);
}); 

$('a[href="#filter-panel"]').click(function(){
	//alert('Sign new href executed.'); 
	$('#form-search').toggle();
	
	//Clean all form fields
	$('#status_id option:eq(0)').prop('selected', true);
	$('#min_value').val('');
	$('#max_value').val('');
	ajax_showAll_Quotations();
});

$('#reset-adv_search').click(function() {
	$('#status_id option:eq(0)').prop('selected', true);
	$('#min_value').val('');
	$('#max_value').val('');
	$('#form-search input').val('');
	ajax_showAll_Quotations();
});

$('#form-search input').blur(function(){
    if( !$(this).val() ) {
		//If it there is no value
		ajax_showAll_Quotations();
		 
    }
});

function ajax_showAll_Quotations(){	
//Show All Quotation
	$.ajax({
			  type: 'POST',
			  url: 'php-showAll_Quotations.php',
			  success:function(data){
				if (data == false){
					//No results
					$("#tblListQuotation tbody").empty();
				}else{
					// successful request; do something with the data
					$("#tblListQuotation tbody").empty();
					$("#tblListQuotation tbody").append(data);
				}
				
			  },
			  error:function(){
				// failed request; give feedback to user
				alert("Request Failed");
				}
	});
}	

function ajax_advancedSearch(){
	var status_id = $('#status_id').val();
	var min_value = $('#min_value').val();
	var max_value = $('#max_value').val();

	if ((status_id == 0) && (min_value == "") && (max_value == "") ){
		//No value. Don't do anything
		
	}else{
		var formData = "status_id="+status_id+"&min_value="+min_value+"&max_value="+max_value;
		$.ajax({
		  type: 'POST',
		  url: 'php-quotation_advanced_search.php',
		  data: formData,
		  success:function(data){
			if (data == false){
				//No results
				$("#tblListQuotation tbody").empty();
			}else{
				// successful request; do something with the data
				$("#tblListQuotation tbody").empty();
				$("#tblListQuotation tbody").append(data);
			}
			
		  },
		  error:function(){
			// failed request; give feedback to user
			alert("Request Failed");
			}
		});
	}
}

function ajax_search_Quotation(){
	var searchValue = $('#searchValue').val();

	if (searchValue == ""){
		//No value. Don't do anything
		
	}else{
		var formData = "searchValue="+searchValue;
		$.ajax({
		  type: 'GET',
		  url: 'php-quotation_search.php',
		  data: formData,
		  success:function(data){
			if (data == false){
				//No results
				$("#tblListQuotation tbody").empty();
				
			}else{
				// successful request; do something with the data
				$("#tblListQuotation tbody").empty();
				$("#tblListQuotation tbody").append(data);
			}
			
		  },
		  error:function(){
			// failed request; give feedback to user
			alert("Request Failed");
			}
		});
	}
}




</script>


