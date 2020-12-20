<?php

// enables sessions for the entire app
session_start();

require_once("controller/TrgovinaController.php");
require_once("controller/UporabnikiController.php");
require_once("controller/TrgovinaRESTController.php");
require_once("controller/StrankaController.php");



define("BASE_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/slike/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";


$urls = [
    "/^index$/" => function ($method) {
        if ($method == "POST") {
            TrgovinaController::kreirajArtikel();
        } else {
            TrgovinaController::index();
        }
    },
    "/^artikli\/(\d+)$/" => function ($method, $id) {
        if ($method == "POST") {
            if ($_POST["do"] == "dodaj_v_kosarico") {
                StrankaController::dodajArtikelVKosarico();
            } else if ($_POST["do"] == "oceni") {
                StrankaController::dodajOceno($id);
            } else {
                TrgovinaController::edit($id);
            }
            
        } else {
            TrgovinaController::get($id);
        }
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
            //UporabnikiController::sendEmail("tilen.miklavic@gmail.com", "pass", "Tilen", "Miklavic");
        } else {
            UporabnikiController::registracija();
        }
    },
    "/^potrdi$/" => function ($method) {
        UporabnikiController::potrdiMail();
    },
    "/^registracija\/potrditev\/(\d+)$/" => function ($method, $id) {
        UporabnikiController::potrdiUporabnika($id);
    },
    "/^odjava$/" => function ($method) {
        UporabnikiController::odjava();
    },
    "/^nastavitve$/" => function ($method) {
        if ($method == "POST") {
            UporabnikiController::posodobiNastavitve();
        } else {
            UporabnikiController::nastavitve();
        }
    },
    /*
    ========================================
    URL-ji za prodajalca
    ========================================
    */
    "/^prodajalci$/" => function ($method) {
        if ($method == "POST") {
            UporabnikiController::posodobiProdajalca();
        }
    },
    "/^prodajalci\/dodaj$/" => function ($method) {
        if ($method == "POST") {
            UporabnikiController::dodajProdajalca();
        }
    },

    /*
    ========================================
    URL-ji za prodajalca
    ========================================
    */
    "/^stranke$/" => function ($method) {
        
        if ($method == "POST") {

            if (isset($_POST["id"])) {
                UporabnikiController::posodobiUporabnika();
            } else {
                UporabnikiController::kreirajUporabnika();
            }
        } else {
            UporabnikiController::stranke();
        }
        
    },
    
             
    "/^prodajalec_trenutna_narocila$/" => function ($method) {
        if ($method == "POST") {
            
            if ($_POST["do"] == "potrdi_narocilo") {
                UporabnikiController::potrdiNarocilo();
            } else if ($_POST["do"] == "preklici_narocilo") {
                UporabnikiController::prekliciNarocilo();
            }
        }
        
        else {
            UporabnikiController::trenutnaNarocila();
        }
        
        
    },
    
    "/^prodajalec_zgodovina_narocil$/" => function ($method) {
        if ($method == "POST") {
            
            if ($_POST["do"] == "storniraj_narocilo") {
                UporabnikiController::stornirajNarocilo();
            } 
        }
        
        else {
            UporabnikiController::zgodovinaNarocil();
        }
        
        
    },
                     
    
    /*
    ========================================
    URL-ji za stranko
    ========================================
    */
    "/^kosarica$/" => function ($method) {
        if ($method == "POST") {

            if ($_POST["do"] == "update_cart") {
                StrankaController::posodobiKosarico();
            } else if ($_POST["do"] == "odstrani_artikel") {
                StrankaController::odstraniArtikelIzKosarice();
            } else {
                StrankaController::dodajArtikelVKosarico();
            }
            
        } else {
            StrankaController::kosarica();
        }
    },
    
     "/^predracun$/" => function ($method) {
        if ($method == "POST") {
        
            if ($_POST["do"] == "oddaj_narocilo") {
                StrankaController::oddajNarocilo();
            }
        }
        
        else {
            StrankaController::predracun();
        }
        
    },
    
    "/^uspesno_oddano_narocilo$/" => function ($method) {

            StrankaController::uspesno_oddano_narocilo();
        
        
    },
    
    "/^zgodovina_nakupov$/" => function ($method) {

            StrankaController::zgodovina_nakupov();
        
        
    },  
    
    //REZULTATI ISKANJA //       
    "/^stranka_rezultati_iskanja$/" => function ($method) {
        if ($method == "POST") {

            if ($_POST["do"] == "isci") {
                StrankaController::rezultatiIskanjaStrankaPolno();
            }
            
        } else {
            StrankaController::rezultatiIskanjaStrankaPrazno();
        }
        
        
    }, 
    
    "/^prodajalec_rezultati_iskanja$/" => function ($method) {
        if ($method == "POST") {

            if ($_POST["do"] == "isci") {
                UporabnikiController::rezultatiIskanjaProdajalecPolno();
            }
            
        } else {
            UporabnikiController::rezultatiIskanjaProdajalecPrazno();
        }
        
        
    }, 
    
            
    "/^$/" => function () {
        // univerzalna funckcija 
        // ce noven URL ne prime 
        ViewHelper::redirect(BASE_URL . "index");
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

ViewHelper::displayError(new InvalidArgumentException("No controller matched."), true);
