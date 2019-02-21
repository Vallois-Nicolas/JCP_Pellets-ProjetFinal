<?php

/**
 * Description of Users
 * Classe permettant la manipulation des données de la table jcp_users
 * @author majorduky
 */
class Users extends Database{
    public $id;
    public $firstname;
    public $lastname;
    public $birthdate;
    public $phone;
    public $mail;
    public $username;
    public $password;
    
    public function __construct() {
        parent::__construct();
    }    
    
    /**
     * addUser permet l'insertion d'un utilisateur en prenant en valeur lastname, firstname, birthdate, phone, mail, username et password
     * Cette méthode doit être appelée AVANT l'insertion des droits dans la table jcp_user_types puisque jcp_users est la table mère et va donc envoyer une clé étrangère
     * @return boolean
     */
    public function addUser(){
        $query = 'INSERT INTO `jcp_users`(lastname, firstname, birthdate, phone, mail, username, password) VALUES (:lastname, :firstname, :birthdate, :phone, :mail, :username, :password)';
        $addUser = $this->db->prepare($query);
        $addUser->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $addUser->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $addUser->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $addUser->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $addUser->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $addUser->bindValue(':username', $this->username, PDO::PARAM_STR);
        $addUser->bindValue(':password', $this->password, PDO::PARAM_STR);
        if($addUser->execute()){
            return true;
        }
    }
    
    /**
     * filterByUsername permet le filtrage des utilisateurs par leur username
     * Colonnes utilisables après exécution : id et username
     * @return stdClass
     */
    public function filterByUsername(){
        $query = 'SELECT `id`, `username` FROM `jcp_users` WHERE `username` = :username';
        $filter = $this->db->prepare($query);
        $filter->bindValue(':username', $this->username, PDO::PARAM_STR);
        if($filter->execute()){
            $filterResult = $filter->fetchAll(PDO::FETCH_OBJ);
            return $filterResult;
        }
    }
    
    /**
     * filterByUsername permet le filtrage des utilisateurs par leur mail
     * Colonnes utilisables après exécution : id et mail
     * @return stdClass
     */
    public function filterByMail(){
        $query = 'SELECT `id`, `mail` FROM `jcp_users` WHERE `mail` = :mail';
        $filter = $this->db->prepare($query);
        $filter->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        if($filter->execute()){
            $filterResult = $filter->fetchAll(PDO::FETCH_OBJ);
            return $filterResult;
        }
    }
    
    /**
     * selectByUsername est aussi un filtrage d'utilisateur par leur username, mais celui ci est une jointure permettant de récupérer ses droits en même temps grâce à la clé étrangère présente dans la table jcp_user_types
     * Colonnes utilisables après exécution : id, rights, ic_jcp_users, password
     * @return stdClass
     */
    public function selectByUsername(){
        $query = 'SELECT `jcp_users`.`id`, `jcp_user_types`.`rights`, `jcp_user_types`.`id_jcp_users`, `jcp_users`.`password` FROM `jcp_users` INNER JOIN `jcp_user_types` ON `jcp_users`.`id` = `jcp_user_types`.`id_jcp_users` WHERE `jcp_users`.`username` = :username';
        $select = $this->db->prepare($query);
        $select->bindValue(':username', $this->username, PDO::PARAM_STR);
        if($select->execute()){
            $selectResult = $select->fetchAll(PDO::FETCH_OBJ);
            if(COUNT($selectResult) > 0){
                $this->password = $selectResult[0]->password;
                $this->id = $selectResult[0]->id;
                sleep(1);
                return $selectResult;
            }else{
                return $selectResult;
            }
        }
    }
    
    /**
     * infoUser permet l'affichage des données de l'utilisateur sur son profil sur la valeur de son id
     * Ici pas de renvoie de stdClass car l'hydratation est réalisée dans la méthode
     * Colonnes utilisables après exécution : id, lastname, firstname, birthdate, phone, mail, username, password
     * @return boolean
     */
    public function infoUser(){
        $query = 'SELECT * FROM `jcp_users` WHERE `id` = :id';
        $info = $this->db->prepare($query);
        $info->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($info->execute()){
            $infoList = $info->fetchAll(PDO::FETCH_OBJ);
            $this->lastname = $infoList[0]->lastname;
            $this->firstname = $infoList[0]->firstname;
            $this->birthdate = $infoList[0]->birthdate;
            $this->mail = $infoList[0]->mail;
            $this->phone = $infoList[0]->phone;
            $this->username = $infoList[0]->username;
            return true;
        }
    }
    
