<?php
// Si la variable de session rights n'est pas présente ou si elle est présente mais sa valeur est différente de 'admin'
if(!isset($_SESSION['rights']) || $_SESSION['rights'] != 'admin'){
    // je redirige sur la page index
    header('Location: ../../index.php');
}

// J'ai besoin dans ce controller des models me permettant de modifier edt d'affichier les informations d'un utilisateur côté admin
require '../../models/Database.php';
require '../../models/Users.php';
require '../../models/Rights.php';

// J'instancie ma classe Users dans une variable $user, celle-ci devient donc un objet
$user = new Users();
// J'instancie ma class Rights dans une variable $rights, celle-ci devient donc un objet
$rights = new Rights();
// Je stocke dans une nouvelle variable le résultat de l'application de ma méthode listUser sur mon objet $user
$listUsers = $user->listUser();

// Je crée un tableau $errors servant à renvoyer une erreur si l'administrateur commet une erreur lors de la modification
$errors = [];

// Si un paramètre modifyId est présent dans le tableau GET,
if(isset($_GET['modifyId'])){
    // j'hydrate l'attribut id de mon objet $user avec la valeur du paramètre modifyId protégée des injections de script avec la méthode php htmlspecialchars
    $user->id = htmlspecialchars($_GET['modifyId']);
    // je stocke dans une nouvelle variable $infoUser les résultats de l'application de la méthode infoUserAdminSide sur mon objet $user, cette méthode me permet d'accéder à toutes les informations de l'utilisateur y compris son rôle depuis la table rights, et donc de les affciher directement dans le formulaire de modification
    $infoUser = $user->infoUserAdminSide();
    
    // Si le tableau POST contient des valeurs,
    if(COUNT($_POST) > 0){
    
        // je stocke le contenu de ces valeurs dans de nouvelles variables, tout en les protégeant d'injection de script grâce à la méthode php htmlspecialchars
        $lastname = htmlspecialchars($_POST['lastname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $phone = htmlspecialchars($_POST['phone']);
        $mail = htmlspecialchars($_POST['mail']);
        $rightsType = htmlspecialchars($_POST['rights']);
    
        // Je crée et stocke mes regex qui me serviront à tester les données envoyées par l'administrateur
        $regexText = '#^[a-zéèàëäâê._\- ]{2,}$#i';
        $regexDate = '#^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$#';
        $regexPhone = '#^[0-9]{10,15}$#';
        
        
        // Je teste toutes les valeurs avec mes regex et un filter var pour le mail, si les résultats ne correspondent pas, je renvoie une erreur pour chaque cas
        if(!preg_match($regexText, $lastname)){
            $errors[] = 'Veuillez renseigner correctement le nouveau nom';
        }else if(!preg_match($regexText, $firstname)){
            $errors[] = 'Veuillez renseigner correctement le nouveau prénom';
        }else if(!preg_match_all($regexDate, $birthdate)){
            $errors[] = 'Veuillez renseigner correctement la nouvelle date de naissance';
        }else if(!preg_match($regexPhone, $phone)){
            $errors[] = 'Veuillez renseigner correctement le nouveau numéro de téléphone';
        }else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Veuillez renseigner correctement la nouvelle adresse mail';
        }else{
            
            // Si tous mes tests sont passés, j'hydrate l'attribut mail de mon objet $user avec le contenu de la variable récupérée plus tôt
            $user->mail = $mail;
            // Puis j'effectue un filtrage sur ce mail en stockant dans une nouvelle variable $userMailFilter le résultat de l'application de ma méthode filterByMail sur l'objet $user
            $userMailFilter = $user->filterByMail();
            
            // Si $userMailFilter contient au moins 1 résultat et si l'id du résultat en question différe de l'id de l'utilisateur en cours de modification, 
            if(COUNT($userMailFilter) > 0 && $userMailFilter[0]->id != $user->id){
                // c'est que la nouvelle adresse mail est déjà utilisée par un autre utilisateur, je renvoie donc une erreur dans le tableau $errors
                $errors[] = 'Cette adresse mail semble être déjà utilisée !';
            }else{
                
                // Si l'adresse mail n'est pas déjà utilisée par une autre personne, j'hydrate la majorité des attributs de mon objet $user avec le contenu des variables initialisées plus tôt
                $user->lastname = $lastname;
                $user->firstname = $firstname;
                $user->birthdate = $birthdate;
                $user->phone = $phone;
                $user->mail = $mail;
                
                // Je fais de même en hydratant l'attribut rights de mon objet $rights avec le contenu de la variable initialisée plus tôt
                $rights->rights = $rightsType;
                // ainsi que l'attribut id_jcp_users du même objet avec l'id qui a été envoyé dans le tableau GET
                $rights->id_jcp_users = htmlspecialchars($_GET['modifyId']);
                
                // Si l'application de ma méthode updateProfileAdminSide, me permettant de modifier les informations d'un utilisateur, sur mon objet $user renvoie true,
                if($user->updateProfileAdminSide()){
                    // Et si l'application de ma méthode updateRightsAdminSide, me permettant de modifier les droits d'un utilisateur, sur mon objet $rights renvoie true,
                    if($rights->updateRightsAdminSide()){
                        // je redirige sur la page de gestion des utilisateurs
                        header('Location: usersManagement.php');
                    }
                }
            }
        }
}
}

// Si une valeur deleteId est présent dans le tableau GET,
if(isset($_GET['deleteId'])){
    // j'hydrate l'attribut id de mon objet $user avec la valeur du deleteId présent dans le tableau GET
    $user->id = $_GET['deleteId'];
    // ainsi que l'attribut id_jcp_users avec cette même valeur
    $rights->id_jcp_users = $_GET['deleteId'];
    // Si l'application de ma méthode deleteRights, me permettant de supprimer les droits d'un utilisateur, sur mon objet $rights renvoie true,
    if($rights->deleteRights()){
        // Et si l'application de ma méthode deleteUser, me permettant de supprimer un utilisateur, sur mon objet $user renvoie true,
        if($user->deleteUser()){
            // Je redirige sur la page de gestion des utilisateurs
            header('Location: usersManagement.php');
        }
    }
}