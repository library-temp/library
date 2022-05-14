<?php
$conf = include('config.php');

$hostname = $conf['hostname'];
$username = $conf['username'];
$password = $conf['password'];
$database = $conf['database'];

$link = mysqli_connect($hostname, $username, $password, $database);

if (!$link) {
    die("Failed to establish connection");
}