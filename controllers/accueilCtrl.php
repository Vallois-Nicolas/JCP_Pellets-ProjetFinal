<?php
if(isset($_GET['disconnect'])){
    session_destroy();
    header('Location: index.php');
}
if(isset($_GET['deleteAccount'])){
    require 'models/Database.php';
    require 'models/Users.php';
    require 'models/Rights.php';
    $user = new Users();
    $userRights = new Rights();
    $user->id = $_SESSION['id'];
    $userRights->id_jcp_users = $_SESSION['id'];
    if($userRights->deleteRights()){
        if($user->deleteUser()){
            session_destroy();
            header('Location: index.php');
        }
    }
}
if(isset($_SESSION['rights']) && $_SESSION['rights'] == 'admin'){
    header('Location: views/admin_side/accueilAdmin.php');
}