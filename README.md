# Seminarska naloga
## Elektronsko poslovanje, FRI 2020/21

Repozitorij vsebuje kodo za izdelavo spletne trogovine pri predmetu elektronsko poslovanje v študijskem letu 2020/21.
Uporabljene tehnologije: PHP, HTML, CSS, JavaScript, SQL, Android 

## Certifikati 

**Ime certifikatne agencije:** Spletna Trgovina CA
**Email CA:** ca@ep.si
**Uporabnisko ime** ep
**Geslo:** ep 
**Admin:** admin@ep.si

## Uporabniška imena in gesla
### Admin
ui: admin@ep.si geslo: pass
### Prodajalec
ui: ana@ep.si geslo: pass
ui bojan@ep.si geslo: pass
### Stranka
ui: tjasa@gmail.com geslo: pass

## ZAHTEVE:
- [x] Administrator: Ime, Priimek, Elektronski naslov in geslo.
- [x] Prodajalec: Ime, Priimek, Elektronski naslov in geslo.
- [x] Stranka: Ime, Priimek, Naslov (sestavljen iz ulice, hišne številke, pošte in poštne številke), Elektronski naslov, geslo.
- [x] Anonimni odjemalec, pri katerem ne hranite atributov.
- [x] prijava in odjava admina
- [x] ovirajanje admina s certifikatom
- [x] ustvarjanje, aktiviranje, deaktiviranje, urejanje Prodajalca
- [x] admin rocno kreiran
- [x] prijava in odjava Prodajalca
- [x] ovirjanje prodajalca s certifikatom
- [x] posodabljanje lastnega gesla in ostalih atributov (Prodajalec)
- [ ] Pregled še neobdelanih naročil in njihovih postavk. Posamezno naročilo se prodajalcu prikaže šele, ko Stranka z nakupom zaključi (Prodajalec)
- [ ] Potrjevanje ali preklic oddanih naročil (Prodajalec)
- [ ] Ogled zgodovine potrjenih naročil in možnost storniranja potrjenih naročil (Prodajalec)
- [x] Ustvarjanje, aktiviranje in deaktiviranje artiklov in posodabljanje njihovih atributov.
- [x] Ustvarjanje, aktiviranje in deaktiviranje uporabniških računov tipa Stranka in posodabljanje njegovih atributov.
- [x] prijava in odaja stranke
- [x] posodabljanje lastnih atributov za stranko
- [x] pregled atriklov za stranko
- [x] dodajanje artikla v kosarico
- [x] odstranjevanje artikla iz kosarice
- [ ] zakljucek nakupa in posiljanje narocila v cakalno vrsto k Prodajalcu
- [ ] Dostop do seznama preteklih nakupov. Uporabnik lahko vidi vsa svoja pretekla naročila: oddana, potrjena, preklicana in stornirana.
- [x] Uporaba vmesnika Stranka je dovoljena le preko zavarovanega kanala. Odjemalca overite z uporabniškim imenom in geslom, ki naj bosta shranjena v SUPB.
- [x] pregledovanje artikov za anonimnega obiskovalca
- [x] registracija za anonimnega obiskovalca
- [x] zavarovan kanal za registracijo in preklaplanje med kanaloma
- [ ] pregledovanje artiklov v trgovini na Androidu
- [ ] vmesnik za komuniciranje Android aplikacije s spletno prodajalno
- [ ] seznam vseh artiklov na aplikaciji Android
- [ ] ob kliku na artikel se pokazejo podrobnosti na novem zaslonu Android
- [x] izdelovanje lastne certifikatne agencije in namestitev na streznik apache 
- [x] Osebne certifikate izdelajte ročno z namenskim programom in z uporabo iste certifikatne agencije, kot ste jo uporabili za izdelavo strežniškega certifikata. Uporabite smiselna polja certifikata ter na ustrezen način povežite identiteto uporabnika v bazi z identiteto zapisano v certifikatu.
- [x] Pri realizaciji vseh delov prodajalne skrbno preverjajte vnose s strani odjemalca, pri čemer bodite posebej pozorni na napade injekcije kode SQL ter napade XSS.
- [x] Metode protokola HTTP realizirajte v skladu s priporočili standarda HTTP, kjer uporabite zahtevke z metodo GET za lahke operacije, za zahtevnejše pa zahtevke z metodo POST.
- [x] ustrezna hramba gesel
- [ ] Izdelan model podatkovne baze naj bo normaliziran do tretje normalne oblike. Vse denormalizacije morajo biti utemeljene.
### Napredne funkcionalnosti
- [x] V1 (5%) Registracija strank z uporabo filtriranja CAPTCHA.
- [x] V2 (5%) Registracija strank z uporabo potrditvenega e-maila.
- [ ] V1 (do 6%) Smiselna organizacija in izvedba uporabniškega vmesnika s pomočjo tehnologij kot so sta CSS in JavaScript. Za polno oceno je nujna tudi uporaba tehnologij, ki omogočajo asinhrono komunikacijo s strežnikom v ozadju in dinamično posodabljanje DOM; denimo tehnologije AJAX, Vue.js in podobno.
- [ ] V2 (7%) Predstavitev artiklov s slikami. Slike lahko shranite v SUPB ali na datotečni sistem. Za polno oceno mora implementacija podpirati dodajanje in spreminjanje slik na enak način kot se spreminjajo ostali atributi artiklov ter možnost, da za vsak artikel dodamo več slik.
- [ ] V3 (3%) Implementacija iskanja po artiklih. Iskalnik naj podpira binarno iskanje, tj. poizvedbe pri katerih lahko s posebnimi operatorji določene iskalne pojme izključimo.
- [x] V4 (4%) Implementacija ocenjevanja artiklov prijavljenega uporabnika ter predstavitev njihove povprečne ocene pri njihovem ogledu.
### Napredne funkcionalnosti Android
- [ ] A1 (5%) Prijava in odjava.
- [ ] A2 (5%) Pregled profilnih podatkov (ime, priimek, email, geslo, naslov ipd.) ter možnost njihovega spreminjanja.
- [ ] A3 (3%) Prikaz slik artiklov (predpogoj je implementacija UI2; za polno oceno je potreben prikaz vseh slik).
- [ ] A4 (7%) Izvajanje nakupa. Implementirajte zaslon, kjer boste prikazali vsebino nakupovalne košarice skupaj z ustreznimi kontrolami za manipulacijo artiklov v košarici ter dialogom, kjer bo uporabnik lahko nakup tudi zaključil.
- [ ] A5 (3%) Sinhronizacija nakupovalne košarice. (Predpogoj je A4.) Nakupovalna košarica naj bo sinhronizirana z računom prijavljenega uporabnika. Na primer, če je uporabnik prijavljen v mobilno in v spletno aplikacijo hkrati, naj bo vsebina nakupovalne košarice v obeh vmesnikih ista. Pri tem vam ni treba skrbeti, da se vsebina košarice oz. grafični vmesnik samodejno osvežuje, temveč lahko od uporabnika zahtevate, da vsebino košarice ročno osveži.
- [ ] A6 (3%) Pregled preteklih nakupov. Implementacija naj obsega tako pregled seznama vseh nakupov kot tudi ogled podrobnosti posameznega nakupa kot so seznam artiklov, končni znesek ipd.



