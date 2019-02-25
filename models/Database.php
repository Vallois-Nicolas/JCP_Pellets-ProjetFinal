<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 * Utilisée pour la connexion à la base de données grâce à PDO
 * @author majorduky
 */
class Database{ 
    protected $db;
    
    public function __construct() {
        $this->db = new PDO('mysql:dbname=dbname;host=localhost', 'username', 'psswd', [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    }
}
