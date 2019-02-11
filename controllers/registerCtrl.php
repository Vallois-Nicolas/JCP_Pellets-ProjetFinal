<?php
require '../models/Database.php';
require '../models/Users.php';
require '../models/Rights.php';
$user = new Users();
$rights = new Rights();
$errors = [];

if(COUNT($_POST) > 0){
    
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $phone = htmlspecialchars($_POST['phone']);
    $mail = htmlspecialchars($_POST['mail']);
    $username = htmlspecialchars($_POST['username']);
    
    if(!preg_match_all('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$#', $_POST['password'])){
        $errors[] = 'Veuillez utiliser un mot de passe conforme aux instructions.';
    
    }else{
        
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $passwordVerify = $_POST['verifyPassword'];
        
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
        }else if(!password_verify($passwordVerify, $password)){
            $errors[] = 'Veuillez renseigner les deux champs mot de passe à l\'identique';
        }else{
            
            $user->lastname = $lastname;
            $user->firstname = $firstname;
            $user->birthdate = $birthdate;
            $user->phone = $phone;
            $user->mail = $mail;
            $user->username = $username;
            $user->password = $password;
            
            $filterMail = $user->filterByMail();
            $filterUsername = $user->filterByUsername();
            
            if(COUNT($filterMail) > 0){
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            }else if(COUNT($filterUsername) > 0){
                $errors[] = 'Ce nom d\'utilisateur est déjà pris !';
            }else{
                if($user->addUser()){
                $username = $user->filterByUsername();
                foreach ($username as $userId){
                    $rights->id_jcp_users = $userId->id;
                    if($rights->addRights()){
                        $success = [];
                        $success[] = 'Vous êtes bien inscrit ! Merci de votre confiance !';
                    }
                }
                }
            }
        }
    }
}