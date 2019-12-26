<?php
//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");
require_once(PHP_CLASS_PATH . "/Historic_Quotation.inc");
require_once(PHP_CLASS_PATH . "/Customer.inc");

//ALTER TABLE quotation AUTO_INCREMENT=1001;

class Quotation {
	
	//Database Fields
	public $quotation_number;
	public $country;
	public $service_type;
	public $customer_id;
	public $project_name;
	public $project_description;
	public $project_date;
	public $created_date;
	public $created_by;
	
	
	public function __construct(){
		
	}
	
	
	public function add_Quotation($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date, $project_value){
		$db = new Database();
		
		$country = $db -> quote($country);
		$service_type = $db -> quote($service_type);
		$customer_id = $db -> quote($customer_id);
		$created_by = $db -> quote($created_by);
		$project_name = $db -> quote($project_name);
		$project_description = $db -> quote($project_description);
		$project_date = $db -> quote($project_date);
		$project_value = $db -> quote($project_value);
		
		$format = new Format();
		$created_date = $format->format_timestamp();
		$created_date = $db -> quote($created_date);
		
		$sql = "INSERT INTO quotation (country, service_type, customer_id,created_date,created_by,project_name,project_description,project_date, value) 
							   VALUES($country,$service_type,$customer_id,$created_date,$created_by,$project_name,$project_description,$project_date,$project_value)";
		
		$result = $db->do_query($sql);
		
		//Save into Historic_Quotation
		$hist_quotation = new Historic_Quotation();
		$result2 = $hist_quotation -> saveNew_Historic_Quotation($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date, $project_value);
			
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Quotation.add_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file_sql($class_method, $error_msg,$sql);
		}
		if ($result2 === false){
			return false;
		}
		
