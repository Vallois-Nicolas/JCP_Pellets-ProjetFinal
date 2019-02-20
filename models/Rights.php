<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rights
 *
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
     * 
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
     * 
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
