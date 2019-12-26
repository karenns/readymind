<?php
/* AJAX */

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$country = $_POST['country'];
	
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Customer.inc");
	$customer = new Customer();
	$json_customers = $customer -> advanced_search_Customer($country);
	//$json_customers = $customer -> search_Customers_byCountry($country);

	$json = json_decode($json_customers, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* $html .= '<pre>' . print_r($json, true) . '</pre>'; */

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
	
}
	
?>