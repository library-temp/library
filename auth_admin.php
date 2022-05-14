<?php
if(!(isset($_SESSION['role']) && $_SESSION['role'] == 1)) {
    header('Location: 403.php');
}