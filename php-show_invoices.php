<?php
/* AJAX */
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$quotation_number = $_POST['quotation_number'];
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Invoice.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
	//echo 'quotation_number: '. $quotation_number;
	$invoice = new Invoice();
	$json_invoice = $invoice -> get_Invoices_by_quotation($quotation_number);
	$json = json_decode($json_invoice, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* $html .= '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	if ($json_invoice){
		foreach ($json["Result"] as $field) {	
			$quotation_number = $field['quotation_number'];
			$invoice_id = $field['invoice_id'];
			$value = $field['value'];
			$date = $field['date'];
			$status_id = $field['status_id'];
			
			//Get status name
			$status_name = $invoice -> getStatus($status_id);
			
			//Format invoice id
			$frmt_invoice_id = $invoice-> format_invoice($invoice_id);
			
			//Format currency
			$frmt = new Format();
			$format_value = $frmt ->format_currency($value);		
			
			$html ='';
			$html .= '<tr>';
			$html .= '<td>' . $frmt_invoice_id . '</td>';
			$html .= '<td>' . $date . '</td>';
			$html .= '<td>' . $format_value . '</td>';
			$html .= '<td>' . $status_name . '</td>';
			$html .= '<td> <a href="view_invoice.php?invoice_id='.$invoice_id.'">View</a></td>';
			$html .= '</tr>';
			echo $html;
		}
	}else{
		echo false;	
	}
}


?>