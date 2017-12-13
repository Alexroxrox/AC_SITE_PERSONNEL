<?php
include '../includes/connect.php';
$response = array();

if($_POST['lecteur'] && $_POST['mdp']) {
	$lecteur = $_POST['lecteur'];
	$mdp = $_POST['mdp'];

	// Vérification si l'utilisateur n'éxiste pas
	$req = "SELECT ID FROM bibli_users WHERE identifiant = '".$lecteur."';";
	$result_exist = $connection->query($req);
	$count_exist = $result_exist->rowCount();

	if ($count_exist == 0) {
		$req = "INSERT INTO bibli_users (identifiant, mdp, type_compte) VALUES ('".$lecteur."', '".$mdp."', 'lecteur');";

		try {
			$insert = $connection->exec($req);
		} catch (Exception $e) {
			$insert = false;
		}

		if ($insert == true) {
			$id_lecteur = $connection->lastInsertId();

			$response["id_lecteur"] = $id_lecteur;
			$response["lecteur"] = $lecteur;
			$response["reslt"] = "success";
		} else {
			$response["reslt"] = "error";
		}
	} else {
		$response["reslt"] = "exist";
	}
	echo json_encode($response);
}
?>