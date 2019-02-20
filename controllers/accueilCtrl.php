<?php

// Si un paramètre disconnect est présent dans l'URL
if(isset($_GET['disconnect'])){
    // Je détruis la session actuelle de l'utilisateur, et donc ses variables de session
    session_destroy();
    // Puis je redirige sur un index ne possédant aucun paramètre afin de garder une URL 'belle à voir'
    header('Location: index.php');
}

// Si un parramètre deleteAccount est présent dans l'URL
if(isset($_GET['deleteAccount'])){
    // J'appelle mes différents models impliqués dans la suppression d'un compte
    require 'models/Database.php';
    require 'models/Users.php';
    require 'models/Rights.php';
    // J'instancie ma classe Users dans une variable $user, celle-ci devient donc un objet
    $user = new Users();
    // Je fais de même avec ma classe Rights dans une variable $userRights
    $userRights = new Rights();
    // J'hydrate l'attribut id de mon objet $user avec le contenu de la variable de session 'id' encore présente à ce moment
    $user->id = $_SESSION['id'];
    // J'hydrate également l'attribut id_jcp_users de mon objet $userRights avec la même variable de session car il s'agit d'une clé étrangère
    $userRights->id_jcp_users = $_SESSION['id'];
    // J'applique à mon objet $userRights la méthode deleteRights qui me permet de supprimer les droits d'un utiisateur, si deleteRights renvoie true,
    if($userRights->deleteRights()){
        // j'applique ma méthode deleteUser à mon objet $user qui me permet de supprimer un utilisateur, si deleteUser renvoie true,
        if($user->deleteUser()){
            // je détruis la session alors active
            session_destroy();
            // et je redirige sur ma page index.
            header('Location: index.php');
        }
    }
}

// Si l'utilisateur qui se connecte est reconnu en tant qu'administrateur du site,
if(isset($_SESSION['rights']) && $_SESSION['rights'] == 'admin'){
    // je le redirige vers la page de maintenance du site, accessible uniquement aux administrateurs.
    header('Location: views/admin_side/accueilAdmin.php');
}