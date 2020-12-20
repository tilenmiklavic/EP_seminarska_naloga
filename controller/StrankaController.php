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
            "skupna_cena" => $skupna_cena,
            "stranka" => UporabnikiDB::get($id_uporabnika)
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

    public static function odstraniArtikelIzKosarice() {
        // iz seje dobimo uporabnikov id in ga poklicemo iz baze
        $id = $_SESSION["uporabnik_id"];
        $uporabnik = UporabnikiDB::get($id);

        $id_artikla = $_POST["id"];
        $status = "kosarica";

        $narocilo = NarocilaDB::getByUporabnikId($id, $status);
        $podrobnost_narocila = PodrobnostiNarocilaDB::getByNarociloAndArtikel($narocilo["id"], $id_artikla);


        if (PodrobnostiNarocilaDB::delete($podrobnost_narocila["id_podrobnosti_narocila"])) {
            echo ViewHelper::redirect(BASE_URL . "kosarica");
        } else {
            echo("Napaka");
        }
    }

    public static function posodobiKosarico() {
        // iz seje dobimo uporabnikov id in ga poklicemo iz baze
        $id = $_SESSION["uporabnik_id"];
        $uporabnik = UporabnikiDB::get($id);

        $id_artikla = $_POST["id"];
        $status = "kosarica";

        $narocilo = NarocilaDB::getByUporabnikId($id, $status);
        $podrobnost_narocila = PodrobnostiNarocilaDB::getByNarociloAndArtikel($narocilo["id"], $id_artikla);
        $kolicina = $_POST["num"];

        if ($kolicina < 1) {
            if (PodrobnostiNarocilaDB::delete($podrobnost_narocila["id_podrobnosti_narocila"])) {
                echo ViewHelper::redirect(BASE_URL . "kosarica");
            } else {
                echo("Napaka");
            }
        } else {

            if (PodrobnostiNarocilaDB::edit($podrobnost_narocila["id_podrobnosti_narocila"], $id_artikla, $kolicina, $narocilo["id"])) {
                echo ViewHelper::redirect(BASE_URL . "kosarica");
            } else {
                echo("Napaka");
            }
        }
    }

    public static function dodajOceno($id) {
        $artikel = ArtikliDB::get($id);
        $ocena = $_POST["ocena"];

        echo($ocena);
        $ime = $artikel["ime"];
        $avtor = $artikel["avtor"];
        $zalozba = $artikel["zalozba"];
        $cena = $artikel["cena"];
        $slike = $artikel["slike"];
        $naslov_slike = $artikel["naslov_slike"];
        $aktiven = $artikel["active"];
        $stevilo_ocen = $artikel["stevilo_ocen"] + 1;

        $ocena = ($ocena + ($stevilo_ocen-1) * $artikel["ocena"]) / $stevilo_ocen;

        echo($ocena);
        if (ArtikliDB::edit($id, $ime, $avtor, $zalozba, $cena, $slike, $naslov_slike, $aktiven, $ocena, $stevilo_ocen)) {
            echo ViewHelper::redirect(BASE_URL . "artikli/" . $id);
        } else {
            echo("Napaka");
        }

    }
    
     
    public static function predracun() {

        $id_uporabnika = $_SESSION["uporabnik_id"];
        $narocilo = NarocilaDB::getByUporabnikID($id_uporabnika, "kosarica");
        $artikli = [];
        $id_narocila = $narocilo["id"];
        

        if ($narocilo) {
            $artikli = PodrobnostiNarocilaDB::vsebinaKosarice($narocilo["id"]);
        }

        $skupna_cena = 0;

        foreach ($artikli as $artikel) {
            $skupna_cena += $artikel["cena"] * $artikel["kolicina"];
        }
        
        if ($skupna_cena == 0) {
            
            echo ViewHelper::redirect(BASE_URL . "kosarica");
            
        } else {

            echo ViewHelper::render("view/stranka_predracun.php", [
                "artikli" => $artikli,
                "skupna_cena" => $skupna_cena,
                "stranka" => UporabnikiDB::get($id_uporabnika),
                "id_narocila" => $id_narocila
            ]);
        
        }
        
    }
    
    public static function oddajNarocilo() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        $narocilo = NarocilaDB::getByUporabnikID($id_uporabnika, "kosarica");
        $id_narocila = $narocilo["id"];
        
        
        NarocilaDB::edit2($id_narocila, "oddano");

        echo ViewHelper::redirect(BASE_URL . "uspesno_oddano_narocilo");
        
        
    }
    
    public static function uspesno_oddano_narocilo() {
    
        $id_uporabnika = $_SESSION["uporabnik_id"];
        $stranka = UporabnikiDB::get($id_uporabnika);

        echo ViewHelper::render("view/stranka_uspesno_oddano_narocilo.php", [
            "stranka" => $stranka
        ]);
        
    }
    
    public static function zgodovina_nakupov() {
        
        $id_uporabnika = $_SESSION["uporabnik_id"];
        $tabZgodovinaNakupov = NarocilaDB::najdiZgodovinoNakupov($id_uporabnika);
        
        $tabIDji = [];
        $tabStatusov = [];
        
        foreach ($tabZgodovinaNakupov as $narocilo) {
            array_push($tabIDji, $narocilo["id"]);
            array_push($tabStatusov, $narocilo["status"]);
        }
        
        $tabNakupov = [];
        $tabSkupnihCen = [];
        
        
        foreach ($tabIDji as $trenutni_id) {
            $artikli = [];
            $artikli = PodrobnostiNarocilaDB::vsebinaKosarice($trenutni_id);
            array_push($tabNakupov, $artikli);
            
            $skupna_cena = 0;

            foreach ($artikli as $artikel) {
                $skupna_cena += $artikel["cena"] * $artikel["kolicina"];
            }
            
            array_push($tabSkupnihCen, $skupna_cena);
        }

        echo ViewHelper::render("view/stranka_zgodovina_nakupov.php", [
            "tabIDji" => $tabIDji,
            "tabNakupov" => $tabNakupov,
            "tabSkupnihCen" => $tabSkupnihCen,
            "tabStatusov"=> $tabStatusov,
            "stranka" => UporabnikiDB::get($id_uporabnika)
        ]);
        
    }

    public static function rezultatiIskanjaStrankaPrazno() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        
        
        echo ViewHelper::render("view/stranka_rezultati_iskanja_prazno.php", [
            "uporabnik" => UporabnikiDB::get($id_uporabnika)
        ]);
    }
    
    public static function rezultatiIskanjaStrankaPolno() {
        $id_uporabnika = $_SESSION["uporabnik_id"];
        //var_dump($id_uporabnika);
        
        $niz = $_POST["poljeIskalniNiz"];
        //var_dump($niz);
        
        $artikli = ArtikliDB::isciPoArtiklihStranka($niz);
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
