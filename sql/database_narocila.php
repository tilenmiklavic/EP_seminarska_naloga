<?php

require_once 'database_init.php';

class NarocilaDB {

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT * FROM narocila");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM narocila WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function get($id) {     
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM narocila WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function insert($uporabnik_id, $status) {                
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("INSERT into narocila (uporabnik_id, status) values (?, ?);");
        $statement->bindParam(1, $uporabnik_id);
        $statement->bindParam(2, $status);


        $statement->execute();
    }
    
    public static function edit($uporabnik_id, $status) {
        
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("update narocila set uporabnik_id=?, status=? where id=$id");
        $statement->bindParam(1, $uporabnik_id);
        $statement->bindParam(2, $status);

        $statement->execute();

    }
    
}

