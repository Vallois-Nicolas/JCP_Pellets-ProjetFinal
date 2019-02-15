<?php

if(!isset($_SESSION['rights']) || $_SESSION['rights'] != 'admin'){
    header('Location: ../../index.php');
}

require '../../models/Database.php';
require '../../models/Users.php';
require '../../models/Rights.php';

$user = new Users();
$rights = new Rights();
$listUsers = $user->listUser();

$errors = [];

if(isset($_GET['modifyId'])){
    $user->id = htmlspecialchars($_GET['modifyId']);
    $infoUser = $user->infoUserAdminSide();
    

    if(COUNT($_POST) > 0){
    
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $phone = htmlspecialchars($_POST['phone']);
        $mail = htmlspecialchars($_POST['mail']);
        $rightsType = htmlspecialchars($_POST['rights']);
    
        if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $lastname)){
            $errors[] = 'Veuillez renseigner correctement le nouveau nom';
        }else if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $firstname)){
            $errors[] = 'Veuillez renseigner correctement le nouveau prénom';
        }else if(!preg_match_all('#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$#', $birthdate)){
            $errors[] = 'Veuillez renseigner correctement la nouvelle date de naissance';
        }else if(!preg_match('#^[0-9]{10,15}$#', $phone)){
            $errors[] = 'Veuillez renseigner correctement le nouveau numéro de téléphone';
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Veuillez renseigner correctement la nouvelle adresse mail';
        }else{
            
            $user->mail = $mail;
            $userMailFilter = $user->filterByMail();
            
            if(COUNT($userMailFilter) > 0 && $userMailFilter[0]->id != $user->id){
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            }else{
                
                $user->lastname = $lastname;
                $user->firstname = $firstname;
                $user->birthdate = $birthdate;
                $user->phone = $phone;
                $user->mail = $mail;
                
                $rights->rights = $rightsType;
                $rights->id_jcp_users = htmlspecialchars($_GET['modifyId']);
                
                if($user->updateProfileAdminSide()){
                    if($rights->updateRightsAdminSide()){
                        header('Location: usersManagement.php');
                    }
                }
            }
        }
}
}

if(isset($_GET['deleteId'])){
    $user->id = $_GET['deleteId'];
    $rights->id_jcp_users = $_GET['deleteId'];
    if($rights->deleteRights()){
        if($user->deleteUser()){
            header('Location: usersManagement.php');
        }
    }
}