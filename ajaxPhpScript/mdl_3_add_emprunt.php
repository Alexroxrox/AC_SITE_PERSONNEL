<?php
include '../includes/connect.php';

if($_POST['livre'] && $_POST['lecteur']){
	$id_livre = $_POST['livre'];
	$id_lecteur = $_POST['lecteur'];

	$req = "INSERT INTO bibli_emprunt (ID_bibli, ID_lecteur) VALUES ('".$id_livre."', '".$id_lecteur."');";

	try {
		$insert = $connection->exec($req);
	} catch (Exception $e) {
		$insert = false;
	}

	$response = array();
	if ($insert == true) {
		$req = "SELECT livre FROM bibli_bibliotheque WHERE ID =".$id_livre;
		$livre = $connection->query($req)->fetch()[0];
		$req = "SELECT identifiant FROM bibli_users WHERE ID =".$id_lecteur;
		$lecteur = $connection->query($req)->fetch()[0];
		
		$response["id_livre"] = $id_livre;
		$response["livre"] = $livre;
		$response["lecteur"] = $lecteur;
		$response["reslt"] = "success";
	} else {
		$response["reslt"] = "error";
	}
	echo json_encode($response);
}
?>