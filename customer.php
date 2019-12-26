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
include 'header.php';
create_header('customer');
?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <center><h2>Customer</h2></center>      
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr />	
				<center>
						<a href="create_customer.php" class="btn btn-danger btn-md">
						<i class="fa fa-user"></i>&nbsp;&nbsp;NEW CUSTOMER</a>
				</center><br><br>
				<!-- Search -->	
				<form id="form-search" role="form" method="get" action="javascript:ajax_search_Customer();">
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
									<form class="form-inline" role="form" method="get" action="javascript:ajax_advancedSearch();"> 
										<label>Country:</label>
										<select id="customer_country" class="form-control" name="customer_country">
											<option selected value="0">Select</option>
											<option value="US">US</option>
											<option value="SG">SG</option>
										</select>
										&nbsp;&nbsp;&nbsp;
										<button type="submit" name="adv_search" class="btn btn-primary"><span class="glyphicon glyphicon-record"></span> Search</button>									
										<button id="reset-adv_search" type="button" name="reset-adv_search" class="btn btn-default pull-right"><span class="glyphicon glyphicon-trash"></span></button>
									
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
                                <table id="tblListCustomer" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Country</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Company</th>
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

<?php

function showAll_Customers(){
/*
JSON 
http://stackoverflow.com/questions/19758954/get-data-from-json-file-with-php

*/
	require_once(PHP_CLASS_PATH . "/Customer.inc");

	$customer = new Customer();	
	$json_customer = $customer -> get_All_Customers();

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
			
		    $customer_id_format = $customer -> format_customer_id($customer_id);
		
			//echo '<tr>';
			echo '<tr>';
			echo '<td>' . $country . '</td>';
			echo '<td>' . $customer_id_format . '</td>';
			echo '<td>' . $name . '</td>';
			echo '<td>' . $company . '</td>';
			echo '<td> <a href="view_customer.php?customer_id='.$customer_id.'" >View</a></td>';
			echo '</tr>';

		}
	}

}

function search_Customers($value){
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	$customer = new Customer();
	$json_customer_id = $customer -> search_Customer($value);

	$json = json_decode($json_customer_id, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* echo '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_customer_id){
		foreach ($json["Result"] as $field) {
			//$customer_id, $name, $company, $email, $country, $city, $phone, $created_date, $created_by	
			$country = $field['country'];
			$customer_id = $field['customer_id'];
			$name = $field['name'];
			$company = $field['company'];
			
			//$format = new Format();
		    $customer_id_format = $customer -> format_customer_id($customer_id);
			
			echo '<tr>';
			echo '<td>' . $country . '</td>';
			echo '<td>' . $customer_id_format . '</td>';
			echo '<td>' . $name . '</td>';
			echo '<td>' . $company . '</td>';
			echo '<td> <a href="view_customer.php?customer_id='.$customer_id.'" >View</a></td>';
			echo '</tr>';
		}
	}
		
}

function search_Customers_byCountry($country){
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	$customer = new Customer();
	$json_customers = $customer -> search_Customers_byCountry($country);

	$json = json_decode($json_customers, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* echo '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_customers){
		foreach ($json["Result"] as $field) {
			//$customer_id, $name, $company, $email, $country, $city, $phone, $created_date, $created_by	
			$country = $field['country'];
			$customer_id = $field['customer_id'];
			$name = $field['name'];
			$company = $field['company'];
			
			//$format = new Format();
		    $customer_id_format = $customer -> format_customer_id($customer_id);
			
			echo '<tr>';
			echo '<td>' . $country . '</td>';
			echo '<td>' . $customer_id_format . '</td>';
			echo '<td>' . $name . '</td>';
			echo '<td>' . $company . '</td>';
			echo '<td> <a href="view_customer.php?customer_id='.$customer_id.'" >View</a></td>';
			echo '</tr>';
		}
	}
		
}

?>
<script type="text/javascript">
//NOT working
//$(document).ready(function() {
	ajax_showAll_Customers();
//});


$('a[href="#filter-panel"]').click(function(){
	//alert('Sign new href executed.'); 
	$('#form-search').toggle();
	
	//Clean all form fields
	$('#customer_country option:eq(0)').prop('selected', true);
	$('#form-search input').val('');
	ajax_showAll_Customers();
		
});

$('#reset-adv_search').click(function() {
	$('#customer_country option:eq(0)').prop('selected', true);
	ajax_showAll_Customers();
});

$('#form-search input').blur(function(){
    if( !$(this).val() ) {
		//If it there is no value
		ajax_showAll_Customers();		 
    }
});

function ajax_showAll_Customers(){	
//Show All Quotation
	$.ajax({
			  type: 'POST',
			  url: 'php-showAll_Customers.php',
			  success:function(data){
				if (data == false){
					//No results
					$("#tblListCustomer tbody").empty();
				}else{
					// successful request; do something with the data
					$("#tblListCustomer tbody").empty();
					$("#tblListCustomer tbody").append(data);
				}
				
			  },
			  error:function(){
				// failed request; give feedback to user
				alert("Request Failed");
				}
	});
}	

function ajax_search_Customer(){
var searchValue = $('#searchValue').val();

	if (searchValue == ""){
		//No value. Don't do anything
		
	}else{
		var formData = "searchValue="+searchValue;
		$.ajax({
		  type: 'GET',
		  url: 'php-customer_search.php',
		  data: formData,
		  success:function(data){
			if (data == false){
				//No results
				$("#tblListCustomer tbody").empty();
				
			}else{
				// successful request; do something with the data
				$("#tblListCustomer tbody").empty();
				$("#tblListCustomer tbody").append(data);
			}
			
		  },
		  error:function(){
			// failed request; give feedback to user
			alert("Request Failed");
			}
		});
	}
	
}
		
function ajax_advancedSearch(){
	var country = $('#customer_country').val();
	
	if (country == ""){
		//No value. Don't do anything
		
	}else{
		var formData = "country="+country;
		$.ajax({
		  type: 'POST',
		  url: 'php-customer_advanced_search.php',
		  data: formData,
		  success:function(data){
			if (data == false){
				//No results
				$("#tblListCustomer tbody").empty();
			}else{
				// successful request; do something with the data
				$("#tblListCustomer tbody").empty();
				$("#tblListCustomer tbody").append(data);
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

