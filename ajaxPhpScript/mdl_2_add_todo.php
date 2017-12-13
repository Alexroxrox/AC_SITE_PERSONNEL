<?php
include '../includes/connect.php';

if ($_POST["add"]) {
	$lib_todo = $_POST["add"];

	$req_todo = "INSERT INTO todo_list (list, state) VALUES ('".$lib_todo."', 0);";

	try {
		$insert = $connection->exec($req_todo);
	} catch (Exception $e) {
		$insert = false;
	}

	$response = array();
	if ($insert == true) {
		$id = $connection->lastInsertId();
		$response["reslt"] = "success";
		$response["ID"] = $id;
		$response["liste"] = $lib_todo;
	} else {
		$response["reslt"] = "error";
	}
	echo json_encode($response);
}
?>