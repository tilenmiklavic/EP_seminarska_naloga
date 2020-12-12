<?php

require_once("model/database_artikli.php");
require_once("model/database_narocila.php");
require_once("model/database_podrobnosti_narocila.php");
require_once("model/database_uporabniki.php");
require_once("ViewHelper.php");

class UporabnikiController {

    public static function get($id) {
        //echo ViewHelper::render("view/book-detail.php", BookDB::get(["id" => $id]));
    }

    public static function index() {
        error_log("Kontroller trgovina");
        echo ViewHelper::render("view/anonimni_seznam_artiklov.php", [
            "artikli" => ArtikliDB::getAll()
        ]);
    }

    public static function prijava() {
        echo ViewHelper::render("view/prijava.php");
    }

    public static function registracija() {
        echo ViewHelper::render("view/registracija.php");
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