		return $result;
	}
	
	public function get_Quotation_id($country, $service_type, $customer_id, $created_by, $project_name, $project_description, $project_date){
		$db = new Database();
		
		$country = $db -> quote($country);
		$service_type = $db -> quote($service_type);
		$customer_id = $db -> quote($customer_id);
		$created_by = $db -> quote($created_by);
		$project_name = $db -> quote($project_name);
		$project_description = $db -> quote($project_description);
		$project_date = $db -> quote($project_date);
		
		//Old. It is no longer being used because it was throwing the error when quotation_name and/or quotation_description had quotation mark ""
		//$sql = "SELECT quotation_number FROM quotation WHERE country=$country AND service_type=$service_type AND customer_id=$customer_id AND created_by=$created_by AND project_name=$project_name AND project_description=$project_description AND project_date=$project_date";
		$sql = "SELECT quotation_number FROM quotation WHERE country=$country AND service_type=$service_type AND customer_id=$customer_id AND created_by=$created_by AND project_date=$project_date order by quotation_number desc limit 1";
		$row = $db->select_single($sql);
		//echo 'sql select: '.$sql;
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_Quotation_id';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$quotation_number = $row['quotation_number'];
			}else{
				//No rows returned
				$quotation_number = "false";
			}		
		}
		
		return $quotation_number;
		
	}
		
	public function get_Quotations_by_Customer_id($customer_id){
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		
		$sql = "SELECT * FROM quotation where customer_id=$customer_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_Quotations_by_Customer_id';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function get_All_Quotations(){
		$db = new Database();
		$sql = "SELECT * FROM quotation";
		
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_All_Quotations';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function search_Quotation($value){
		$db = new Database();
		$sql = "SELECT * FROM quotation inner join status on quotation.status_id = status.status_id
				WHERE
				quotation.quotation_number = '".$value."' OR 
				quotation.country like '%".$value."%' OR  
				quotation.service_type like '%".$value."%' OR 
				quotation.project_name like '%".$value."%'  OR	
				quotation.project_date like '%".$value."%' ";
				//Removed after add advanced search
				//OR status.status_name	like '%".$value."%' ";
		
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.search_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function advanced_search_Quotation($status_id, $minValue, $maxValue){
		$db = new Database();
		
		$qty_param = 0;
		if ($status_id != 0){
			$qty_param++;
		}
		if (!(!isset($maxValue) || trim($minValue)==='')){
			$qty_param++;
		}
		if (!(!isset($maxValue) || trim($maxValue)==='')){
			$qty_param++;
		}
		
		if ($qty_param > 0){
			$sql = "SELECT * FROM quotation WHERE ";
			if ($status_id != 0){
				$status_id = $db ->quote($status_id);
				$sql .= "status_id = $status_id";
				if (--$qty_param > 0){
					$sql .= " AND ";
				}
			}
			if ($minValue != ""){
				$minValue = $db ->quote($minValue);
				$sql .= "value >= $minValue";
				if (--$qty_param > 0){
					$sql .= " AND ";
				}
			}
			if ($maxValue != ""){
				$maxValue = $db ->quote($maxValue);
				$sql .= "value <= $maxValue";
			}				
		}else{
			//No parameters. return false
			return false;
		}

	
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.advanced_search_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function get_ServiceType_name($service_type){
		if ($service_type == 'DV'){
			return 'Development';
		}else 
		if ($service_type == 'SP'){
			return 'Support';
		}
	}
	
	public function get_Quotation_details($quotation_number){
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT * FROM quotation where quotation_number=$quotation_number";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_Quotation_details';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function format_quotation($service_type, $quotation_number, $customer_id_format){
		$quotation_number_zerosleft = str_pad($quotation_number, 4, '0', STR_PAD_LEFT);		
		$quotation_id = $service_type."-".$customer_id_format."-".$quotation_number_zerosleft;
		return $quotation_id;
	}
	
	public function format_quotation2($quotation_number){
		$customer_id = $this->get_Customer_id($quotation_number);
		$service_type = $this-> get_serviceType($quotation_number);
		
		$customer = new Customer();
		$customer_id_format = $customer -> format_customer_id($customer_id);
		
		$quotation_number_zerosleft = str_pad($quotation_number, 4, '0', STR_PAD_LEFT);		
		$quotation_id = $service_type."-".$customer_id_format."-".$quotation_number_zerosleft;
		return $quotation_id;
	}

	public function update_Quotation($quotation_number,$country,$service_type,$project_name,$project_description,$project_date,$updated_last_by,$project_value){
		$db = new Database();
		
		$quotation_number = $db->quote($quotation_number);
		$country = $db->quote($country);
		$service_type = $db->quote($service_type);
		$project_name = $db->quote($project_name);
		$project_description = $db->quote($project_description);
		$project_date = $db->quote($project_date);
		$updated_last_by = $db->quote($updated_last_by);
		$project_value = $db->quote($project_value);
		$updated_last_type = $db->quote('edit');

		$format = new Format();
		$updated_last_date = $format->format_timestamp();
		$updated_last_date = $db -> quote($updated_last_date);
		
		$sql ="UPDATE quotation SET country=$country, service_type=$service_type, project_name=$project_name, project_description=$project_description, project_date=$project_date, value=$project_value 
				WHERE quotation_number=$quotation_number";
		$result = $db->do_query($sql);
		
		//Save into Historic_Quotation
		$hist_quotation = new Historic_Quotation();
		$result2 = $hist_quotation -> saveEdit_Historic_Quotation($quotation_number, $country, $service_type, $updated_last_by, $project_name, $project_description, $project_date,$project_value);
			
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Quotation.update_Quotation';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		if ($result2 === false){
			return false;
		}
		
		return  $result;
	
	}
	
	public function get_Customer_id($quotation_number){
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT customer_id FROM quotation WHERE quotation_number=$quotation_number";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_Customer_id';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$customer_id = $row['customer_id'];
			}else{
				//No rows returned
				$customer_id = "false";
			}		
		}
		
		return $customer_id;
	}

	public function count_Quotation(){
		$db = new Database();
		$sql = "SELECT COUNT(*) as count FROM quotation";
		
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.count_Quotation';
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

	public function set_StatusID($quotation_number, $newStatus_Id, $updated_by){
		$db = new Database();
		$quotation_number = $db->quote($quotation_number);
		$newStatus_Id = $db->quote($newStatus_Id);
		$updated_by = $db->quote($updated_by);
		
		$sql = "UPDATE quotation SET status_id=$newStatus_Id WHERE quotation_number= $quotation_number ";
		$result = $db->do_query($sql);
		
		//Save into Historic_Quotation
		$hist_quotation = new Historic_Quotation();
		//$result2 = $hist_quotation -> saveEdit_Historic_Quotation($quotation_number, $country, $service_type, $created_by, $project_name, $project_description, $project_date);
		$result2 = $hist_quotation -> saveNewStatus_Historic_Quotation($quotation_number, $newStatus_Id, $updated_by);
			
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Quotation.set_StatusID';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		if ($result2 === false){
			return false;
		}
		
		return  $result;
	}

	public function get_StatusID($quotation_number){
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT status_id FROM quotation WHERE quotation_number=$quotation_number";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_StatusID';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$status_id = $row['status_id'];
			}else{
				//No rows returned
				$status_id = "false";
			}		
		}
		
		return $status_id;
		
	}

	public function get_serviceType($quotation_number){
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT service_type FROM quotation WHERE quotation_number=$quotation_number";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.get_serviceType';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$service_type = $row['service_type'];
			}else{
				//No rows returned
				$service_type = "false";
			}		
		}
		
		return $service_type;
	}
	
	public function count_status($status_id){
		$db = new Database();
		$status_id = $db -> quote($status_id);
		$sql = "SELECT COUNT(*) as count FROM quotation WHERE status_id=$status_id";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Quotation.count_status';
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