<?php

require_once("model/database_artikli.php");
require_once("model/database_narocila.php");
require_once("model/database_podrobnosti_narocila.php");
require_once("model/database_uporabniki.php");
require_once("ViewHelper.php");


class TrgovinaController {

    public static function get($id) {

        $uporabnik = null;
        
        if (isset($_SESSION["uporabnik_id"])) {

            $uporabnik = UporabnikiDB::get($_SESSION["uporabnik_id"]);
        }

        if ($uporabnik && $uporabnik["tip"] == "prodajalec") {

            echo ViewHelper::render("view/prodajalec_artikel.php", [ 
                "artikel" => ArtikliDB::get($id),
                "prodajalec" => UporabnikiDB::get($_SESSION["uporabnik_id"])
            ]);

        } else if ($uporabnik && $uporabnik["tip"] == "stranka") {
            
            echo ViewHelper::render("view/stranka_artikel.php", [ 
                "artikel" => ArtikliDB::get($id),
                "stranka" => UporabnikiDB::get($_SESSION["uporabnik_id"])
            ]);

        } else {
            echo ViewHelper::render("view/anonimni_artikel.php", [ 
                "artikel" => ArtikliDB::get($id)
            ]);
        }        
    }

    public static function index() {

        $uporabnik = null;
        
        if (isset($_SESSION["uporabnik_id"])) {
            $uporabnik = UporabnikiDB::get($_SESSION["uporabnik_id"]);
        }

        if ($uporabnik && $uporabnik["tip"] == "stranka") {
            echo ViewHelper::render("view/stranka_seznam_artiklov.php", [
                "artikli" => ArtikliDB::getAllChecked(),
                "uporabnik" => $uporabnik
            ]);

        } else if ($uporabnik && $uporabnik["tip"] == "prodajalec") {

            echo ViewHelper::render("view/prodajalec_seznam_artiklov.php", [
                "artikli" => ArtikliDB::getAll(),
                "uporabnik" => $uporabnik
            ]);

        }  else if ($uporabnik && $uporabnik["tip"] == "admin") {
          
            echo ViewHelper::render("view/administrator_seznam_prodajalcev.php", [
                "prodajalci" => UporabnikiDB::getAllTip("prodajalec")
            ]);
            
        } else {
            
            echo ViewHelper::render("view/anonimni_seznam_artiklov.php", [
                "artikli" => ArtikliDB::getAllChecked()
            ]);

        }
    }

    public static function kreirajArtikel() {

        $naslov = $_POST["naslov"];
        $zalozba = $_POST["zalozba"];
        $avtor = $_POST["avtor"];
        $cena = $_POST["cena"];
        $slike = NULL;
        $naslov_slike = $_POST["naslov_slike"];
        $active = 1;
        $ocena = 5;
        $stevilo_ocen = 0;

        $id = ArtikliDB::insert($naslov, $zalozba, $avtor, $cena, $slike, $naslov_slike, $active, $ocena, $stevilo_ocen);

        if ($id) {

            // artikel uspesno dodan 
            ViewHelper::redirect(BASE_URL);

        } else {

            // prislo je do napake pri dodajanju artikla 
            ViewHelper::render("view/prodajalec_seznam_artiklov");

        }

    }

    public static function edit($id) {
        $data = filter_input_array(INPUT_POST, self::getRules());
        $artikel = ArtikliDB::get($id);

        $ime = $_POST["ime"];
        $avtor = $_POST["avtor"];
        $zalozba = $_POST["zalozba"];
        $cena = $_POST["cena"];
        $aktiven = 0;
        $slike = NULL;
        $naslov_slike = $_POST["naslov_slike"];

        $ocena = $artikel["ocena"];
        $stevilo_ocen = $artikel["stevilo_ocen"];

        if (isset($_POST["aktiven"])) {
            echo("aktiven");
            $aktiven = 1;
        }

        if (ArtikliDB::edit($id, $ime, $avtor, $zalozba, $cena, $slike, $naslov_slike, $aktiven, $ocena, $stevilo_ocen)) {
            echo ViewHelper::redirect(BASE_URL . "artikli/" . $id);

        } else {
            // primer ko se vztavljanje v bazo ne izvede
            // napaka
            echo ViewHelper::redirect(BASE_URL . "artikli/" . $id);
        }

    }

    /*
    TODO 

    public static function addForm($values = [
        "author" => "",
        "title" => "",
        "price" => "",
        "year" => "",
        "description" => ""
    ]) {
        echo ViewHelper::render("view/book-add.php", $values);
    }

    public static function add() {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $id = BookDB::insert($data);
            echo ViewHelper::redirect(BASE_URL . "books/" . $id);
        } else {
            self::addForm($data);
        }
    }

    public static function editForm($params) {
        if (is_array($params)) {
            $values = $params;
        } else if (is_numeric($params)) {
            $values = BookDB::get(["id" => $params]);
        } else {
            throw new InvalidArgumentException("Cannot show form.");
        }

        echo ViewHelper::render("view/book-edit.php", $values);
    }

    public static function edit($id) {
        $data = filter_input_array(INPUT_POST, self::getRules());

        if (self::checkValues($data)) {
            $data["id"] = $id;
            BookDB::update($data);
            ViewHelper::redirect(BASE_URL . "books/" . $data["id"]);
        } else {
            self::editForm($data);
        }
    }

    public static function delete($id) {
        $data = filter_input_array(INPUT_POST, [
            'delete_confirmation' => FILTER_REQUIRE_SCALAR
        ]);

        if (self::checkValues($data)) {
            BookDB::delete(["id" => $id]);
            $url = BASE_URL . "books";
        } else {
            $url = BASE_URL . "books/edit/" . $id;
        }

        ViewHelper::redirect($url);
    }
    */

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
