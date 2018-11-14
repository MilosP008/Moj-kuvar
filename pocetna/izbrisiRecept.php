<?php
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	$idRecepta = $_REQUEST["idRecepta"];
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka);
	$izbrisiSlikuRecepta = "DELETE FROM slika WHERE slika.ID_recepta = $idRecepta;";
	mysqli_query($konekcija, $izbrisiSlikuRecepta);
	$izbrisiKomentareRecepta = "DELETE FROM komentar WHERE komentar.ID_recepta = $idRecepta;";
	mysqli_query($konekcija, $izbrisiKomentareRecepta);
	$izbrisiRecept = "DELETE FROM recept WHERE recept.ID = $idRecepta;";
	mysqli_query($konekcija, $izbrisiRecept);
	mysqli_close($konekcija);
?>