<?php
include '../includes/connect.php';

if($_POST['livre']) {
	$livre = $_POST['livre'];

	$req = "INSERT INTO bibli_bibliotheque (livre) VALUES ('".$livre."');";

	try {
		$insert = $connection->exec($req);
	} catch (Exception $e) {
		$insert = false;
	}

	$response = array();
	if ($insert == true) {
		$id_livre = $connection->lastInsertId();

		$response["id_livre"] = $id_livre;
		$response["livre"] = $livre;
		$response["reslt"] = "success";
	} else {
		$response["reslt"] = "error";
	}
	echo json_encode($response);
}
?>