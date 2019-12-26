<?php
//require_once("config/config.php");

require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");
require_once(PHP_CLASS_PATH . "/Customer.inc");

class Historic_Customer {
	
	//Database Fields
	public $id;
	public $customer_id;
	public $name;
	public $company;
	public $email;
	public $country;
	public $city;
	public $phone;
	public $updated_date;
	public $updated_by;
	public $updated_type;
	
	
	public function __construct(){
		
	}
	
	public function saveNew_Historic_Customer($name, $company, $email, $country, $city, $phone, $updated_by){		
		//CLEAN the quotes before. NEED to be done!
		$name = str_replace("'", "", $name);
		$company = str_replace("'", "", $company);
		$email = str_replace("'", "", $email);
		$country = str_replace("'", "", $country);
		$city = str_replace("'", "", $city);
		$phone = str_replace("'", "", $phone);
		$updated_by = str_replace("'", "", $updated_by);
		
		//Get customer_id
		$customer = new Customer();
		$customer_id = $customer -> get_Customer_id($name, $company, $email, $country, $city, $phone, $updated_by);
		
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		$name = $db -> quote($name);
		$company = $db -> quote($company);
		$email = $db -> quote($email);
		$country = $db -> quote($country);
		$city = $db -> quote($city);
		$phone = $db -> quote($phone);
		$updated_by = $db -> quote($updated_by);
		$updated_type = $db -> quote('new'); 
		
		//Time Stamp
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		
		$sql = "INSERT INTO historic_customer (customer_id, name, company, email, country, city, phone, updated_date, updated_by, updated_type) 
					VALUES ($customer_id, $name, $company, $email, $country, $city, $phone, $updated_date, $updated_by, $updated_type)";
	
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Customer.saveNew_Historic_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return  $result;
	}
	
	public function saveEdit_Historic_Customer($customer_id, $name, $company, $email, $country, $city, $phone, $updated_by){
		//CLEAN the quotes before. NEED to be done!
		$customer_id = str_replace("'", "", $customer_id);
		$name = str_replace("'", "", $name);
		$company = str_replace("'", "", $company);
		$email = str_replace("'", "", $email);
		$country = str_replace("'", "", $country);
		$city = str_replace("'", "", $city);
		$phone = str_replace("'", "", $phone);
		$updated_by = str_replace("'", "", $updated_by);
		
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		$name = $db -> quote($name);
		$company = $db -> quote($company);
		$email = $db -> quote($email);
		$country = $db -> quote($country);
		$city = $db -> quote($city);
		$phone = $db -> quote($phone);
		$updated_by = $db -> quote($updated_by);
		$updated_type = $db -> quote('edit'); 
		
		//Time Stamp
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		
		$sql = "INSERT INTO historic_customer (customer_id, name, company, email, country, city, phone, updated_date, updated_by, updated_type) 
					VALUES ($customer_id, $name, $company, $email, $country, $city, $phone, $updated_date, $updated_by, $updated_type)";
	
		$result = $db->do_query($sql);
		echo 'SQL: '. $sql;
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Customer.saveEdit_Historic_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return  $result;
	}
	
}

?>