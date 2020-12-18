<?php

require_once 'database_init.php';

class ArtikliDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikli");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAllChecked() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikli WHERE active=1");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM artikli WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {     
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM artikli WHERE id = $id");
        //$statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function insert($ime, $avtor, $zalozba, $cena, $slike, $naslov_slike, $aktiven, $ocena, $stevilo_ocen) {                
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT into artikli (ime, avtor, zalozba, cena, slike, naslov_slike, active, ocena, stevilo_ocen) values (?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $avtor);
        $statement->bindParam(3, $zalozba);
        $statement->bindParam(4, $cena);
        $statement->bindParam(5, $slike);
        $statement->bindParam(6, $naslov_slike);
        $statement->bindParam(7, $aktiven);
        $statement->bindParam(8, $ocena);
        $statement->bindParam(9, $stevilo_ocen);

        $statement->execute();
        return $db->lastInsertId();
    }
    
    public static function edit($id, $ime, $avtor, $zalozba, $cena, $slike, $naslov_slike, $aktiven, $ocena, $stevilo_ocen) {
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("update artikli set ime=?, avtor=?, zalozba=?, cena=?, slike=?, naslov_slike=?, active=?, ocena=?, stevilo_ocen=? where id=$id");
        $statement->bindParam(1, $ime);
        $statement->bindParam(2, $avtor);
        $statement->bindParam(3, $zalozba);
        $statement->bindParam(4, $cena);
        $statement->bindParam(5, $slike);
        $statement->bindParam(6, $naslov_slike);
        $statement->bindParam(7, $aktiven);
        $statement->bindParam(8, $ocena);
        $statement->bindParam(9, $stevilo_ocen);



        return $statement->execute();

    }
    
}

