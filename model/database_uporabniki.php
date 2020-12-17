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

    public static function insert($ime, $priimek, $email, $geslo, $tip, $status) {                
        $db = DBInit::getInstance();

        $pass = password_hash($geslo, PASSWORD_BCRYPT);
        
        $statement = $db->prepare("INSERT into uporabniki (ime, priimek, email, geslo, tip, status) values (?, ?, ?, ?, ?, ?);");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $priimek);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $pass);
        $statement->bindParam(5, $tip);
        $statement->bindParam(6, $status);

        $statement->execute();

        return $db->lastInsertId();
    }
    
    public static function edit($id, $ime, $priimek, $email, $geslo, $tip, $status) {
        
        $db = DBInit::getInstance();
        
        $pass = password_hash($geslo, PASSWORD_BCRYPT);
        
        $statement = $db->prepare("update uporabniki set ime=?, priimek=?, email=?, geslo=?, tip=?, status=? where id=$id");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $priimek);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $pass);
        $statement->bindParam(5, $tip);
        $statement->bindParam(6, $status);

        return $statement->execute();

    }
    
}

