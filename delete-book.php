<?php 

session_start();
require_once "config.php";
include_once "connection.php";

$query = "DELETE FROM book WHERE id='{$_POST['rowId']}'";

mysqli_query($link, $query);

?>