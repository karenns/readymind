<?php

//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");

class Status{
	
	public function getStatus_Name($status_id){
		$db = new Database();
		
		$status_id = $db -> quote($status_id);
		
		$sql = "SELECT status_name FROM status WHERE status_id=$status_id";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Status.getStatus_Name';
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
	
	public function getColor_Status($status_id){
		//Choose Button Color according the status
		$class_button = '';
		
		//In Progress - green
		if ($status_id == 1){
			$class_button = 'success';	
			
		//Customer Reviewed - blue
		}else if ($status_id == 2){
			$class_button = 'info';
		
		//Cancelled - red
		}else if ($status_id == 3){
			$class_button = 'danger';
			
		//Closed - yellow
		}else if ($status_id == 4){
			$class_button = 'warning';
		}
	return $class_button;	
	}
	
}



?>