<?php

if(isset($_SESSION['role']))
{
    switch ($_SESSION["role"])
    {
        case 1:
            header('Location: admin-dashboard.php');
            break;
        case 2:
            header('Location: librarian-dashboard.php');
            break;
        case 3:
            header('Location: customer-dashboard.php');
            break;
        default:
            header('Location: homepage.php');
    }
}