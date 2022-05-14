<?php
if(!(isset($_SESSION['role']) && $_SESSION['role'] == 3)) {
    header('Location: 403.php');
}