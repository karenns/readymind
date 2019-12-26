<?php

//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");


class Historic_Revision {
	
	//Database Fields
	public $id;
	public $revision_id;
	public $revision_name;
	public $revision_description;
	public $revision_date;
	public $status_id;
	public $updated_date;
	public $updated_by;
	
	
	public function __construct(){
		
	}
	
	public function saveNew_Historic_Revision($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by){
		//CLEAN the quotes before. NEED to be done!
		$quotation_number = str_replace("'", "", $quotation_number);
		$revision_letter = str_replace("'", "", $revision_letter);
		$status_id = str_replace("'", "", $status_id);
		$revision_name = str_replace("'", "", $revision_name);
		$revision_description = str_replace("'", "", $revision_description);
		$revision_date = str_replace("'", "", $revision_date);
		$created_by = str_replace("'", "", $created_by);
		
		//Get quotation_number
		$revision = new Revision();
		$revision_id = $revision -> get_revision_Id($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by);
		$db = new Database();
		
		$revision_id = $db -> quote($revision_id);
		$revision_name = $db -> quote($revision_name);
		$revision_description = $db -> quote($revision_description);
		$revision_date = $db -> quote($revision_date);
		$created_by = $db -> quote($created_by);
		$status_id = $db -> quote ('1');
		
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		$updated_type = $db -> quote('new');
		
		$sql = "INSERT INTO historic_revision (revision_id,revision_name,revision_description,revision_date, status_id, updated_by, updated_date, updated_type) 
							   VALUES($revision_id,$revision_name, $revision_description,$revision_date, $status_id, $created_by, $updated_date, $updated_type)";
		
		//echo 'sql insert: '.$sql;
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Revision.saveNew_Historic_Revision';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}
	
	
	public function saveEdit_Historic_Revision($revision_id, $revision_name, $revision_date, $revision_description, $updated_by){
		//CLEAN the quotes before. NEED to be done!
		$revision_id = str_replace("'", "", $revision_id);
		$revision_name = str_replace("'", "", $revision_name);
		$revision_description = str_replace("'", "", $revision_description);
		$revision_date = str_replace("'", "", $revision_date);
		$updated_by = str_replace("'", "", $updated_by);
		
		
		$db = new Database();
		$revision_id = $db -> quote($revision_id);
		$revision_name = $db -> quote($revision_name);
		$revision_description = $db -> quote($revision_description);
		$revision_date = $db -> quote($revision_date);
		$updated_by = $db -> quote($updated_by);
			
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		$updated_type = $db -> quote('edit');
		
		$sql = "INSERT INTO historic_revision (revision_id,revision_name,revision_description,revision_date, updated_by, updated_date, updated_type) 
							   VALUES($revision_id,$revision_name, $revision_description,$revision_date, $updated_by, $updated_date, $updated_type)";
		
		
		echo 'sql insert: '.$sql;
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Revision.saveEdit_Historic_Revision';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
	}
	
	public function saveNewStatus_Historic_Revision($revision_id, $newStatus_Id, $updated_by){
		//CLEAN the quotes before. NEED to be done!
		$revision_id = str_replace("'", "", $revision_id);
		$newStatus_Id = str_replace("'", "", $newStatus_Id);
		$updated_by = str_replace("'", "", $updated_by);
		
		$db = new Database();
		$revision_id = $db -> quote($revision_id);
		$newStatus_Id = $db -> quote($newStatus_Id);
		$updated_by = $db -> quote($updated_by);
		
		$format = new Format();
		$updated_date = $format->format_timestamp();
		$updated_date = $db -> quote($updated_date);
		$updated_type = $db -> quote ('edit');
		
		$sql = "INSERT INTO historic_revision (revision_id,status_id, updated_by, updated_date, updated_type) 
							   VALUES($revision_id, $newStatus_Id, $updated_by, $updated_date, $updated_type)";
		
		$result = $db->do_query($sql);
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Historic_Revision.saveNewStatus_Historic_Revision';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		return $result;
		
	}
}
?>