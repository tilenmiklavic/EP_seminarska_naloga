<?php

require_once 'database_init.php';

class PodrobnostiNarocilaDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM podrobnosti_narocila");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM podrobnosti_narocila WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {     
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM podrobnosti_narocila WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function insert($id_artikla, $kolicina, $narocila_id) {                
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT into podrobnosti_narocila (id_artikla, kolicina, narocila_id) values (?, ?, ?);");
        $statement->bindParam(1, $id_artikla);
        $statement->bindParam(2, $kolicina);
        $statement->bindParam(3, $narocila_id);

        $statement->execute();
    }
    
    public static function edit($id_artikla, $kolicina, $narocila_id) {
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("update podrobnosti_narocila set id_artikla=?, kolicina=?, narocila_id=? where id=$id");
        $statement->bindParam(1, $id_artikla);
        $statement->bindParam(2, $kolicina);
        $statement->bindParam(3, $narocila_id);


        $statement->execute();

    }
    
}

