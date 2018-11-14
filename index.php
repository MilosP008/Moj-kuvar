<?php
	session_start();
	if(isset($_SESSION["imeKorisnika"]) && isset($_SESSION["prezimeKorisnika"]) && isset($_SESSION["emailKorisnika"]) && isset($_SESSION["sifraKorisnika"]) && isset($_SESSION["polKorisnika"])) {
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Moj kuvar</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/icon-x" href="slike/chef_hat.png" /> 
		<link rel="stylesheet" type="text/css" href="pocetna.css" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes" />
		<link rel="canonical" href="http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/" />
	</head>
	<body>
		<header>
			<h1>Moj kuvar</h1>
		</header>
		<main>
			<section id="prijava">
				<h1>Prijava</h1>
				<form action="pocetna/provera.php" method="post" name="prijava" onsubmit="return priValidacija()">
					<label for="p_email">E-mail: </label>
					<div class="greska" id="g_p_email"></div>
					<input type="email" name="p_email" placeholder="primer@mail.com" /><br /><br /><br />
					<label for="p_sifra">Šifra: </label>
					<div class="greska" id="g_p_sifra"></div>
					<input type="password" name="p_sifra" placeholder="šifra" /><br /><br /><br />
					<?php
						if(isset($_SESSION["ispisGreske"])) {
							echo $_SESSION["ispisGreske"];
							session_unset($_SESSION["ispisGreske"]);
						}
					?>
					<input type="submit" value="Prijavite se" onmousedown="aktiviranoDugmeZaPrijavu(this)"  />
				</form>
			</section>
			<section id="registracija">
				<h1>Registracija</h1>
				<form action="pocetna/provera.php" method="post" name="registracija" onsubmit="return regValidacija()">
					<label for="ime">Ime: </label>
					<div class="greska" id="g_ime"></div>
					<input type="text" name="ime" placeholder="Ime" /><br /><br /><br />
					<label for="prezime">Prezime: </label>
					<div class="greska" id="g_prezime"></div>
					<input type="text" name="prezime" placeholder="Prezime" /><br /><br /><br />
					<label for="email">E-mail: </label>
					<div class="greska" id="g_email"><?php
						if(isset($_SESSION["ispisGreske2"])) {
							echo $_SESSION["ispisGreske2"];
							session_unset($_SESSION["ispisGreske2"]);
						}
					?></div>
					<input type="email" name="email" placeholder="primer@mail.com" /><br /><br /><br />
					<label for="sifra">Sifra: </label>
					<div class="greska" id="g_sifra"></div>
					<input type="password" name="sifra" placeholder="šifra" /><br /><br /><br />
					<label for="sifra">Potvrdite šifru: </label>
					<div class="greska" id="g_sifra2"></div>
					<input type="password" name="sifra2" placeholder="šifra" /><br /><br /><br />
					<label for="pol"><input type="radio" name="pol" value="Musko" />Muško</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label for="pol"><input type="radio" name="pol" value="Zensko" />Žensko</label>
					<input type="submit" value="Registrujte se" onmousedown="aktiviranoDugmeZaRegistraciju(this)" />
				</form>
			</section>
			<hr size="480px" width="1px" style="position: absolute; top: 365px; left: 50%;" />
			<hr size="5" width="90%" style="border-radius: 50%;" />
		</main>
		<footer>
			<span>&copy; Copyright 2018-<span id="trenutna_godina"></span>. Sva prava zadržana</span>
			<address>
				Email: &#9993; milospetrovic008@gmail.com<br />
				Kontakt: &#9743; 063/XXX XX XX
			</address>
		</footer>
		<script src="pocetna.js"></script>
	</body>
</html>