<?php
require '../models/Database.php';
require '../models/Users.php';

$user = new Users();
$user->id = $_SESSION['id'];
$user->infoUser();
$errors = [];

if(COUNT($_POST) > 0){
    
    $lastname = htmlspecialchars($_POST['changeLastname']);
    $firstname = htmlspecialchars($_POST['changeFirstname']);
    $birthdate = htmlspecialchars($_POST['changeBirthdate']);
    $phone = htmlspecialchars($_POST['changePhone']);
    $mail = htmlspecialchars($_POST['changeMail']);
    $username = htmlspecialchars($_POST['changeUsername']);
    
    if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $lastname)){
            $errors[] = 'Veuillez renseigner correctement votre nom';
        }else if(!preg_match('#^[a-zéèàëäâê._\- ]{2,}$#i', $firstname)){
            $errors[] = 'Veuillez renseigner correctement votre prénom';
        }else if(!preg_match_all('#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$#', $birthdate)){
            $errors[] = 'Veuillez renseigner correctement votre date de naissance';
        }else if(!preg_match('#^[0-9]{10,15}$#', $phone)){
            $errors[] = 'Veuillez renseigner correctement votre numéro de téléphone';
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Veuillez renseigner correctement votre adresse mail';
        }else if(!preg_match('#^.{2,10}$#i', $username)){
            $errors[] = 'Veuillez renseigner correctement votre nom d\'utilisateur';
        }else{
            
            $user->username = $username;
            $user->mail = $mail;
            $userUsernameFilter = $user->filterByUsername();
            $userMailFilter = $user->filterByMail();
            
            if(COUNT($userUsernameFilter) > 0 && $userUsernameFilter[0]->id != $_SESSION['id']){
                $errors[] = 'Ce nom d\'utilisateur est déjà pris !';
            }else if(COUNT($userMailFilter) > 0 && $userMailFilter[0]->id != $_SESSION['id']){
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            }else{
                
                $user->lastname = $lastname;
                $user->firstname = $firstname;
                $user->birthdate = $birthdate;
                $user->phone = $phone;
                $user->mail = $mail;
                $user->username = $username;
    
                $user->updateProfile();
                
                $success = [];
                $success[] = 'Vos modifications ont bien été enregistrées !';
            }
        }
}