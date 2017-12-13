<?php
include '../includes/connect.php';

if ($_POST["idTodo"] && $_POST["libTodo"]) {
	$id_todo = $_POST["idTodo"];
	$lib_todo = $_POST["libTodo"];

	$req_todo = "UPDATE todo_list SET list = '".$lib_todo."' WHERE ID = ".$id_todo.";";

	try {
		$update = $connection->exec($req_todo);
	} catch (Exception $e) {
		$update = false;
	}

	$response = array();
	if ($update == true) {
		$id = $connection->lastInsertId();
		$response["reslt"] = "success";
		$response["lib_todo"] = $lib_todo;
	} else {
		$response["reslt"] = "noChange";
	}
	echo json_encode($response);
}
?>