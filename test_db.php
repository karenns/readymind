<?php
$servername = "localhost";
$username = "sheer_quotation";
$password = "#8-TkTzTF13b";

try {
    $conn = new PDO("mysql:host=$servername;dbname=quotation_system", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>