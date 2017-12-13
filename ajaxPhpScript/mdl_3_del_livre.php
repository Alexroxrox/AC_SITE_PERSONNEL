<?php
include '../includes/connect.php';

if ($_POST["id_livre"]) {
	$id_livre = $_POST["id_livre"];

	$req = "DELETE FROM bibli_bibliotheque WHERE ID = ".$id_livre.";";

	try {
		$delete = $connection->exec($req);
	} catch (Exception $e) {
		$delete = false;
	}

	$response = array();
	if ($delete == true) {
		echo "success";
	} else {
		echo "error";
	}
}