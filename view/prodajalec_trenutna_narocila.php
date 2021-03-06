<!DOCTYPE html>

<html lang="sl" style="height:100%;">
  <head>
    <meta charset="utf-8">
	
	<!-- import bootstrap in font awesome -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	
	<!-- ikona in link do css -->
	<link rel="stylesheet" href="izgled_header.css">
	<link rel="icon" type='image/x-icon' href="./slike/logo_ikona.ico">
	
	<!-- pisave -->
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	
    <title>Trgovina abc</title>
	
  </head>
  
  
<body style="background-color:#c3c3c3; padding-top:60px; padding-bottom:20px; height:100%;">

<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
	<!-- ta kontejner v navbaru se je prilagajal drugace kot tisti za vsebino, ceprav
	sta oba enake velikosti, dodal padding px-3 ker navbar avtomatsko odvzame padding iz kontejnerja -->
	<div class="container-lg px-3" >
		
		<!-- navbar logo -->
		<a class="navbar-brand" href="index"> 
			<i class="fas fa-store"></i> <b><i>Trgovina abc</i></b>
		</a>
		
		<!-- za kolaps pri majhnih zaslonih -->
		 <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"> </span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
		
		<!-- Search form -->
		<div class="ml-auto">
		<a href="prodajalec_rezultati_iskanja">
		<button type="button" class="btn  btn-sm btn-outline-light ">Iskanje</button>
		</a>
		</div>
		
		<!-- dropwdown meni -->
		<ul class="navbar-nav ml-2">
			
			<li class="nav-item dropdown " >
				<a id="testMenuRazlika1" class="nav-link dropdown-toggle"  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-user-circle"></i>
				</a>
			<div id="testMenuRazlika2" class="dropdown-menu dropdown-menu-right"  id="dropdownMeni" aria-labelledby="navbarDropdown">
				<a class="dropdown-item disabled" href="#"><?= $prodajalec["ime"]?> <?= $prodajalec["priimek"]?></a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="index"><i class="fas fa-box-open"></i></i> Seznam artiklov</a>
				<a class="dropdown-item" href="prodajalec_trenutna_narocila"><i class="fas fa-clipboard-check"></i> Trenutna naročila</a>
				<a class="dropdown-item" href="prodajalec_zgodovina_narocil"><i class="fas fa-history"></i> Zgodovina naročil</a>
				<a class="dropdown-item" href="stranke"><i class="fas fa-users-cog"></i> Stranke</a>
				<a class="dropdown-item" href="nastavitve"><i class="fas fa-cog"></i> Nastavitve</a>
				<a class="dropdown-item" href="odjava"><i class="fas fa-sign-out-alt"></i> Odjava</a>
			</div>
			</li>
		</ul>

		</div>
	  
	  
	</div>
</nav>


<!-- vsebina kontejner ki ni header -->
<div class="container-lg" style="height:100%;">
  
  <!--
  ========================================
  tle notr gre vsebina celotne strani
  ========================================
  -->
	<div class="card border-dark" style="height:100%" >
		<div class="card-header bg-dark text-white" >Trenutna naročila</div>
			<div class="card-body px-1 py-1" style="height:100%">
			
				<!-- zavijem da je kartica skrollable in se ne preliva cez -->
			<div class="scrollable" style="height:100%; overflow-y: auto;">
			
			<ul class="list-group" style="width:100%; height:100%;">
			
                            
                            <?php for($i = 0; $i < count($tabTrenutnaNarocila); $i++) { ?>
                            <li class="list-group-item  align-items-center ">
                                
                                
                                
                                <!-- posamezno narocilo -->
                                
                                <h6><b>Naročilo (id: <?=$tabTrenutnaNarocila[$i]["id"]?>)</b></h6><br>
                                <p>Naročil: <?=$tabUporabnikov[$i]?></p>

                                <ul>
                                    <?php foreach($tabVsebinaNarocil[$i] as $artikel): ?>
                                                    <li>
                                                            <div class="container row mt-3">
                                                                    <div class="col-sm-1">
                                                                            <img src="<?= $artikel["naslov_slike"]?>" width="50px" alt="slika artikla">
                                                                    </div>
                                                                    <div class="col-sm-3 p-0">

                                                                    <input type="hidden" name="do" value="update_cart">
                                                                    <input type="hidden" name="id" value="<?= $artikel["id_artikla"] ?>">
                                                                    <h6><?= $artikel["ime"]?> (Cena: <?= $artikel["cena"]?>€)</h6>
                                                                    <span class="badge badge-primary">Količina: <?=$artikel["kolicina"]?></span>


                                                                    </div>


                                                            </div>				
                                                    </li>

                                                    



                                    <?php endforeach; ?>

                                </ul>
                                
                                <br><p><b>Skupna cena: <?=$tabSkupnihCen[$i]?>€</b></p>
                                
                                <div class="row">
                                
                                <div class="col-sm-3">
                                <form method="post">
                                    <input type="hidden" name="do" value="potrdi_narocilo">
                                    <input type="hidden" name="id_t_narocila" value="<?=$tabTrenutnaNarocila[$i]["id"]?>">
                                    <button type="submit" class="btn btn-primary mb-1"><i class="fas fa-check"></i> Potrdi naročilo</button>
                                </form>
                                </div>
                                
                                <div class="col-sm-3">
                                <form method="post">
                                    <input type="hidden" name="do" value="preklici_narocilo">
                                    <input type="hidden" name="id_t_narocila" value="<?=$tabTrenutnaNarocila[$i]["id"]?>">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Prekliči naročilo</button>
                                </form>
                                </div>
                                
                                </div>
                                <!-- konec posameznega narocila -->
                                
                                
                                
                            </li>
                            <?php } ?>
			

                            
			</ul>
			
			</div>
			
			
	
			</div>
    </div>
  
  
  

  
  </div>
  
  
  <!-- ------------------------------------------- -->
  


</body>

</html>
