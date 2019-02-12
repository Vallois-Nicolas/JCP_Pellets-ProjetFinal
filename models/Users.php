<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
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
    
    public function filterByUsername(){
        $query = 'SELECT `id`, `username` FROM `jcp_users` WHERE `username` = :username';
        $filter = $this->db->prepare($query);
        $filter->bindValue(':username', $this->username, PDO::PARAM_STR);
        if($filter->execute()){
            $filterResult = $filter->fetchAll(PDO::FETCH_OBJ);
            return $filterResult;
        }
    }
    
    public function filterByMail(){
        $query = 'SELECT `id`, `mail` FROM `jcp_users` WHERE `mail` = :mail';
        $filter = $this->db->prepare($query);
        $filter->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        if($filter->execute()){
            $filterResult = $filter->fetchAll(PDO::FETCH_OBJ);
            return $filterResult;
        }
    }
    
    public function connectUser(){
        $query = 'SELECT `jcp_users`.`id`, `jcp_user_types`.`rights`, `jcp_user_types`.`id_jcp_users`, `jcp_users`.`password` FROM `jcp_users` INNER JOIN `jcp_user_types` ON `jcp_users`.`id` = `jcp_user_types`.`id_jcp_users` WHERE `jcp_users`.`username` = :username';
        $connect = $this->db->prepare($query);
        $connect->bindValue(':username', $this->username, PDO::PARAM_STR);
        if($connect->execute()){
            $connectResult = $connect->fetchAll(PDO::FETCH_OBJ);
            $this->password = $connectResult[0]->password;
            $this->id = $connectResult[0]->id;
            return $connectResult;
        }
    }
    
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
    
    public function deleteUser(){
        $query = 'DELETE FROM `jcp_users` WHERE `id` = :id';
        $delete = $this->db->prepare($query);
        $delete->bindValue(':id', $this->id, PDO::PARAM_INT);
        if($delete->execute()){
            return true;
        }
    }
    
    public function listUser(){
        $query = 'SELECT `jcp_users`.`id`, `jcp_users`.`lastname`, `jcp_users`.`firstname`, `jcp_users`.`birthdate`, `jcp_users`.`phone`, `jcp_users`.`mail`, `jcp_users`.`username`, `jcp_user_types`.`rights` FROM `jcp_users` INNER JOIN `jcp_user_types` ON `jcp_users`.`id` = `jcp_user_types`.`id_jcp_users`';
        $list = $this->db->query($query);
        if($list->execute()){
            $listUsers = $list->fetchAll(PDO::FETCH_OBJ);
            return $listUsers;
        }
    }
}
