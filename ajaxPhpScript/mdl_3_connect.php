<?php
include '../includes/connect.php';

if ($_POST['identifiant'] && $_POST['mdp']) {
	$identifiant = $_POST['identifiant'];
	$mdp =  $_POST['mdp'];

	$req = "SELECT ID, type_compte FROM bibli_users WHERE identifiant = '".$identifiant."' AND mdp = '".$mdp."';";
	$result_connect = $connection->query($req);
	$count_connect = $result_connect->rowCount();

	// SI l'utilisateur est reconnu
	if ($count_connect!=0) {
		$arrayConnect = $result_connect->fetchAll()[0];
		$id_user = $arrayConnect['ID'];
		
		$response["type"] = $arrayConnect['type_compte'];
		$response["identifiant"] = $identifiant;
		$response["reslt"] = "success";
		
		if ($response["type"]=='lecteur') {
			// requete récupérant les livres empruntés par le lecteur connecté
			$req = "SELECT livre from bibli_bibliotheque LEFT JOIN bibli_emprunt ON bibli_bibliotheque.ID = bibli_emprunt.ID_bibli WHERE ID_lecteur = ".$id_user.";";
			$result_emprunt = $connection->query($req)->fetchAll();
			$response["emprunt_lecteur"] = $result_emprunt;
		} elseif ($response["type"]=='bibliothécaire') {
			// requete récupérant la liste des livres non empruntés
			$req = "SELECT livre, ID FROM bibli_bibliotheque LEFT JOIN bibli_emprunt on ID=ID_bibli WHERE ID_bibli IS NULL;";
			$result_bibli = $connection->query($req)->fetchAll();
			// requete récupérant les livres empruntés et leur emprunteur
			$req = "SELECT livre, identifiant, ID_bibli from bibli_users LEFT JOIN bibli_emprunt ON bibli_users.ID = bibli_emprunt.ID_lecteur LEFT JOIN bibli_bibliotheque on bibli_emprunt.ID_bibli = bibli_bibliotheque.ID WHERE livre is not null ORDER BY livre;";
			$result_emprunt = $connection->query($req)->fetchAll();
			// Requete récupérant tous les lecteurs
			$req = "SELECT identifiant, ID FROM bibli_users WHERE type_compte = 'lecteur';";
			$result_lecteur = $connection->query($req)->fetchAll();

			$response["bibliotheque"] = $result_bibli;
			$response["emprunt"] = $result_emprunt;
			$response["lecteur"] = $result_lecteur;
		}

	} else {
		$response["reslt"] = "notFind";
	}
	echo json_encode($response);
}
?>