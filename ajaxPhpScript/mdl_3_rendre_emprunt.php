<?php
include '../includes/connect.php';

if($_POST['id_livre']) {
	$id_livre = $_POST['id_livre'];

	$req = 'DELETE FROM bibli_emprunt WHERE ID_bibli='.$id_livre.';';

	try {
		$delete = $connection->exec($req);
	} catch (Exception $e) {
		$delete = false;
	}

	$response = array();
	if ($delete == true) {
		$req = "SELECT livre FROM bibli_bibliotheque WHERE ID =".$id_livre;
		$livre = $connection->query($req)->fetch()[0];

		$response["id_livre"] = $id_livre;
		$response["livre"] = $livre;
		$response["reslt"] = "success";
	} else {
		$response["reslt"] = "error";
	}
	echo json_encode($response);
}
?>