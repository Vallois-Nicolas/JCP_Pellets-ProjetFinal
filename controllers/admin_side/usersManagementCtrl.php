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