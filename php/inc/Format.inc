<?php

class Format {
	
	public function format_timestamp(){
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('America/Chicago'));
		$timestamp = $date->format('Y-m-d H:i:s');
		return $timestamp;
	}
	
	public function format_date(){
		$date = new DateTime();
		$date->setTimezone(new DateTimeZone('America/Chicago'));
		$date_formated = $date->format('Y-m-d');
		return $date_formated;
	}
	
	public function format_currency($value){
		//Need a config on php
		//$value = floatval($value);
		//$fmt = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY );	
		//$value_formated = $fmt->formatCurrency($value, "USD");
		
		//Do not work on Windows
		//setlocale(LC_MONETARY,"en_US");
		//$value_formated = money_format($value);
		
		$value_formated = '$';
		$value_formated .= number_format($value, 2);
		
		return $value_formated;
	}
	
}

?>