<?php
include '../includes/connect.php';

if ($_POST["idTodo"]) {
	$id_todo = $_POST["idTodo"];

	$req_todo = "SELECT state FROM todo_list WHERE ID =".$id_todo.";";
	$state_todo = $connection->query($req_todo)->fetch()[0];
	$state_todo = (int)!(bool)$state_todo;

	$req_todo = "UPDATE todo_list SET state = '".$state_todo."' WHERE ID = ".$id_todo.";";

	try {
		$update = $connection->exec($req_todo);
	} catch (Exception $e) {
		$update = false;
	}

	$response = array();
	if ($update == true) {
		$id = $connection->lastInsertId();
		$response["reslt"] = "success";
		$response["state_todo"] = $state_todo;
	} else {
		$response["reslt"] = "noChange";
	}
	echo json_encode($response);
}
?>