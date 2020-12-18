<?php

require_once 'database_init.php';

class UporabnikiDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM uporabniki");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllTip($tip) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM uporabniki WHERE tip=?");
        $statement->bindParam(1, $tip);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM uporabniki WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {     
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM uporabniki WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function prijava($email, $geslo) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM uporabniki WHERE email=?");
        $statement->bindParam(1, $email);
        $statement->execute();

        $uporabnik = $statement->fetch();
        
        if (password_verify($geslo, $uporabnik["geslo"])) {
            return $uporabnik;
        } else {
            return null;
        }
    }

    public static function insert($ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka) {                
        $db = DBInit::getInstance();

        $pass = password_hash($geslo, PASSWORD_BCRYPT);
        
        $statement = $db->prepare("INSERT into uporabniki (ime, priimek, email, geslo, tip, status, ulica, hisna_stevilka, posta, postna_stevilka) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $priimek);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $pass);
        $statement->bindParam(5, $tip);
        $statement->bindParam(6, $status);
        $statement->bindParam(7, $ulica);
        $statement->bindParam(8, $hisna_stevilka);
        $statement->bindParam(9, $posta);
        $statement->bindParam(10, $postna_stevilka);


        $statement->execute();

        return $db->lastInsertId();
    }
    
    public static function edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka) {
        
        $db = DBInit::getInstance();
        
        $pass = password_hash($geslo, PASSWORD_BCRYPT);
        
        $statement = $db->prepare("update uporabniki set ime=?, priimek=?, email=?, geslo=?, tip=?, status=?, ulica=?, hisna_stevilka=?, posta=?, postna_stevilka=? where id=$id");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $priimek);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $pass);
        $statement->bindParam(5, $tip);
        $statement->bindParam(6, $status);
        $statement->bindParam(7, $ulica);
        $statement->bindParam(8, $hisna_stevilka);
        $statement->bindParam(9, $posta);
        $statement->bindParam(10, $postna_stevilka);



        return $statement->execute();

    }
    
}

