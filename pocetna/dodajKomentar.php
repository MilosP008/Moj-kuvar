<?php
	session_start();

	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	$tekstKomentara = provera($_POST["tekstKomentara"]);
	$ocena = provera($_POST["ocena"]);
	$idRecepta = $_POST["idRecepta"];
	$idKorisnika = $_SESSION["idKorisnika"];
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka);
	$umetniKomentar = "INSERT INTO komentar (tekst, ocena, ID_korisnika, ID_recepta) VALUES ('$tekstKomentara', '$ocena', '$idKorisnika', '$idRecepta');";
	mysqli_query($konekcija, $umetniKomentar);
	mysqli_close($konekcija);
	header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
	exit();
	
	function provera($podatak) {
		$podatak = trim($podatak);
		$podatak = stripslashes($podatak);
		$podatak = htmlspecialchars($podatak);
		return $podatak;
	}
?>