    /**
     * infoUserAdminSide permet l'affichage des données de l'utilisateur y compris de ses droits grâce à une jointure depuis la partie admin du site sur la valeur de l'id de l'utilisateur
     * Colonnes utilisables après exécution : id, lastname, firstname, birthdate, phone, mail, username, rights
     * @return stdClass
     */
    public function infoUserAdminSide(){
        $query = 'SELECT `jcp_users`.`id`, `jcp_users`.`lastname`, `jcp_users`.`firstname`, `jcp_users`.`birthdate`, `jcp_users`.`phone`, `jcp_users`.`mail`, `jcp_users`.`username`, `jcp_user_types`.`rights` FROM `jcp_users` INNER JOIN `jcp_user_types` ON `jcp_users`.`id` = `jcp_user_types`.`id_jcp_users` WHERE `jcp_users`.`id` = :id';
        $infoAdmin = $this->db->prepare($query);
        $infoAdmin->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($infoAdmin->execute()){
            $infoListAdmin = $infoAdmin->fetchAll(PDO::FETCH_OBJ);
            $this->username = $infoListAdmin[0]->username;
            $this->lastname = $infoListAdmin[0]->lastname;
            $this->firstname = $infoListAdmin[0]->firstname;
            $this->birthdate = $infoListAdmin[0]->birthdate;
            $this->mail = $infoListAdmin[0]->mail;
            $this->phone = $infoListAdmin[0]->phone;
            return $infoListAdmin;
        }
    }
    
    /**
     * updateProfile permet la modification des données d'un utilisateur depuis son profil sur la valeur de son id
     * Modification de : lastname, firstname, birthdate, mail, phone, username
     * @return boolean
     */
    public function updateProfile(){
        $query = 'UPDATE `jcp_users` SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `mail` = :mail, `phone` = :phone, `username` = :username WHERE `id` = :id';
        $update = $this->db->prepare($query);
        $update->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $update->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $update->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $update->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $update->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $update->bindValue(':username', $this->username, PDO::PARAM_STR);
        $update->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($update->execute()){
            return true;
        }
    }
    
    /**
     * updateProfileAdminSide permet la modification des données d'un utilisateur depuis la partie admin du site sur la valeur de son id
     * Modification de : lastname, firstname, birthdate, mail, phone
     * Méthode utilisée en combinaison avec la méthode permettant de modifier les droits
     * @return boolean
     */
    public function updateProfileAdminSide(){
        $query = 'UPDATE `jcp_users` SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `mail` = :mail, `phone` = :phone WHERE `id` = :id';
        $update = $this->db->prepare($query);
        $update->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $update->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $update->bindValue(':birthdate', $this->birthdate, PDO::PARAM_STR);
        $update->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $update->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $update->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($update->execute()){
            return true;
        }
    }
    
    /**
     * deleteUser permet la suppression d'un utilisateur sur la valeur de son id
     * Cette méthode doit absolument être appelée APRÈS la suppression des droits à cause de la contrainte de la clé étrangère encore présente
     * @return boolean
     */
    public function deleteUser(){
        $query = 'DELETE FROM `jcp_users` WHERE `id` = :id';
        $delete = $this->db->prepare($query);
        $delete->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($delete->execute()){
            return true;
        }
    }
    
    /**
     * listUser permet l'affichage des données et des droits, grâce à une jointure, de tous les utilisateurs du site depuis la partie admin du site
     * Colonnes utilisables après exécution : id, lastname, firstname, birthdate, phone, mail, username, rights
     * @return stdClass
     */
    public function listUser(){
        $query = 'SELECT `jcp_users`.`id`, `jcp_users`.`lastname`, `jcp_users`.`firstname`, `jcp_users`.`birthdate`, `jcp_users`.`phone`, `jcp_users`.`mail`, `jcp_users`.`username`, `jcp_user_types`.`rights` FROM `jcp_users` INNER JOIN `jcp_user_types` ON `jcp_users`.`id` = `jcp_user_types`.`id_jcp_users`';
        $list = $this->db->query($query);
        if($list->execute()){
            $listUsers = $list->fetchAll(PDO::FETCH_OBJ);
            return $listUsers;
        }
    }
}
