<?php
include '../includes/connect.php';

if ($_POST["id_lecteur"]) {
	$id_lecteur = $_POST["id_lecteur"];

	// Vérification si le lecteur a des livres empruntés
	$req = "SELECT ID_bibli FROM bibli_emprunt WHERE ID_LECTEUR=".$id_lecteur.";";
	$result_exist = $connection->query($req);
	$count_exist = $result_exist->rowCount();

	if ($count_exist == 0) {
		$req = "DELETE FROM bibli_users WHERE ID = ".$id_lecteur.";";

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
	} else {
		echo "emprunt";
	}
}