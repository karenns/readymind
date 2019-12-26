<?php

//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");

// https://wwphp-fb.github.io/faq/security/passwords/

class User {
	
	public $user_id;
	public $name;
	public $password;
	public $email;
	public $created_date;
	public $created_by;
	
	public $confirmation_code;
	public $confirmation_date;
	
	public function __construct(){
		
	}
	
	public function add_User($user_id,$name,$email,$password_hash,$created_by){
		$db = new Database();
		$user_id = $db -> quote($user_id);
		$name = $db -> quote($name);
		$email = $db -> quote($email);
		$password_hash = $db -> quote($password_hash);
		$created_by = $db -> quote($created_by);
		
		$format = new Format();
		$created_date = $format->format_timestamp();
		$created_date = $db -> quote($created_date);
		
		$sql = "INSERT INTO user (user_id, name, email, password_hash,created_date,created_by) 
						 VALUES ($user_id,$name,$email, $password_hash, $created_date,$created_by)";
						 
		$result = $db-> do_query($sql);	
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'User.add_User';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return  $result;	
	}
	
	public function is_User_id_available($user_id){
		if ($user_id == ''){
			return false;
		}
		$db = new Database();
		$user_id = $db -> quote ($user_id);
		
		$sql = "SELECT * FROM user WHERE user_id=$user_id limit 1";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'User.is_User_id_available';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
				return false;
			}else{
				//No rows returned
				return true;
			}		
		}	
		return false;	
	}
	
	public function is_correct_email($email){
		$domain_default = 'sheerindustries.com';
		list($name_email, $domain_email) = explode("@", $email);
		if ($domain_email === $domain_default){
			return true;
		}else{
			return false;
		}		
	}

	public function hashPassword($password){
		$options = ['cost' => 12];
		return password_hash($password, PASSWORD_DEFAULT, $options);
	}
	
	public function hashPassword2($password){
	//https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
	//$username = 'Admin';
	//$password = 'gf45_gdf#4hg';

	// A higher "cost" is more secure but consumes more processing power
	//$cost = 10;
	$cost = 5;

	// Create a random salt
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

	// Prefix information about the hash so PHP knows how to verify it later.
	// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjQ==

	// Hash the password with the salt
	$hash = crypt($password, $salt);

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjOL.oTxqp7WylW7FCzx2Lc7VLmdJIddZq
	
	return $hash;
}	
	
	public function is_correct_authentication($user_id, $password){
		$db = new Database();
		$user_id = $db->quote($user_id);
		$password_hash = $db->quote($password);
		
		$sql = "SELECT password_hash FROM user WHERE user_id=$user_id";
		$row = $db ->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'User.is_correct_authentication';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
				$db_password_hash = $row['password_hash'];
				//echo db_password_hash;
				if (password_verify($password,$db_password_hash)){
					return true;
				}

			}else{
				//No rows returned
				return false;
			}		
		}	
		return false;
		
	}
	
	public function get_name($user_id){
		$db = new Database();
		$user_id = $db -> quote($user_id);
		
		$sql = "SELECT name FROM user where user_id=$user_id";	
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'User.get_name';
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
	
	
	public function update_Password($user_id, $password_hash){
		$db = new Database();
		$password_hash = $db -> quote($password_hash);
		$user_id = $db -> quote($user_id);
		
		$sql = "UPDATE user SET password_hash=$password_hash
						 WHERE user_id= $user_id";
						 
		$result = $db-> do_query($sql);	
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'User.update_Password';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return  $result;		
	}
	
	public function get_All_Users(){
		$db = new Database();
		$sql = "SELECT * FROM user";
		
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'User.get_All_Users';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function get_User_details($user_id){
		$db = new Database();
		$user_id = $db -> quote($user_id);
		
		$sql = "SELECT * FROM user where user_id=$user_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'User.get_User_details';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
	}
	
	public function update_User($user_id, $name, $email){
		$db = new Database();
		
		$user_id = $db->quote($user_id);
		$name = $db->quote($name);
		$email = $db->quote($email);
		
		$sql ="UPDATE user SET name=$name, email=$email 
				WHERE user_id=$user_id";
		$result = $db->do_query($sql);
		

		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'User.update_User';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}

		return  $result;
	
	}
	
	public function user_has_Madetransactions($user_id){
		$db = new Database();
		$user_id = $db->quote($user_id);
		
		$sql1 = "SELECT * FROM quotation WHERE created_by=$user_id limit 1";
		$row1 = $db->select_single($sql1);

		$sql2 = "SELECT * FROM historic_quotation WHERE updated_by=$user_id limit 1";
		$row2 = $db->select_single($sql2);		
		
		$sql3 = "SELECT * FROM revision WHERE created_by=$user_id limit 1";
		$row3 = $db->select_single($sql3);
		
		$sql4 = "SELECT * FROM historic_revision WHERE updated_by=$user_id limit 1";
		$row4 = $db->select_single($sql4);
		
		$sql5 = "SELECT * FROM revision_files WHERE created_by=$user_id limit 1";
		$row5 = $db->select_single($sql5);		
		
		$sql6 = "SELECT * FROM quotation_files WHERE created_by=$user_id limit 1";
		$row6 = $db->select_single($sql6);
		
		$sql7 = "SELECT * FROM customer WHERE created_by=$user_id limit 1";
		$row7 = $db->select_single($sql7);
		
		$sql8 = "SELECT * FROM historic_customer WHERE updated_by=$user_id limit 1";
		$row8 = $db->select_single($sql8);
		
		$sql9 = "SELECT * FROM user WHERE created_by=$user_id limit 1";
		$row9 = $db->select_single($sql9);
		
		if(($row1 === false)||($row2 === false)||($row3 === false)||($row4 === false)||($row5 === false)||($row6 === false)||($row7 === false)||($row8 === false)||($row9 === false) ){
			//Error LOG
			$file = new Files();
			$class_method = 'User.user_has_Madetransactions';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row1 = array_filter($row1);			
			$row2 = array_filter($row2);			
			$row3 = array_filter($row3);			
			$row4 = array_filter($row4);			
			$row5 = array_filter($row5);			
			$row6 = array_filter($row6);			
			$row7 = array_filter($row7);			
			$row8 = array_filter($row8);			
			$row9 = array_filter($row9);			
			
			if((!empty($row1))||(!empty($row2))||(!empty($row3))||(!empty($row4))||(!empty($row5))||(!empty($row6))||(!empty($row7))||(!empty($row8))||(!empty($row9)) ){
				return true;
			}else{
				//No rows returned
				return false;
			}		
		}	
		return 'true';
	}
	
	public function delete_User($user_id){
		$db = new Database();
		
		$user_id = $db->quote($user_id);
		
		$sql ="DELETE FROM user WHERE user_id=$user_id";
		$result = $db->do_query($sql);
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'User.delete_User';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}

		return  $result;
		
	}
	
}


?>