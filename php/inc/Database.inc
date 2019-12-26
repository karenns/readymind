<?php

class Database {
	
	protected static $connection;
	
	
	public function connect(){
		//Try to connect to the database
		if(!isset(self::$connection)){
			//Load configuration as an array
			$config = parse_ini_file('config/config.ini');
			self::$connection = new mysqli($config['host'],$config['username'], $config['password'], $config['dbname']);	
		}
		
		//If connection was not succesful, handle the error
		if (self::$connection === false){
			//Handle the error
			return false;
		}
		
		return self::$connection;
	}
	
	
	public function do_query($sql){
		// Connect to the database
		$connection = $this -> connect();
		
		// Query the database
		$result = $connection -> query($sql);
		
		return $result;
	}
	
	public function select_single($sql){
		$row = array();
		$result = $this -> do_query($sql);
		
		if ($result === false){
			return false;
		}
		
		while ($row_fetch = $result -> fetch_assoc()){
			$row = $row_fetch;
		}
		
		//Returns an array with only one element
		return $row;	
	}
	
	public function select($sql){
		$rows = array();
		$result = $this -> do_query($sql);
		
		if ($result === false){
			return false;
		}
		
		while ($row = $result -> fetch_assoc()){
			$rows[] = $row;
		}
		
		//Returns an array
		return $rows;	
	}
	
	public function select_Json($sql){
		$rows = array();
		$result = $this -> do_query($sql);
		
		if ($result === false){
			return false;
		}
		
		while ($row = $result -> fetch_assoc()){
			$rows[] = $row;
		}
		
		//Returns a Json File
		return json_encode(array("Result"	=> $rows));	
		//return json_encode($rows);
	}
	
	public function select_Json2($sql){
		$rows = array();
		$result = $this -> do_query($sql);
		
		if ($result === false){
			return false;
		}
		
		while ($row = $result -> fetch_assoc()){
			$rows[] = $row;
		}
		
		//Returns a Json File
		//return json_encode(array("Result"	=> $rows));	
		return json_encode($rows);
	}
	
	public function error(){
		$connection = $this -> connect();
		return $connection -> error;
	}
	
	public function quote($value){
		$connection = $this -> connect();
		$value = trim($value);
		return "'" . $connection -> real_escape_string($value) . "'";
	}
	
}

?>