<?php
//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");


class Quotation_Files {
	
	//Database Fields
	public $quotation_number;
	public $file_name;
	public $created_date;
	public $created_by;
	
	
	public function __construct(){
		
	}
	
	
	public function add_File($quotation_number, $file_name, $created_by){
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		$file_name = $db -> quote($file_name);
		$created_by = $db -> quote($created_by);

		$format = new Format();
		$created_date = $format->format_timestamp();
		$created_date = $db -> quote($created_date);
		
		$sql = "INSERT INTO quotation_files (quotation_number, file_name, created_by,created_date) 
							   VALUES($quotation_number, $file_name, $created_by, $created_date)";
		
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Quotation_Files.add_File';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}
	
	
	public function get_Files_by_quotation_number($quotation_number){
		$db = new Database();
		$customer_id = $db -> quote($quotation_number);
		
		$sql = "SELECT * FROM quotation_files where quotation_number=$quotation_number";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation_Files.get_Files_by_quotation_number';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}

	
	public function count_Files(){
		$db = new Database();
		$sql = "SELECT COUNT(*) as count FROM quotation_files";
		
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation_Files.count_Files';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$count = $row['count'];
			}else{
				//No rows returned
				$count = 0;
			}		
		}
		
		return $count;
		
	}



	
}
?>