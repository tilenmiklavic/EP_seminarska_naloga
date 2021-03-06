<?php

require_once("model/database_artikli.php");
require_once("controller/TrgovinaController.php");
require_once("ViewHelper.php");

class TrgovinaRESTController {

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(ArtikliDB::get($id));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];

        
        $data = ArtikliDB::getAllwithURI(["prefix" => $prefix]);

        
        $data2 = ViewHelper::renderJSON($data);
        echo($data2);
    }

    public static function add() {
        $data = filter_input_array(INPUT_POST, TrgovinaController::getRules());
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);

        $temp = file_get_contents("php://input");
        $tmp = json_decode($temp);

        echo($tmp[0]);

        if (TrgovinaController::checkValues($data)) {
            $id = ArtikliDB::insert($data);
            echo ViewHelper::renderJSON("", 201);
            ViewHelper::redirect(BASE_URL . "api/artikli/$id");
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function edit($id) {
        // spremenljivka $_PUT ne obstaja, zato jo moremo narediti sami
        $_PUT = [];
        parse_str(file_get_contents("php://input"), $_PUT);
        $data = filter_var_array($_PUT, TrgovinaController::getRules());

        if ($_PUT.cena == 100) {
            echo(ViewHelper::renderJSON($_PUT, 200));   
        }
        if (TrgovinaController::checkValues($data)) {
            $data["id"] = $id;
            ArtikliDB::update($data);
            echo ViewHelper::renderJSON("", 200);
        } else {
            echo ViewHelper::renderJSON("Missing data.", 400);
        }
    }

    public static function delete($id) {
        // TODO: Implementiraj delete
        // Vrni kodo 204 v primeru uspeha oz. kodo 404, če knjiga ne obstaja
        // https://www.restapitutorial.com/httpstatuscodes.html
             
        try {
            echo ViewHelper::renderJSON(ArtikliDB::delete($id), 204);
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }
    
}
