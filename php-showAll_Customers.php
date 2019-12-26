<?php
/* AJAX */
require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Customer.inc");

	$customer = new Customer();	
	$json_customer = $customer -> get_All_Customers();

	/*	Print the JSON	*/
	/* $html .= $json_customer; */

	$json = json_decode($json_customer, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* $html .= '<pre>' . print_r($json, true) . '</pre>'; */

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
		
			$html = '';
			$html .= '<tr>';
			$html .= '<td>' . $country . '</td>';
			$html .= '<td>' . $customer_id_format . '</td>';
			$html .= '<td>' . $name . '</td>';
			$html .= '<td>' . $company . '</td>';
			$html .= '<td> <a href="view_customer.php?customer_id='.$customer_id.'" >View</a></td>';
			$html .= '</tr>';
			echo $html;
		}
	}else{
		echo false;
	}
	
?>