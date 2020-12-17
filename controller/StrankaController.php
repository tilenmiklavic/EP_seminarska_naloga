<?php

require_once("model/database_artikli.php");
require_once("model/database_narocila.php");
require_once("model/database_podrobnosti_narocila.php");
require_once("model/database_uporabniki.php");
require_once("model/database_artikli.php");
require_once("ViewHelper.php");


class StrankaController {

    public static function kosarica() {

        $id_uporabnika = $_SESSION["uporabnik_id"];
        $narocilo = NarocilaDB::getByUporabnikID($id_uporabnika, "kosarica");
        $artikli = [];

        if ($narocilo) {
            $artikli = PodrobnostiNarocilaDB::vsebinaKosarice($narocilo["id"]);
        }

        $skupna_cena = 0;

        foreach ($artikli as $artikel) {
            $skupna_cena += $artikel["cena"] * $artikel["kolicina"];
        }

        echo ViewHelper::render("view/stranka_kosarica.php", [
            "artikli" => $artikli,
            "skupna_cena" => $skupna_cena
        ]);
    }

    public static function dodajArtikelVKosarico() {

        // iz seje dobimo uporabnikov id in ga poklicemo iz baze
        $id = $_SESSION["uporabnik_id"];
        $uporabnik = UporabnikiDB::get($id);

        $id_artikla = $_POST["id"];
        $status = "kosarica";

        // ce narocilo ze obstaja mu samo povecamo kolicino 
        // drugace narocilo ustvarimo
        $narocilo = NarocilaDB::getByUporabnikId($id, $status);

        if (!$narocilo) {

            $id_narocila = NarocilaDB::insert($id, $status);
            PodrobnostiNarocilaDB::insert($id_artikla, 1, $id_narocila);

        } else {

            $podrobnost_narocila = PodrobnostiNarocilaDB::getByNarociloAndArtikel($narocilo["id"], $id_artikla);

            if (!$podrobnost_narocila) {
                PodrobnostiNarocilaDB::insert($id_artikla, 1, $narocilo["id"]);
            } else {
                PodrobnostiNarocilaDB::edit($id_artikla, $podrobnost_narocila["kolicina"] + 1, $narocilo["id"]); 
            }            
        }

        echo ViewHelper::redirect(BASE_URL);

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
