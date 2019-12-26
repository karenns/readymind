<?php
/* AJAX */

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$quotation_number = $_POST['quotation_number'];
	
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	require_once(PHP_CLASS_PATH . "/Revision.inc");
	require_once(PHP_CLASS_PATH . "/Status.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
	$quotation = new Quotation();
	$json_quotation = $quotation -> get_Quotation_details($quotation_number);
	$json = json_decode($json_quotation, true); // decode the JSON into an associative array

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
			
			echo '<tr>';
			echo '<td>Project Date:</td>';
			echo '<td>' .$project_date.'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Project Name:</td>';
			echo '<td>' .$project_name.'</td>';
			echo '</tr>';

		}
	}else{
		echo false;
	}
	
}

?>