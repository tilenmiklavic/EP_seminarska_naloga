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

        $statement = $db->prepare("DELETE FROM podrobnosti_narocila WHERE id_podrobnosti_narocila=$id");
        return $statement->execute();
    }

    public static function get($id) {     
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM podrobnosti_narocila WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function getByNarociloAndArtikel($id_narocila, $id_artikla) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM podrobnosti_narocila WHERE id_artikla=? AND narocila_id=?");
        $statement->bindParam(1, $id_artikla);
        $statement->bindParam(2, $id_narocila);
        $statement->execute();
        
        return $statement->fetch();
    }

    public static function getByNarocilo($id_narocila) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT * FROM podrobnosti_narocila WHERE narocila_id=?");
        $statement->bindParam(1, $id_narocila);
        $statement->execute();
        
        return $statement->fetchAll();
    }

    public static function vsebinaKosarice($id_narocila) {
        $db = DBInit::getInstance();
        
        $statement = $db->prepare("SELECT podrobnosti_narocila.id_artikla, podrobnosti_narocila.kolicina, artikli.cena, artikli.ime, artikli.naslov_slike FROM podrobnosti_narocila, artikli WHERE narocila_id=? AND podrobnosti_narocila.id_artikla=artikli.id");
        $statement->bindParam(1, $id_narocila);
        $statement->execute();
        
        return $statement->fetchAll();
    }

    public static function insert($id_artikla, $kolicina, $narocila_id) {                
        $db = DBInit::getInstance();

        $id_artikla = htmlspecialchars($id_artikla);
        $kolicina = htmlspecialchars($kolicina);
        $narocila_id = htmlspecialchars($narocila_id);
        
        $statement = $db->prepare("INSERT into podrobnosti_narocila (id_artikla, kolicina, narocila_id) values (?, ?, ?);");
        $statement->bindParam(1, $id_artikla);
        $statement->bindParam(2, $kolicina);
        $statement->bindParam(3, $narocila_id);

        $statement->execute();
    }
    
    public static function edit($id, $id_artikla, $kolicina, $narocila_id) {
        
        $db = DBInit::getInstance();

        $id_artikla = htmlspecialchars($id_artikla);
        $kolicina = htmlspecialchars($kolicina);
        $narocila_id = htmlspecialchars($narocila_id);
        
        $statement = $db->prepare("UPDATE podrobnosti_narocila set id_artikla=?, kolicina=?, narocila_id=? where id_podrobnosti_narocila=?");
        $statement->bindParam(1, $id_artikla);
        $statement->bindParam(2, $kolicina);
        $statement->bindParam(3, $narocila_id);
        $statement->bindParam(4, $id);



        return $statement->execute();

    }
    
}

