<?php
if ($_POST["birth"]) {
	$dateBirth = $_POST["birth"];
	$dateBirth = str_replace("/", "-", $dateBirth);
	$dateBirth = new DateTime($dateBirth);

	$jourBirth = $dateBirth->format("d");
	$moisBirth = $dateBirth->format("m");
	$anneeBirth = $dateBirth->format("Y");

	$today = new DateTime();
	$annee = $today->format("Y");

	$birthday = new DateTime($jourBirth."-".$moisBirth."-".$annee);
	if ($birthday < $today) {
		$anneeBirthDay = strval(intval($annee)+1);
		$birthday = new DateTime($jourBirth."-".$moisBirth."-".$anneeBirthDay);
	} else {
		$anneeBirthDay = $annee;
	}

	$interval = $today->diff($birthday);
	$jour_restant = $interval->format("%a");
	$jour_restant = strval(intval($jour_restant)+1);

	$age = strval(intval($anneeBirthDay) - intval($anneeBirth));

	if($jour_restant=="365") {
		$jour_restant="0";
		$age = strval(intval($age)-1);
	}
	$result = array();
	$result["jour_rest"] = $jour_restant;
	$result["age"] = $age;

	echo json_encode($result);
}
?>