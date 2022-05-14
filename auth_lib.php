<?php
if(!(isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
    header('Location: 403.php');
}