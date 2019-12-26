<?php

class Files {
/*
https://davidwalsh.name/basic-php-file-handling-create-open-read-write-append-close-delete
http://php.net/manual/en/function.file-put-contents.php
https://www.w3schools.com/php/php_file_open.asp
*/
	
	
	public function create_file($file_name){
		$handle = fopen($file_name, 'x') or die('Cannot open file:  '.$file_name); //implicitly creates file
	}

	public function open_file($file_name){
		$handle = fopen($file_name, 'a') or die('Cannot open file:  '.$file_name); //open file for writing ('w','r','a')...	
	}
	
	public function read_file($file_name){
		$handle = fopen($file_name, 'r');
		$data = fread($handle,filesize($file_name));
		
		return $data;
	}
	
	public function write_file($file_name, $data){
		$handle = fopen($file_name, 'w') or die('Cannot open file:  '.$file_name);
		fwrite($handle, $data);	
	}
	
	public function appendto_file($file_name, $data){
		/*
		$current = $this->read_file($file_name);
		$data = $current ."\n". $data;
		$handle = fopen($file_name, 'a') or die('Cannot open file:  '.$file_name);
		fwrite($handle, $data);
		
		
		$current = file_get_contents($file_name);
		$current .= $data;
		file_put_contents($file_name, $current);
		*/
		$handle = fopen($file_name, 'a') or die('Cannot open file:  '.$file_name);
		fwrite($handle, $data);
	}
	
	public function close_file($file_name){
		$handle = fopen($file_name, 'w') or die('Cannot open file:  '.$file_name);
		fclose($handle);
	
	}
	
	public function delete_file($file_name){
		unlink($file_name);
	}
	
	
	public function get_error_file_name(){
		$file_name = 'error/error_log.txt';
		return $file_name;
	}
	
	public function appendto_error_file($class_method, $error_msg){
		$file_name = $this->get_error_file_name();		
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('America/Chicago'));
		$timestamp = $date->format('Y-m-d H:i:s');
		$data = "[". $timestamp . "]: " . $class_method . " - " . $error_msg .PHP_EOL ;
		$this->appendto_file($file_name, $data);
	}
	
	public function appendto_error_file_sql($class_method, $error_msg, $sql){
		$file_name = $this->get_error_file_name();		
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('America/Chicago'));
		$timestamp = $date->format('Y-m-d H:i:s');
		$data = "[". $timestamp . "]: " . $class_method . " - " . $error_msg .PHP_EOL ." - SQL: ". $sql;
		$this->appendto_file($file_name, $data);
	}
	
}



?>