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

            ViewHelper::redirect(BASE_URL . "prijava");
        
        }
    }

    public static function kreirajUporabnika() {
        $ime = $_POST["ime"];
        $priimek = $_POST["priimek"];
        $email = $_POST["email"];
        $geslo = $_POST["geslo"];
        $tip = "stranka";
        $status = "active";

        $id = UporabnikiDB::insert($ime, $priimek, $email, $geslo, $tip, $status);

        if ($id) {

            $_SESSION["uporabnik_id"] = $id;
            echo ViewHelper::redirect(BASE_URL);

        } else {

            ViewHelper::redirect(VASE_URL . "registracija");

        }
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
