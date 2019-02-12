<?php
require '../../models/Database.php';
require '../../models/Users.php';
require '../../models/Rights.php';

$user = new Users();
$rights = new Rights();
$listUsers = $user->listUser();

//MODIF

if(isset($_GET['deleteId'])){
    $user->id = $_GET['deleteId'];
    $rights->id_jcp_users = $_GET['deleteId'];
    if($rights->deleteRights()){
        if($user->deleteUser()){
            header('Location: usersManagement.php');
        }
    }
}