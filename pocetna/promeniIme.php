<?php
	session_start();
	
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	if(isset($_POST['novoIme']) and isset($_POST['novoPrezime'])) {
		$novoIme = provera($_POST['novoIme']);
		$novoPrezime = provera($_POST['novoPrezime']);
	}
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka);
	$emailKorisnika = $_SESSION['emailKorisnika'];
	$promeniIme = "UPDATE korisnik SET ime = '$novoIme', prezime = '$novoPrezime' WHERE email = '$emailKorisnika';";
	mysqli_query($konekcija, $promeniIme);
	$_SESSION['imeKorisnika'] = $novoIme;
	$_SESSION['prezimeKorisnika'] = $novoPrezime;
	header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
	mysqli_close($konekcija);
	
	function provera($podatak) {
		$podatak = trim($podatak);
		$podatak = stripslashes($podatak);
		$podatak = htmlspecialchars($podatak);
		return $podatak;
	}
?>