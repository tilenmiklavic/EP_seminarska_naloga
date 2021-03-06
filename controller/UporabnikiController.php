<?php

require_once("model/database_artikli.php");
require_once("model/database_narocila.php");
require_once("model/database_podrobnosti_narocila.php");
require_once("model/database_uporabniki.php");
require_once("ViewHelper.php");
require_once("controller/TrgovinaController.php");

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);


class UporabnikiController {

    public static function prijava() {
        echo ViewHelper::render("view/prijava.php");
    }

    public static function registracija() {
        echo ViewHelper::render("view/registracija.php");
    }

    public static function prijaviUporabnika() {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $geslo = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

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
            "stranke" => UporabnikiDB::getAllTip("stranka"),
            "prodajalec" => UporabnikiDB::get($_SESSION["uporabnik_id"])
        ]);
    }

    public static function kreirajUporabnika() {

        $prodajalec = NULL;
        if (isset($_SESSION["uporabnik_id"])) {
            $prodajalec = UporabnikiDB::get($_SESSION["uporabnik_id"]);
        }


        $ime = filter_input(INPUT_POST, "ime", FILTER_SANITIZE_SPECIAL_CHARS);
        $priimek = filter_input(INPUT_POST, "priimek", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);
        $tip = "stranka";
        $status = "inactive";
        $ulica = filter_input(INPUT_POST, "ulica", FILTER_SANITIZE_SPECIAL_CHARS);
        $hisna_stevilka = filter_input(INPUT_POST, "hisna_stevilka", FILTER_SANITIZE_SPECIAL_CHARS);
        $posta = filter_input(INPUT_POST, "posta", FILTER_SANITIZE_SPECIAL_CHARS);
        $postna_stevilka = filter_input(INPUT_POST, "postna_stevilka", FILTER_SANITIZE_SPECIAL_CHARS);

        $captcha;
        if(isset($_POST['g-recaptcha-response'])){
            $captcha=$_POST['g-recaptcha-response'];
        }
        if(!isset($captcha)){
            echo '<h2>Please check the the captcha form.</h2>';
        }

        if ($prodajalec && $prodajalec["tip"] == "prodajalec") {
            echo "Prodajalec kreira novo stranko";
        } else {
            $secretKey = "6LdzPA0aAAAAAJmLuY8PfosAfXXlNZK0qGVevnHp";
            $ip = $_SERVER['REMOTE_ADDR'];
            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            // should return JSON with success as true
            if($responseKeys["success"]) {
                    echo '<h2>Captcha uspesno prijela, lahko nadaljujes.</h2>';
            } else {
                echo '<h2>Captcha ni prijela, verjetno si spammer</h2>';
                exit;
            }
        }


        $id = UporabnikiDB::insert($ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);
        
        if ($id) {

            if (!isset($_SESSION["uporabnik_id"])) {
                // $_SESSION["uporabnik_id"] = $id;

                ViewHelper::redirect(BASE_URL . "potrdi");
                UporabnikiController::sendEmail($email, $geslo, $ime, $priimek, $id);
                
            } else {
                //UporabnikiController::sendEmail($email, $geslo, $ime, $priimek, $id);
                echo ViewHelper::redirect(BASE_URL . "stranke");
            }
            
        }  else {

            ViewHelper::redirect(BASE_URL . "registracija");

        }
    }

    public static function sendEmail($email, $geslo, $ime, $priimek, $id) {

        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"] . '/potrditev/' . $id;

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'markus.vandersar@gmail.com';                     // SMTP username
            $mail->Password   = 'Geslo123#';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('trgovina-abc@example.com', 'Trgovina ABC');
            $mail->addAddress( $email, $ime );     // Add a recipient
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Registracija';
            $mail->Body    = 'Uspešno ste se registrirali v spletno trgovino ABC. <br>' 
                             . 'Vaši podatki so: <br> Ime: ' . $ime
                             . '<br> Priimek: ' . $priimek
                             . '<br> Email: ' . $email
                             . '<br> Geslo: ' . $geslo
                             . '<br> Za potrditev obisci povezavo: ' . $prefix;
            $mail->AltBody = 'Uspesna prijava na spletno trgovino ABC';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit;
        }
    }

    public static function potrdiMail() {
        echo ViewHelper::render("view/stranka_potrdi_mail.php");
    }

    public static function potrdiUporabnika($id) {
        $uporabnik = UporabnikiDB::get($id);

        var_dump($id);

        $ime = $uporabnik["ime"];
        $priimek = $uporabnik["priimek"];
        $email = $uporabnik["email"];
        $geslo = $uporabnik["geslo"];
        $tip = $uporabnik["tip"];
        $status = "active";
        $ulica = $uporabnik["ulica"];
        $hisna_stevilka = $uporabnik["hisna_stevilka"];
        $posta = $uporabnik["posta"];
        $postna_stevilka = $uporabnik["postna_stevilka"];

        $id = UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);

        ViewHelper::redirect(BASE_URL . "prijava");
    }

    public static function posodobiUporabnika() {
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $uporabnik = UporabnikiDB::get($id);

        
        $ime = filter_input(INPUT_POST, "ime", FILTER_SANITIZE_SPECIAL_CHARS);
        $priimek = filter_input(INPUT_POST, "priimek", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);
        $tip = $uporabnik["tip"];
        $status = "active";
        $ulica = filter_input(INPUT_POST, "ulica", FILTER_SANITIZE_SPECIAL_CHARS)| $uporabnik["ulica"];
        $hisna_stevilka = filter_input(INPUT_POST, "hisna_stevilka", FILTER_SANITIZE_SPECIAL_CHARS) | $uporabnik["hisna_stevilka"];
        $posta = filter_input(INPUT_POST, "posta", FILTER_SANITIZE_SPECIAL_CHARS) | $uporabnik["posta"];
        $postna_stevilka = filter_input(INPUT_POST, "postna_stevilka", FILTER_SANITIZE_SPECIAL_CHARS) | $uporabnik["postna_stevilka"];

        if (!isset($_POST["aktiven"])) {
            $status = "inactive";
        }


        $id = UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);

        ViewHelper::redirect(BASE_URL . "stranke");
        
    }

    public static function posodobiProdajalca() {
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);
        $ime = filter_input(INPUT_POST, "ime", FILTER_SANITIZE_SPECIAL_CHARS);
        $priimek = filter_input(INPUT_POST, "priimek", FILTER_SANITIZE_SPECIAL_CHARS);
        $status = "active";

        $ulica = NULL;
        $hisna_stevilka = 0;
        $posta = NULL;
        $postna_stevilka = 0;

        if (!isset($_POST["aktiven"])) {
            $status = "inactive";
        }

        $tip = "prodajalec";

        if (UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka)) {
            ViewHelper::redirect(BASE_URL . "index");
        } else {
            echo("Napaka");
        }
    }

    public static function dodajProdajalca() {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $ime = filter_input(INPUT_POST, "ime", FILTER_SANITIZE_SPECIAL_CHARS);
        $priimek = filter_input(INPUT_POST, "priimek", FILTER_SANITIZE_SPECIAL_CHARS);
        $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);

        $tip = "prodajalec";
        $status = "active";
        $ulica = NULL;
        $hisna_stevilka = 0;
        $posta = NULL;
        $postna_stevilka = 0;

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
                    "uporabnik" => $uporabnik,
                    "stranka" => UporabnikiDB::get($_SESSION["uporabnik_id"])
                ]);
            } else if ($uporabnik && $uporabnik["tip"] == "prodajalec") {
                echo ViewHelper::render("view/prodajalec_nastavitve.php", [
                    "uporabnik" => $uporabnik,
                    "prodajalec" => UporabnikiDB::get($_SESSION["uporabnik_id"])
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
        $ulica = $uporabnik["ulica"];
        $hisna_stevilka = $uporabnik["hisna_stevilka"];
        $posta = $uporabnik["posta"];
        $postna_stevilka = $uporabnik["postna_stevilka"];

        if ($tip == "admin") {

            $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);

        } else {

            $ime = filter_input(INPUT_POST, "ime", FILTER_SANITIZE_SPECIAL_CHARS);
            $priimek = filter_input(INPUT_POST, "priimek", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
            $geslo = filter_input(INPUT_POST, "geslo", FILTER_SANITIZE_SPECIAL_CHARS);

        }


        UporabnikiDB::edit($id, $ime, $priimek, $email, $geslo, $tip, $status, $ulica, $hisna_stevilka, $posta, $postna_stevilka);

        ViewHelper::redirect(BASE_URL . "nastavitve");
    }

    public static function odjava() {
        $_SESSION["uporabnik_id"] = null;

        ViewHelper::redirect(BASE_URL);
    }
    
    public static function trenutnaNarocila() {
        
        $id_uporabnika = $_SESSION["uporabnik_id"];
        $tabTrenutnaNarocila = NarocilaDB::najdiTrenutnaNarocila();
        
        $tabVsebinaNarocil = [];
        $tabSkupnihCen = [];
        $tabUporabnikov = [];
        
        foreach ($tabTrenutnaNarocila as $narocilo) {
            $artikli = [];
            $artikli = PodrobnostiNarocilaDB::vsebinaKosarice($narocilo["id"]);
            array_push($tabVsebinaNarocil, $artikli);
            
            $skupna_cena = 0;

            foreach ($artikli as $artikel) {
                $skupna_cena += $artikel["cena"] * $artikel["kolicina"];
            }
            
            array_push($tabSkupnihCen, $skupna_cena);
            
            //dobim uporabnike ki so narocili
            $uporabnik = UporabnikiDB::get($narocilo["uporabniki_id"]);
            $ime =$uporabnik["ime"];
            $priimek = $uporabnik["priimek"];
            $skupno = $ime . " " .$priimek;
            
            array_push($tabUporabnikov, $skupno);
        }
        
        
        echo ViewHelper::render("view/prodajalec_trenutna_narocila.php", [
            "tabTrenutnaNarocila" => $tabTrenutnaNarocila,
            "tabVsebinaNarocil" => $tabVsebinaNarocil,
            "tabSkupnihCen" => $tabSkupnihCen,
            "tabUporabnikov"=> $tabUporabnikov,
            "prodajalec" => UporabnikiDB::get($_SESSION["uporabnik_id"])
        ]);
        
        
    }
    
    public static function potrdiNarocilo() {
         $id_narocila = filter_input(INPUT_POST, "id_t_narocila", FILTER_SANITIZE_SPECIAL_CHARS);
        
        NarocilaDB::edit2($id_narocila, "potrjeno");
        echo ViewHelper::redirect(BASE_URL . "prodajalec_trenutna_narocila");
    }

    public static function prekliciNarocilo() {
         $id_narocila = filter_input(INPUT_POST, "id_t_narocila", FILTER_SANITIZE_SPECIAL_CHARS);
        
        NarocilaDB::edit2($id_narocila, "preklicano");
        echo ViewHelper::redirect(BASE_URL . "prodajalec_trenutna_narocila");
    }
    
    public static function zgodovinaNarocil() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        $tabTrenutnaNarocila = NarocilaDB::najdiPotrjenaNarocila();
        
        $tabVsebinaNarocil = [];
        $tabSkupnihCen = [];
        $tabUporabnikov = [];
        
        foreach ($tabTrenutnaNarocila as $narocilo) {
            $artikli = [];
            $artikli = PodrobnostiNarocilaDB::vsebinaKosarice($narocilo["id"]);
            array_push($tabVsebinaNarocil, $artikli);
            
            $skupna_cena = 0;

            foreach ($artikli as $artikel) {
                $skupna_cena += $artikel["cena"] * $artikel["kolicina"];
            }
            
            array_push($tabSkupnihCen, $skupna_cena);
            
            //dobim uporabnike ki so narocili
            $uporabnik = UporabnikiDB::get($narocilo["uporabniki_id"]);
            $ime =$uporabnik["ime"];
            $priimek = $uporabnik["priimek"];
            $skupno = $ime . " " .$priimek;
            
            array_push($tabUporabnikov, $skupno);
        }
        
        
        echo ViewHelper::render("view/prodajalec_zgodovina_narocil.php", [
            "tabTrenutnaNarocila" => $tabTrenutnaNarocila,
            "tabVsebinaNarocil" => $tabVsebinaNarocil,
            "tabSkupnihCen" => $tabSkupnihCen,
            "tabUporabnikov"=> $tabUporabnikov,
            "prodajalec" => UporabnikiDB::get($_SESSION["uporabnik_id"])
        ]);
    }
    
    public static function stornirajNarocilo() {
        $id_narocila = filter_input(INPUT_POST, "id_t_narocila", FILTER_SANITIZE_SPECIAL_CHARS);
        
        
        NarocilaDB::edit2($id_narocila, "stornirano");
        echo ViewHelper::redirect(BASE_URL . "prodajalec_zgodovina_narocil");
    }
    
      //rezultati iskanja
    public static function rezultatiIskanjaProdajalecPrazno() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        
        
        echo ViewHelper::render("view/stranka_rezultati_iskanja_prazno.php", [
            "uporabnik" => UporabnikiDB::get($id_uporabnika)
        ]);
    }
    
    public static function rezultatiIskanjaProdajalecPolno() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        //var_dump($id_uporabnika);
        $niz = filter_input(INPUT_POST, "poljeIskalniNiz", FILTER_SANITIZE_SPECIAL_CHARS);
        //$niz = $_POST["poljeIskalniNiz"];
        //var_dump($niz);
        
        $artikli = ArtikliDB::isciPoArtiklihProdajalec($niz);
        //var_dump($artikli);
        
        echo ViewHelper::render("view/stranka_rezultati_iskanja_polno.php", [
            "uporabnik" => UporabnikiDB::get($id_uporabnika),
            "artikli"=> $artikli
        ]); 
         
        
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
