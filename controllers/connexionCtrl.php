<?php
require '../models/Database.php';
require '../models/Users.php';
$errors = [];

if(isset($_POST['username']) && isset($_POST['password'])){
    
    $user = new Users();
    $username = htmlspecialchars($_POST['username']);
    $user->username = $username;
    if($user->connectUser()){
        
        $connectUser = $user->connectUser();
        
        if($user->password == null){
            $errors[] = 'Vous avez saisi un nom d\'utilisateur inconnu !';
        }else{
            $passwordUser = $_POST['password'];
            if(!password_verify($passwordUser, $user->password)){
                $errors[] = 'Vous avez saisi un mot de passe incorrect !';
            }else{
                $_SESSION['id'] = $user->id;
                $_SESSION['username'] = $username;
                $_SESSION['rights'] = $connectUser[0]->rights;
                header('Location: ../index.php');
            }
        }
    }
}
