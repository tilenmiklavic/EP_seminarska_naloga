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

        $statement = $db->prepare("SELECT * FROM uporabniki WHERE email=? AND status='active'");
        $statement->bindParam(1, $email);
        $statement->execute();

        $uporabnik = $statement->fetch();
        
        if($uporabnik){
            if ($uporabnik["status"] == "active"){
                if ($uporabnik["tip"] != "stranka"){
                    $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
                    $cert = openssl_x509_parse($client_cert);
                    if (password_verify($geslo, $uporabnik["geslo"]) && $cert["subject"]["emailAddress"] === $email){
                        return $uporabnik;
                    }
                    else {
                        return null;
                    }
                }
                else if (password_verify($geslo, $uporabnik["geslo"])) {
                    return $uporabnik;
                }
                else {
                    return null;
                }
            }
             else {
                return null;
            }
        }
        else {
            return null;
        }
    }

    public static function insert($ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka) {                
        $db = DBInit::getInstance();

        $ime = htmlspecialchars($ime);
        $priimek = htmlspecialchars($priimek);
        $email = htmlspecialchars($email);
        $geslo = htmlspecialchars($geslo);
        $tip = htmlspecialchars($tip);
        $status = htmlspecialchars($status);
        $ulica = htmlspecialchars($ulica);
        $hisna_stevilka = htmlspecialchars($hisna_stevilka);
        $posta = htmlspecialchars($posta);
        $postna_stevilka = htmlspecialchars($postna_stevilka);


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

        $ime = htmlspecialchars($ime);
        $priimek = htmlspecialchars($priimek);
        $email = htmlspecialchars($email);
        $geslo = htmlspecialchars($geslo);
        $tip = htmlspecialchars($tip);
        $status = htmlspecialchars($status);
        $ulica = htmlspecialchars($ulica);
        $hisna_stevilka = htmlspecialchars($hisna_stevilka);
        $posta = htmlspecialchars($posta);
        $postna_stevilka = htmlspecialchars($postna_stevilka);
        
        $pass = password_hash($geslo, PASSWORD_BCRYPT);
        
        $statement = $db->prepare("update uporabniki set ime=?, priimek=?, email=?, geslo=?, tip=?, status=?, ulica=?, hisna_stevilka=?, posta=?, postna_stevilka=? where id=?");
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
        $statement->bindParam(11, $id);



        return $statement->execute();

    }
    
}

