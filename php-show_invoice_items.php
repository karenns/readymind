<?php
/* AJAX */
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$invoice_id = $_POST['invoice_id'];
	//$invoice_id = 1;
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Invoice_Items.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
	$invoice_item = new Invoice_items();
	$json_invoice = $invoice_item -> get_Items($invoice_id);
	$json = json_decode($json_invoice, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* $html .= '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	
	if ($json_invoice){
		foreach ($json["Result"] as $field) {
		
			$item_name = $field['item_name'];
			$item_description = $field['item_description'];
			$value = $field['value'];
			$qty = $field['qty'];
			
			$html ='';
			$html .= '<tr class="item-row">';
			$html .= '<td class="item-name"><div class="delete-wpr"><textarea>'.$item_name.'</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>';
			$html .= '<td class="description"><textarea>'.$item_description.'</textarea></td>';
			$html .= '<td><textarea class="cost">$'.$value.'</textarea></td>';
			$html .= '<td><textarea class="qty">'.$qty.'</textarea></td>';
			$html .= '<td><span class="price"></span></td>';

			echo $html;

		}
	}else{
		echo false;	
	}
	
	
}else{
	echo false;
}


?>