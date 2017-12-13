<?php
///////////////////////////////////////
//Connexion à la base de donnée du site
//////////////////////////////////////
$connection = null;
$hostname = "localhost";
$db_name_main = "ac_site_web";
$username = "root";
$password = "root1811";
// Obligatoire pour "LOAD DATA LOCAL INFILE"
$option = array(PDO::MYSQL_ATTR_LOCAL_INFILE => true);

try {
	// Connexion au serveur "scat_connect"
	$connection = new PDO("mysql:host=$hostname;dbname=$db_name_main", $username, $password, $option);
	$connection->query("SET NAMES 'UTF8'");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
} catch(PDOException $e) {
	echo $e->getMessage();
}
?>