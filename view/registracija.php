<!DOCTYPE html>

<html lang="sl" style="height:100%; width:100%;">
  <head>
    <meta charset="utf-8">
	
	<!-- import bootstrap in font awesome -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	
	<!-- ikona in link do css -->
	<link rel="stylesheet" href="izgled_header.css">
	<link rel="icon" type='image/x-icon' href="./slike/logo_ikona.ico">
	
	<!-- pisave -->
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	
    <title>Trgovina abc</title>
	
  </head>
  
  
<body style="background-color:#c3c3c3; height:100%; width:100%;">


<!-- vsebina kontejner ki ni header -->
<div class="container-lg d-flex justify-content-center" style="height:100%; width:100%; margin-top:3vh;">
  
  <!--
  ========================================
  tle notr gre vsebina celotne strani
  ========================================
  -->
  
  <div class="card border-dark overflow-auto" style="height:80%; width:60%;" >
		<div class="card-header bg-dark text-white overflow-auto" ><i class="fas fa-store"></i> <b><i>Trgovina abc</i></b></div>
			<div class="card-body px-3 py-3 overflow-auto" style="height:100%">
			
			
			<div class="col-sm-6 overflow-auto">
			
			
			<h3 class="text-dark"> <b class="">Registracija</b></h3><br>
			
			<form method="POST">
			  <div class="form-group">
				<label for="exampleInputEmail1">E-pošta:</label>
				<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Geslo:</label>
				<input type="password" class="form-control" id="exampleInputPassword1" name="geslo">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Ime:</label>
				<input type="text" class="form-control" id="exampleInputPassword1" name="ime">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Priimek:</label>
				<input type="text" class="form-control" id="exampleInputPassword1" name="priimek">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Ulica:</label>
				<input type="text" class="form-control" id="exampleInputPassword1" name="ulica">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Hisna stevilka:</label>
				<input type="number" class="form-control" id="exampleInputPassword1" name="hisna_stevilka">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Posta:</label>
				<input type="text" class="form-control" id="exampleInputPassword1" name="posta">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Postna stevilka:</label>
				<input type="number" class="form-control" id="exampleInputPassword1" name="postna_stevilka">
			  </div>

			  <div class="g-recaptcha" data-sitekey="6LdzPA0aAAAAAB3t4KllNsLCFwFYdUWEXFxdA1xC" name="g-recaptcha-response"></div>

			  <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Ustvari račun</button>
			</form>

			</div>
	
			</div>
    </div>
  
 
  </div>
  
  
  <!-- ------------------------------------------- -->
  

</body>

</html>