<?php

/**
 * Description of Rights
 * Classe permettant la manipulation des données de la table jcp_user_types
 * @author majorduky
 */
class Rights extends Database{
    public $id;
    public $rights;
    public $id_jcp_users;
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * addRights permet l'insertion de droits pour un utilisateur sur une clé étrangère reliant cette table à la table jcp_users
     * Les droits utilisateurs sont définis par défaut sur 'user', donc inutile dans la requète de renseigner une valeur pour la colonne rights
     * Cette méthode doit être absolument appelée APRÈS l'insertion d'un utilisateur dans la table users.
     * @return boolean
     */
    public function addRights(){
        $query = 'INSERT INTO `jcp_user_types`(id_jcp_users) VALUES (:id_jcp_users)';
        $addRights = $this->db->prepare($query);
        $addRights->bindValue(':id_jcp_users', $this->id_jcp_users, PDO::PARAM_INT);
        if($addRights->execute()){
            return true;
        }
    }
    
    /**
     * deleteRights permet la suppression des droits d'un utilisateur sur la valeur de la clé étrangère reliant cette table à la table jcp_users
     * Cette méthode doit absolument être appelée AVANT la suppression d'un utilisateur dans la table users puisque la suppression d'une valeur de la table mère nécessite la suppression de toutes les tables où apparaît sa clé étrangère
     * @return boolean
     */
    public function deleteRights(){
        $query = 'DELETE FROM `jcp_user_types` WHERE `id_jcp_users` = :id';
        $deleteRights = $this->db->prepare($query);
        $deleteRights->bindValue(':id', $this->id_jcp_users, PDO::PARAM_INT);
        if($deleteRights->execute()){
            return true;
        }
    }
    
    /**
     * updateRightsAdminSide permet la modification des droits d'un utilisateur depuis la partie administrateur du site sur la valeur de la clé étrangère reliant cette table à la table jcp_users
     * @return boolean
     */
    public function updateRightsAdminSide(){
        $query = 'UPDATE `jcp_user_types` SET `rights` = :rights WHERE `id_jcp_users` = :id_jcp_users';
        $update = $this->db->prepare($query);
        $update->bindValue(':rights', $this->rights, PDO::PARAM_STR);
        $update->bindValue(':id_jcp_users', $this->id_jcp_users, PDO::PARAM_INT);
        if($update->execute()){
            return true;
        }
    }
}
