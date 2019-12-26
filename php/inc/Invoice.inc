<?php
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");

class Invoice {
	
	//Database Fields
	public $invoice_id;
	public $quotation_number;
	public $value;
	public $created_by;
	public $created_date;
	public $status_id;
	public $value_paid;
	
	public function get_Invoices_by_quotation($quotation_number){
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT * FROM invoice where quotation_number=$quotation_number";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Invoice.get_Invoices_by_quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function format_invoice($invoice_id){
		$invoice_id_zerosleft = str_pad($invoice_id, 5, '0', STR_PAD_LEFT);		
		return $invoice_id_zerosleft;
	}
	
	public function getStatus($status_id){
		$db = new Database();
		$status_id = $db -> quote($status_id);
		$status_name = "false";
		
		$sql = "SELECT status_name FROM invoice INNER JOIN invoice_status ON (invoice.status_id = invoice_status.status_id) WHERE invoice.status_id=$status_id";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Invoice.getStatus';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
				$status_name = $row['status_name'];
			}else{
				//No rows returned
				$status_name = "false";
			}		
		}
		
		return $status_name;
	}
	
	
	public function get_Invoice_details($invoice_id){
		$db = new Database();
		$invoice_id = $db -> quote($invoice_id);
		
		$sql = "SELECT * FROM invoice INNER JOIN quotation ON (invoice.quotation_number = quotation.quotation_number) INNER JOIN customer ON (quotation.customer_id = customer.customer_id) where invoice_id=$invoice_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Invoice.get_Invoice_details';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
		
	}
}


?>