## TODO:

- [x] bazo (sql script)
- [x] certifikatna agencija (1 admin, 2 prodajalca)
- [X] zaslon za registracijo + spremenit za posamezni tip uporabnika, detajli artikla

- [x] posodibtev lastnih atributov za vse uporabnike **Tilen**
- [ ] hierarhično posodabljanje in kreacija tipov uporabnikov (spet svoja stran))
- [x] izpis artiklov na strani uporabnikov **(Tilen)**
- [x] povazava do posameznega artikla (spreminjanje atribtov če je tip uporanbika prodajalec) **Luka**
- [x] overjanje admina in prodajalca s certifikatom **Luka**
- [ ] košarica uporabnika (nova stran) **Tilen**
- [ ] izpis predračuna **Rihard**
- [x] pravilna hramba gesel **Tilen**


- [ ] povezava do posameznega naročila **Rihard**
- [ ] izpis naročil s statusom oddano (in možnost da spremeni status v preklic oziroma potrdi) **Rihard**
- [ ] izpis vseh naročil s statusom potrjeno (zraven možnost storniranja) **Rihard**
- [ ] izpis vseh artiklov za prodajalca (zraven še možnost deaktiviranja izdelka) + še dodan pogled za ustvaritev artikla (ista stran kot pri prikazu posameznega artikla samo da je prazno)

- [ ] izpis pretklih nakupov (status naročil vsa razen neoodano(neoodano predstavlja košarico)) **Rihard**

- [x] anonimni uproabnik ima samo možnost izpisa vseh artiklov (isti izpis kot stranka) in ogled detajlov artiklov)
- [x] registracija novega uporabnika (se ga doda kot tip stranka) 
- [ ] uporabnik vpiše email in izpolni captcho **Rihard (če ni še noben zčnu in ko končam naročila)**
- [ ] na email dobi geslo za prvo prijavo (itak geslo lahko pole spremeni) **Rihard (če ni še noben zčnu in ko končam naročila)**
----------------------------------------------------------------------------

### Naloge (napiši se zravn takoj ko začneš delat)

- [x] izpis artiklov - **Tilen**
- [x] ustvaritev stranke
- [x] ustvartiev artikla **Tilen**
- [x] x-artikel - izpiše detajle klik na izbran artikel povede na stran x-artikel
- [x] sprememba svojih atribtuov (sepravi x-nastative) **Tilen**
- [x] sprememba atributov ostalih **Tilen**
- [x] implementiranje seje (uporabnik ostane prijavljen)
- [x] prijava/odjava/registracija
- [x] pogledi za trgovca **Tilen**
- [x] pogledi za administratorja **Tilen**
- [x] prikaz vseh strank prodajalcu **Tilen**
- [x] kreiranje nove stranke **Tilen**
- [ ] dodajanje novega prodajalca **Tilen** 

----------------------------------------------------------------------------

### Android:
- [ ] samo izpis artiklov in ogled artikla (isto kot pri anonimnem uporabnika na spletni strani)


----------------------------------------------------------------------------

- [ ] iskanje po artiklih
- [ ] ocenjevanje artikla
