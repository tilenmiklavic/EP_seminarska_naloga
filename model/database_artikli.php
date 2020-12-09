<?php

require_once 'database_init.php';

class ArtikliDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM artikli");
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
        
        $statement = $db->prepare("SELECT * FROM artikli WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function insert($opis, $status, $slike, $podrobnosti_narocila_id) {                
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT into artikli (opis, status, slike, podrobnosti_narocila_id) values (?, ?, ?, ?);");
        $statement->bindParam(1, $opis);
        $statement->bindParam(2, $status);
        $statement->bindParam(3, $slike);
        $statement->bindParam(4, $podrobnosti_narocila_id);

        $statement->execute();
    }
    
    public static function edit($id, $opis, $status, $slike, $podrobnosti_narocila_id) {
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("update artikli set opis=?, status=?, slike=?, podrobnosti_narocila_id=? where id=$id");
        $statement->bindParam(1, $opis);
        $statement->bindParam(2, $status);
        $statement->bindParam(3, $slike);
        $statement->bindParam(4, $podrobnosti_narocila_id);

        $statement->execute();

    }
    
}

