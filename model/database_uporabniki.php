<?php

require_once 'database_init.php';

class UporabnikiDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM uporabniki");
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

    public static function insert($tip, $certifikat, $uporabnisko_ime, $geslo, $ime, $priimek, $status) {                
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT into uporabniki (tip, certifikat, uporabnisko_ime, geslo, ime, priimek, status) values (?, ?, ?, ?, ?, ?, ?);");
        $statement->bindParam(1, $tip);
        $statement->bindParam(2, $certifikat);
        $statement->bindParam(3, $uporabnisko_ime);
        $statement->bindParam(4, $geslo);
        $statement->bindParam(5, $ime);
        $statement->bindParam(6, $priimek);
        $statement->bindParam(7, $status);

        $statement->execute();
    }
    
    public static function edit($id, $tip, $certifikat, $uporabnisko_ime, $geslo, $ime, $priimek, $status) {
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("update uporabniki set tip=?, certifikat=?, uporabnisko_ime=?, geslo=?, ime=?, priimek=?, status=? where id=$id");
        $statement->bindParam(1, $tip);
        $statement->bindParam(2, $certifikat);
        $statement->bindParam(3, $uporabnisko_ime);
        $statement->bindParam(4, $geslo);
        $statement->bindParam(5, $ime);
        $statement->bindParam(6, $priimek);
        $statement->bindParam(7, $status);

        $statement->execute();

    }
    
}

