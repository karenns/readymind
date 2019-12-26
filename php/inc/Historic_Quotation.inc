<?php

//require_once("config/config.php");

require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");

//ALTER TABLE quotation AUTO_INCREMENT=1001;

class Historic_Quotation {
	
	//Database Fields
	public $id;
	public $service_type;
	public $quotation_number;
	public $country;
	public $customer_id;
	public $project_name;
	public $project_description;
	public $project_date;
	public $updated_date;
	public $updated_by;
	public $updated_type;
	
	public function __construct(){
		
	}
	
	
	public function saveNew_Historic_Quotation($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date,$project_value){
		//CLEAN the quotes before. NEED to be done!
		$country = str_replace("'", "", $country);
		$service_type = str_replace("'", "", $service_type);
		$customer_id = str_replace("'", "", $customer_id);
		$created_by = str_replace("'", "", $created_by);
		$project_name = str_replace("'", "", $project_name);
		$project_description = str_replace("'", "", $project_description);
		$project_date = str_replace("'", "", $project_date);
		$project_value = str_replace("'", "", $project_value);
		$status_id = 1;
		
		//Get quotation_number
		$quote = new Quotation();
		$quotation_number = $quote -> get_Quotation_id($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date);
		
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		$country = $db -> quote($country);
		$service_type = $db -> quote($service_type);
		$created_by = $db -> quote($created_by);
		$project_name = $db -> quote($project_name);
		$project_description = $db -> quote($project_description);
		$project_date = $db -> quote($project_date);
		$project_value = $db -> quote($project_value);
		$updated_type = $db -> quote ('new');
		$status_id = $db -> quote ('1');
		
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		
		$sql = "INSERT INTO historic_quotation (quotation_number,country,service_type,project_name, project_description, project_date, updated_by, updated_date, updated_type, status_id, value) 
							   VALUES($quotation_number,$country, $service_type,$project_name, $project_description, $project_date, $created_by, $updated_date, $updated_type, $status_id, $project_value)";
		
		//echo 'sql insert: '.$sql;
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Quotation.saveNew_Historic_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}

	public function saveEdit_Historic_Quotation($quotation_number, $country, $service_type, $updated_by, $project_name, $project_description, $project_date, $project_value){
		//CLEAN the quotes before. NEED to be done!
		$quotation_number = str_replace("'", "", $quotation_number);
		$country = str_replace("'", "", $country);
		$service_type = str_replace("'", "", $service_type);
		$updated_by = str_replace("'", "", $updated_by);
		$project_name = str_replace("'", "", $project_name);
		$project_description = str_replace("'", "", $project_description);
		$project_date = str_replace("'", "", $project_date);
		$project_value = str_replace("'", "", $project_value);
		
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		$country = $db -> quote($country);
		$service_type = $db -> quote($service_type);
		$updated_by = $db -> quote($updated_by);
		$project_name = $db -> quote($project_name);
		$project_description = $db -> quote($project_description);
		$project_date = $db -> quote($project_date);
		$updated_type = $db -> quote ('edit');
		$project_value = $db -> quote ($project_value);
		
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		
		$sql = "INSERT INTO historic_quotation (quotation_number,country,service_type,project_name, project_description, project_date, value, updated_by, updated_date, updated_type) 
							   VALUES($quotation_number,$country, $service_type,$project_name, $project_description, $project_date, $project_value, $updated_by, $updated_date, $updated_type)";
		
		//echo 'sql insert: '.$sql;
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Quotation.saveEdit_Historic_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}

	public function saveNewStatus_Historic_Quotation($quotation_number, $newStatus_Id, $updated_by){
		//CLEAN the quotes before. NEED to be done!
		$quotation_number = str_replace("'", "", $quotation_number);
		$newStatus_Id = str_replace("'", "", $newStatus_Id);
		$updated_by = str_replace("'", "", $updated_by);
		
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		$newStatus_Id = $db -> quote($newStatus_Id);
		$updated_by = $db -> quote($updated_by);
		
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		$updated_type = $db -> quote ('edit');
		
		$sql = "INSERT INTO historic_quotation (quotation_number,status_id, updated_by, updated_date, updated_type) 
							   VALUES($quotation_number, $newStatus_Id, $updated_by, $updated_date, $updated_type)";
		
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Quotation.saveNewStatus_Historic_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}
	
}
?>