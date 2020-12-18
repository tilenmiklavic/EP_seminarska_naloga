<?php

require_once("model/database_artikli.php");
require_once("model/database_narocila.php");
require_once("model/database_podrobnosti_narocila.php");
require_once("model/database_uporabniki.php");
require_once("ViewHelper.php");


class UporabnikiController {

    public static function prijava() {
        echo ViewHelper::render("view/prijava.php");
    }

    public static function registracija() {
        echo ViewHelper::render("view/registracija.php");
    }

    public static function prijaviUporabnika() {
        $email = $_POST["email"];
        $geslo = $_POST["password"];

        $uporabnik = UporabnikiDB::prijava($email, $geslo);

        if ($uporabnik) {
            // uporabnik se je uspesno prijavil 
            // shranimo njegov id v session 
            $_SESSION["uporabnik_id"] = $uporabnik["id"];
            echo ViewHelper::redirect(BASE_URL);
            
        } else {

            // uporabnik se ni uspesno prijavil v sistem 
            // geslo ali email sta morda napacna
            ViewHelper::redirect(BASE_URL . "prijava");
        
        }
    }

    public static function stranke() {
        echo ViewHelper::render("view/prodajalec_seznam_strank.php", [
            "stranke" => UporabnikiDB::getAllTip("stranka")
        ]);
    }

    public static function kreirajUporabnika() {
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $tip = "stranka";
        $status = "active";
        $ulica = $_POST["ulica"];
        $hisna_stevilka = $_POST["hisna_stevilka"];
        $posta = $_POST["posta"];
        $postna_stevilka = $_POST["postna_stevilka"];

        $id = UporabnikiDB::insert($ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);

        if ($id) {

            if (!isset($_SESSION["uporabnik_id"])) {
                $_SESSION["uporabnik_id"] = $id;
                echo ViewHelper::redirect(BASE_URL);
            } else {
                echo ViewHelper::redirect(BASE_URL . "stranke");
            }
            
        }  else {

            ViewHelper::redirect(BASE_URL . "registracija");

        }
    }

    public static function posodobiUporabnika() {
        $id = $_POST["id"];
        $uporabnik = UporabnikiDB::get($id);

        
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $tip = $uporabnik["tip"];
        $status = "active";
        $ulica = $_POST["ulica"];
        $hisna_stevilka = $_POST["hisna_stevilka"];
        $posta = $_POST["posta"];
        $postna_stevilka = $_POST["postna_stevilka"];

        if (!isset($_POST["aktiven"])) {
            $status = "inactive";
        }


        $id = UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);

        ViewHelper::redirect(BASE_URL . "stranke");
        
    }

    public static function posodobiProdajalca() {
        $id = $_POST["id"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $status = "active";

        if (!isset($_POST["aktiven"])) {
            $status = "inactive";
        }

        $tip = "prodajalec";

        if (UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status)) {
            ViewHelper::redirect(BASE_URL . "index");
        } else {
            echo("Napaka");
        }
    }

    public static function dodajProdajalca() {
        $email = $_POST["email"];
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $geslo = $_POST["geslo"];

        $tip = "prodajalec";
        $status = "active";
        $ulica = NULL;
        $hisna_stevilka = NULL;
        $posta = NULL;
        $postna_stevilka = NULL;

        if (UporabnikiDB::insert($ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka)) {
            ViewHelper::redirect(BASE_URL . "index");
        }
    }

    public static function nastavitve() {
        $id = $_SESSION["uporabnik_id"];
        $uporabnik = null;


        if ($id) {
            $uporabnik = UporabnikiDB::get($id);

            if ($uporabnik && $uporabnik["tip"] == "stranka") {
                echo ViewHelper::render("view/stranka_nastavitve.php", [
                    "uporabnik" => $uporabnik
                ]);
            } else if ($uporabnik && $uporabnik["tip"] == "prodajalec") {
                echo ViewHelper::render("view/prodajalec_nastavitve.php", [
                    "uporabnik" => $uporabnik
                ]);
            } else if ($uporabnik && $uporabnik["tip"] == "admin") {
                echo ViewHelper::render("view/administrator_nastavitve.php", [
                    "uporabnik" => $uporabnik
                ]);
            } else {
                // error 
            }
        } else {
            ViewHelper::redirect(BASE_URL);
        }
    }

    public static function posodobiNastavitve() {
        $id = $_SESSION["uporabnik_id"];
        $uporabnik = UporabnikiDB::get($id);

        $ime = $uporabnik["ime"];
        $priimek = $uporabnik["priimek"];
        $email = $uporabnik["email"];
        $geslo = $uporabnik["geslo"];
        $tip = $uporabnik["tip"];
        $status = $uporabnik["status"];

        if ($tip == "admin") {

            $geslo = $_POST["geslo"];

        } else {

            $ime = $_POST["ime"];
            $priimek = $_POST["priimek"];
            $email = $_POST["email"];
            $geslo = $_POST["geslo"];

        }


        UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status);

        ViewHelper::redirect(BASE_URL . "nastavitve");
    }

    public static function odjava() {
        $_SESSION["uporabnik_id"] = null;

        ViewHelper::redirect(BASE_URL);
    }


    /**
     * Returns TRUE if given $input array contains no FALSE values
     * @param type $input
     * @return type
     */
    public static function checkValues($input) {
        if (empty($input)) {
            return FALSE;
        }

        $result = TRUE;
        foreach ($input as $value) {
            $result = $result && $value != false;
        }

        return $result;
    }

    /**
     * Returns an array of filtering rules for manipulation books
     * @return type
     */
    public static function getRules() {
        return [
            'title' => FILTER_SANITIZE_SPECIAL_CHARS,
            'author' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
            'price' => FILTER_VALIDATE_FLOAT,
            'year' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [
                    'min_range' => 1800,
                    'max_range' => date("Y")
                ]
            ]
        ];
    }

}
