<?php
include '../includes/connect.php';

if ($_POST["idTodo"]) {
	$id_todo = $_POST["idTodo"];

	$req_todo = "DELETE FROM todo_list WHERE ID = ".$id_todo.";";

	try {
		$delete = $connection->exec($req_todo);
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