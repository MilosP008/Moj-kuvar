<?php
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	$idKomentara = $_REQUEST["idKomentara"];
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka);
	$izbrisiKomentar = "DELETE FROM komentar WHERE komentar.ID = $idKomentara;";
	if(mysqli_query($konekcija, $izbrisiKomentar)) {
		$_SESSION["brojKomentara"] -= 1;
	}
	mysqli_close($konekcija);
?>