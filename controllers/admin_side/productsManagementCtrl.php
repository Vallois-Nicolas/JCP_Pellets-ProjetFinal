<?php
if(!isset($_SESSION['rights']) || $_SESSION['rights'] != 'admin'){
    header('Location: ../../index.php');
}