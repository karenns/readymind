<?php
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");

class Invoice_items {
	
	//Database Fields
	public $item_id;
	public $invoice_id;
	public $item_name;
	public $item_description;

	
	public function get_Items($invoice_id){
		$db = new Database();
		$invoice_id = $db -> quote($invoice_id);
		
		$sql = "SELECT * FROM invoice_items where invoice_id=$invoice_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Invoice_items.get_Items';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	
}	
?>