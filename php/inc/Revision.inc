<?php

//require_once("config/config.php");
require_once(PHP_CLASS_PATH . "/Database.inc");
require_once(PHP_CLASS_PATH . "/Files.inc");
require_once(PHP_CLASS_PATH . "/Format.inc");
require_once(PHP_CLASS_PATH . "/Historic_Revision.inc");

class Revision {
	//Database Fields
	public $revision_id;
	public $quotation_number;
	public $revision_letter;
	public $revision_name;
	public $revision_description;
	public $revision_date;
	public $created_date;
	public $created_by;
	
	public function add_Revision($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by){
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		$revision_letter = $db -> quote($revision_letter);
		$status_id = $db -> quote($status_id);
		$revision_name = $db -> quote($revision_name);
		$revision_description = $db -> quote($revision_description);
		$revision_date = $db -> quote($revision_date);
		$created_by = $db -> quote($created_by);
		
		$format = new Format();
		$created_date = $format->format_timestamp();
		$created_date = $db -> quote($created_date);
		
		$sql = "INSERT INTO revision (quotation_number, revision_letter, status_id, revision_name, revision_description, revision_date, created_by, created_date) 
							   VALUES($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by, $created_date)";
		
		$result = $db->do_query($sql);
		
		//Save into Historic_Revision
		$hist_revision = new Historic_Revision();
		$result2 = $hist_revision -> saveNew_Historic_Revision($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by);
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Revision.add_Revision';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		if ($result2 === false){
			return false;
		}

		
		return $result;	
	}
	
	public function get_LastrevisionLetter($quotation_number){
		$revision_letter = null;
		$db = new Database();
		$quotation_number = $db -> quote($quotation_number);
		
		$sql = "SELECT revision_id, revision_letter FROM revision WHERE quotation_number=$quotation_number order by revision_id desc limit 1";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_LastrevisionLetter';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		$json = json_decode($rows, true); // decode the JSON into an associative array
		foreach ($json["Result"] as $field){
			$revision_letter = $field['revision_letter'];
		}
			
		return $revision_letter;	
	}
	
	public function get_Next_RevisionLetter($revision_letter){
		$seq_letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$length = count($seq_letters);

		//If there is no revision so far
		if ($revision_letter == null){
			return 'A';
		}
		
		for ($i = 0; $i < $length-1; $i++) {
			if ($seq_letters[$i] == $revision_letter){
				return $seq_letters[$i+1];
				break;
			}
		}
		
		//In case it didnt find the letter or it is the last letter on the alphabet
		return false;	
	}
	
	public function get_AllRevisions($quotation_number){
		$db = new Database();
		$quotation_number = $db->quote($quotation_number);
		$sql = "SELECT * FROM revision WHERE quotation_number=$quotation_number";
		
		$rows = $db->select_Json($sql);
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_AllRevisions';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
		
	}
	
	public function get_revisionLetter($revision_id){
		$revision_letter = null;
		$db = new Database();
		$revision_id = $db -> quote($revision_id);
		
		$sql = "SELECT revision_letter FROM revision WHERE revision_id=$revision_id ";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_revisionLetter';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		$json = json_decode($rows, true); // decode the JSON into an associative array
		foreach ($json["Result"] as $field){
			$revision_letter = $field['revision_letter'];
		}
			
		return $revision_letter;	
		
	}
	
	public function get_quotation_Number($revision_id){
		$revision_letter = null;
		$db = new Database();
		$revision_id = $db -> quote($revision_id);
		
		$sql = "SELECT quotation_number FROM revision WHERE revision_id=$revision_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_quotation_Number';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		$json = json_decode($rows, true); // decode the JSON into an associative array
		foreach ($json["Result"] as $field){
			$quotation_number = $field['quotation_number'];
		}
			
		return $quotation_number;	
		
	}
		
	public function get_Revision_details($revision_id){
		$db = new Database();
		$revision_id = $db -> quote($revision_id);
		
		$sql = "SELECT * FROM revision where revision_id=$revision_id";
		$rows = $db->select_Json($sql);
		
		if($rows === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_Revision_details';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		return $rows;
		
	}
	
	public function set_StatusID($revision_id, $newStatus_Id, $updated_by){
		$db = new Database();
		$revision_id = $db->quote($revision_id);
		$newStatus_Id = $db->quote($newStatus_Id);
		$updated_by = $db->quote($updated_by);
		
		$sql = "UPDATE revision SET status_id=$newStatus_Id WHERE revision_id= $revision_id ";
		$result = $db->do_query($sql);
		
		//Save into Historic Revision
		$hist_revision = new Historic_Revision();
		$result2 = $hist_revision -> saveNewStatus_Historic_Revision($revision_id, $newStatus_Id, $updated_by);
			
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Revision.set_StatusID';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		
		if ($result2 === false){
			return false;
		}
		
		return  $result;
	}
	
	public function update_Revision($revision_id, $revision_name, $revision_date, $revision_description, $updated_by){
		$db = new Database();
		
		$revision_id = $db->quote($revision_id);
		$revision_name = $db->quote($revision_name);
		$revision_date = $db->quote($revision_date);
		$revision_description = $db->quote($revision_description);
		$updated_by = $db->quote($updated_by);
		
		$format = new Format();
		$updated_last_date = $format->format_timestamp();
		$updated_last_date = $db -> quote($updated_last_date);
		
		$sql ="UPDATE revision SET revision_name=$revision_name, revision_date=$revision_date, revision_description=$revision_description 
				WHERE revision_id=$revision_id";
		$result = $db->do_query($sql);
		
		//Save into Historic_Quotation		
		$hist_revision = new Historic_Revision();
		$result2 = $hist_revision -> saveEdit_Historic_Revision($revision_id, $revision_name, $revision_date, $revision_description, $updated_by);
	
		
		if($result === false){
			//Error LOG			
			$file = new Files();
			$class_method = 'Revision.update_Revision';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}
		if ($result2 === false){
			return false;
		}
		
		return  $result;
		
		
	}

	public function count_Revision(){
		$db = new Database();
		$sql = "SELECT COUNT(*) as count FROM revision";
		
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.count_Revision';
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

	public function count_status($status_id){
		$db = new Database();
		$status_id = $db -> quote($status_id);
		$sql = "SELECT COUNT(*) as count FROM revision WHERE status_id=$status_id";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.count_status';
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
		
	public function get_revision_Id($quotation_number, $revision_letter, $status_id, $revision_name, $revision_description, $revision_date, $created_by){
		$db = new Database();
		
		$quotation_number = $db -> quote($quotation_number);
		$revision_letter = $db -> quote($revision_letter);
		$status_id = $db -> quote($status_id);
		$revision_name = $db -> quote($revision_name);
		$revision_description = $db -> quote($revision_description);
		$revision_date = $db -> quote($revision_date);
		$created_by = $db -> quote($created_by);
		
		//Old. It is no longer being used because it was throwing the error when revision_name and/or revision_description had quotation mark ""
		//$sql = "SELECT revision_id FROM revision WHERE quotation_number=$quotation_number AND revision_letter=$revision_letter AND status_id=$status_id AND revision_name=$revision_name AND revision_description=$revision_description AND revision_date=$revision_date AND created_by=$created_by";
		$sql = "SELECT revision_id FROM revision WHERE quotation_number=$quotation_number AND revision_letter=$revision_letter AND status_id=$status_id AND revision_date=$revision_date AND created_by=$created_by order by revision_id desc limit 1";
		$row = $db->select_single($sql);
		
		if($row === false){
			//Error LOG
			$file = new Files();
			$class_method = 'Revision.get_revision_Id';
			$error_msg = $db-> error();
			$file->appendto_error_file($class_method, $error_msg);
		}else
		{
			// array_filter() function's default behavior will remove all values from array which are equal to null, 0, '' or false.
			$row = array_filter($row);			
			if(!empty($row)){
					$revision_id = $row['revision_id'];
			}else{
				//No rows returned
				$revision_id = "false";
			}		
		}
		
		return $revision_id;
		
	}
}

?>