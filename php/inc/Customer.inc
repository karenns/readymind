<?php
//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");
require_once(PHP_CLASS_PATH . "/Historic_Customer.inc");

class Customer {
	
	//Database Fields
	public $customer_id;
	public $name;
	public $company;
	public $email;
	public $country;
	public $city;
	public $phone;
	public $created_date;
	public $created_by;
	
	
	public function __construct(){
		
	}
	
	public function get_Customer_id($name, $company, $email, $country, $city, $phone, $created_by){
		$db = new Database();
		$name = $db -> quote($name);
		$company = $db -> quote($company);
		$email = $db -> quote($email);
		$country = $db -> quote($country);
		$city = $db -> quote($city);
		$phone = $db -> quote($phone);
		$created_by = $db -> quote($created_by);
		
		
		$sql = "SELECT customer_id FROM customer where name=$name and company=$company and email= $email and country= $country and city=$city
										and phone=$phone and created_by=$created_by order by customer_id desc limit 1";	
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.get_Customer_id';
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
	
	public function add_Customer($name, $company, $email, $country, $city, $phone, $created_by){
		$db = new Database();
		
		$name = $db -> quote($name);
		$company = $db -> quote($company);
		$email = $db -> quote($email);
		$country = $db -> quote($country);
		$city = $db -> quote($city);
		$phone = $db -> quote($phone);
		$created_by = $db -> quote($created_by);
		
		$format = new Format();
		$created_date = $format->format_timestamp();
		$created_date = $db -> quote($created_date);
		
		$sql = "INSERT INTO customer (name, company, email, country, city, phone, created_date, created_by) 
					VALUES ($name, $company, $email, $country, $city, $phone, $created_date, $created_by)";
	
		$result = $db->do_query($sql);

		//Save into Historic_Customer
		$hist_customer = new Historic_Customer();
		$result2 = $hist_customer -> saveNew_Historic_Customer($name, $company, $email, $country, $city, $phone, $created_by);
			
		if ($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Customer.add_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);	
		}
		if ($result2 === false){
			return false;
		}

		return  $result;
	}
	
	public function get_All_Customers(){
		$db = new Database();
		$sql = "SELECT * FROM customer";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.get_All_Customers';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function get_Customer($customer_id){
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		
		$sql = "SELECT * FROM customer WHERE customer_id=$customer_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.get_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
    public function search_Customer($value){
		$db = new Database();
		//$value = $db -> quote($value);
		
		$sql = "SELECT * FROM customer WHERE
				customer_id = '".$value."' OR 
				name like '%".$value."%' OR 
				company like '%".$value."%'" ;
				//Removed after add advanced search by country
				//OR country like '%".$value."%' ";

		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.search_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}

		return $rows;
		
	
	}
	
	public function advanced_search_Customer($country){
		$db = new Database();
		
		$qty_param = 0;

		if (!(!isset($country) || trim($country)==='')){
			$qty_param++;
		}
		
		if ($qty_param > 0){
			$sql = "SELECT * FROM customer WHERE ";
			if ($country != ""){
				$country = $db ->quote($country);
				$sql .= "country = $country";
				if (--$qty_param > 0){
					//$sql .= " AND ";
				}
			}			
		}else{
			//No parameters. return false
			return false;
		}

	
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.advanced_search_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	
	}
	
	public function advanced_search_CustomerOLD($value,$field){
		$db = new Database();
		//$value = $db -> quote($value);
		
		$sql = "SELECT * FROM customer WHERE
				customer_id = '".$value."' OR 
				name like '%".$value."%' OR 
				company like '%".$value."%' OR 
				email like '%".$value."%' OR 
				country like '%".$value."%' OR 
				city like '%".$value."%' OR 
				phone like '%".$value."%' OR 
				created_date ='".$value."' OR 
				created_by like '%".$value."%' 			";
		
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.search_Advanced_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		$file = new Files();
		$file->appendto_error_file('Test', $sql);
		return $rows;
		
	
	}

	public function format_customer_id($customer_id){
		return (str_pad($customer_id, 3, '0', STR_PAD_LEFT));	
	}
	
	/*
	public function format_customer($customer_id, $country){
		$frmt_customer_id = (str_pad($customer_id, 3, '0', STR_PAD_LEFT));	
		return $country.$frmt_customer_id;
	}
	*/
	
	public function update_Customer($customer_id, $name, $company, $email, $country, $city, $phone, $updated_by){
		
		$db = new Database();
		
		$customer_id = $db -> quote($customer_id);
		$name = $db -> quote($name);
		$company = $db -> quote($company);
		$email = $db -> quote($email);
		$country = $db -> quote($country);
		$city = $db -> quote($city);
		$phone = $db -> quote($phone);
		$updated_by = $db -> quote($updated_by);
		
		$format = new Format();
		$updated_last_date = $format->format_timestamp();
		$updated_last_date = $db -> quote($updated_last_date);
		
		
		$sql = "UPDATE customer SET name=$name, company=$company, email=$email, country=$country, city=$city, phone=$phone		
				WHERE customer_id= $customer_id ";
	
		$result = $db->do_query($sql);
		
		//Save into Historic_Customer
		$hist_customer = new Historic_Customer();
		$result2 = $hist_customer -> saveEdit_Historic_Customer($customer_id, $name, $company, $email, $country, $city, $phone, $updated_by);
			
		if ($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Customer.update_Customer';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		if ($result2 === false){
			return false;
		}
		
		return  $result;
	}	

	
	public function count_Customer(){
		$db = new Database();
		$sql = "SELECT COUNT(*) as count FROM customer";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.count_Customer';
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

	
	public function get_Customer_name($customer_id){
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		
		$sql = "SELECT name FROM customer where customer_id=$customer_id limit 1";	
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.get_Customer_name';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$name = $row['name'];
			}else{
				//No rows returned
				$name = "false";
			}		
		}
		
		return $name;
	}
	
	public function get_Customer_company($customer_id){
		$db = new Database();
		$customer_id = $db -> quote($customer_id);
		
		$sql = "SELECT company FROM customer where customer_id=$customer_id limit 1";	
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Customer.get_Customer_company';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$company = $row['company'];
			}else{
				//No rows returned
				$company = false;
			}		
		}
		
		return $company;
	}
	
	
}

?>