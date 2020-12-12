<?php

// enables sessions for the entire app
session_start();

require_once("controller/TrgovinaController.php");
require_once("controller/UporabnikiController.php");
require_once("controller/TrgovinaRESTController.php");

define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/slike/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

error_log("Zacetek indexa");

$urls = [
    "/^artikli$/" => function ($method) {
        TrgovinaController::index();
    },
    "/^artikli\/(\d+)$/" => function ($method, $id) {
        TrgovinaController::get($id);
    },
    "/^artikli\/add$/" => function ($method) {
        if ($method == "POST") {
            TrgovinaController::add();
        } else {
            TrgovinaController::addForm();
        }
    },
    "/^artikli\/edit\/(\d+)$/" => function ($method, $id) {
        if ($method == "POST") {
            TrgovinaController::edit($id);
        } else {
            TrgovinaController::editForm($id);
        }
    },
    "/^artikli\/delete\/(\d+)$/" => function ($method, $id) {
        if ($method == "POST") {
            TrgovinaController::delete($id);
        }
    },

    /*
    ========================================
    URL-ji za uporabnika
    ========================================
    */
    "/^prijava$/" => function ($method) {
        if ($method == "POST") {
            UporabnikiController::prijaviUporabnika();
        } else {
            UporabnikiController::prijava();
        }
    }, 
    "/^registracija$/" => function ($method) {
        if ($method == "POST") {
            UporabnikiController::kreirajUporabnika();
        } else {
            UporabnikiController::registracija();
        }
    },

    "/^$/" => function () {
        // univerzalna funckcija 
        // ce noven URL ne prime 
        ViewHelper::redirect(BASE_URL . "artikli/");
    },

    # REST API
    "/^api\/artikli\/(\d+)$/" => function ($method, $id) {
        // TODO: izbris knjige z uporabo HTTP metode DELETE
        switch ($method) {
            case "PUT":
                TrgovinaRESTController::edit($id);
                break;
            case "DELETE":
                TrgovinaRESTController::delete($id);
                break;
            default: # GET
                TrgovinaRESTController::get($id);
                break;
        }
    },
    "/^api\/artikli$/" => function ($method) {
        switch ($method) {
            case "POST":
                TrgovinaRESTController::add();
                break;
            default: # GET
                TrgovinaRESTController::index();
                break;
        }
    },
];

    
foreach ($urls as $pattern => $controller) {
    if (preg_match($pattern, $path, $params)) {
        error_log("Nekaj se je metchalo");
        try {
            $params[0] = $_SERVER["REQUEST_METHOD"];
            $controller(...$params);
        } catch (InvalidArgumentException $e) {
            error_log("Error 404 je tole");
            ViewHelper::error404();
        } catch (Exception $e) {
            error_log("Nek drug error");
            ViewHelper::displayError($e, true);
        }

        exit();
    }     
}

error_log("Dispaly errro");
ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);
