<?php 

session_start();
require_once "config.php";
include_once "connection.php";

$query = "DELETE FROM borrowing WHERE id='{$_POST['rowId']}'";

mysqli_query($link, $query);

?>