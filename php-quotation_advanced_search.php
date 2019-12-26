<?php
/* AJAX */

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$status_id = $_POST['status_id'];
	$min_value = $_POST['min_value'];
	$max_value = $_POST['max_value'];
	
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Quotation.inc");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	require_once(PHP_CLASS_PATH . "/Revision.inc");
	require_once(PHP_CLASS_PATH . "/Status.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
	$quotation = new Quotation();
	$json_quotation = $quotation -> advanced_search_Quotation($status_id,$min_value,$max_value);
	$json = json_decode($json_quotation, true); // decode the JSON into an associative array

	if ($json_quotation){
		foreach ($json["Result"] as $field) {	
			$quotation_number = $field['quotation_number'];
			$country = $field['country'];
			$service_type = $field['service_type'];
			$project_name = $field['project_name'];	
			$customer_id = $field['customer_id'];	
			$project_date = $field['project_date'];
			$status_id = $field['status_id'];
			$value = $field['value'];
			
			//Format customer_id pattern 001
			$customer = new Customer();
			$customer_id_format = $customer-> format_customer_id($customer_id);

		    $quotation_id = $quotation -> format_quotation($service_type, $quotation_number, $customer_id_format);	
			$service_type_name = $quotation->get_ServiceType_name($service_type);
			
			//Get last revision letter
			$revision = new Revision();
			$last_revision_letter = $revision-> get_revisionLetter($quotation_number);
			$quotation_id .= $last_revision_letter;

			//Get status name
			$status = new Status();
			$status_name = $status -> getStatus_Name($status_id);
			
			//Choose Button Color according the status
			$class_button = $status -> getColor_Status($status_id);
			
			//Format currency
			$frmt = new Format();
			$format_value = $frmt ->format_currency($value);	
			
			$html = '';
			$html .= '<tr>';
			$html .= '<td>' . $quotation_id . '</td>';
			//$html .= '<td>' . $status_name . '</td>';			
			$html .= '<td><button class="btn btn-'.$class_button.' btn-xs" data-toggle="modal" data-target="#myModal" data-quotation-number="' .$quotation_number.'" data-quotation-id="' .$quotation_id.'">'.$status_name.'</td>';
			$html .= '<td>' . $service_type_name . '</td>';
			$html .= '<td>' . $project_name . '</td>';
			$html .= '<td>' . $project_date . '</td>';
			$html .= '<td>' . $format_value . '</td>';
			$html .= '<td> <a href="view_quotation.php?quotation_number='.$quotation_number.'" >View</a></td>';
			$html .= '</tr>';
			echo $html;
		}
	}else{
		echo false;
	}
	
}

?>