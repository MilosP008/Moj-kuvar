<?php
	session_start();
	
	$moguceEkstenzije = array("jpg", "jpeg", "gif", "tiff");
	$direktorijum = "receptne slike/" . $_FILES["receptnaSlika"]["name"];
	$ekstenzija = strtolower(pathinfo($direktorijum, PATHINFO_EXTENSION));
	$greska = "";
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	$naziv = provera($_POST["nazivRecepta"]);
	$tekst = provera($_POST["tekstRecepta"]);
	$vremePripremanja = provera($_POST["vremePripremanja"]);
	
	if($ekstenzija != $moguceEkstenzije[0] && $ekstenzija != $moguceEkstenzije[1] && $ekstenzija != $moguceEkstenzije[2] && $ekstenzija != $moguceEkstenzije[3]) {
		$greska = "* Moguće je dodati samo slike jpg, jpeg, gif i tiff formata.";
	} else if($_FILES["receptnaSlika"]["size"] > 1000000) {
		$greska = "* Slika ne sme biti veća od 1MB";
	}
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka) or die("Konekcija nije uspela.");
	$idKorisnika = $_SESSION["idKorisnika"];
	
	if($greska != "") {
		$_SESSION["greskaPriDodavanju"] = $greska;
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
	} else if(move_uploaded_file($_FILES["receptnaSlika"]["tmp_name"], $direktorijum)) {
		if(isset($_SESSION["greskaPriDodavanju"])) {
			session_unset($_SESSION["greskaPriDodavanju"]);
		}
		$direktorijum = "pocetna/" . $direktorijum;		
		$umetniSliku = "INSERT INTO slika (putanja, vrsta, ID_korisnika) VALUES ('$direktorijum', 'receptna', '$idKorisnika');";
		mysqli_query($konekcija, $umetniSliku);
		$izaberiIdSlike = "SELECT slika.ID FROM slika INNER JOIN korisnik ON slika.ID_korisnika = korisnik.ID WHERE slika.ID_korisnika = '$idKorisnika' ORDER BY slika.ID DESC LIMIT 1;";
		$rezultatBiranjaIdSlike = mysqli_query($konekcija, $izaberiIdSlike);
		$rezultatBiranjaIdSlikeNiz = mysqli_fetch_assoc($rezultatBiranjaIdSlike);
		$idSlike = $rezultatBiranjaIdSlikeNiz["ID"];
	}
	// TODO: Prikupi podatke i umetni ih u tabelu recept.
	if(isset($idSlike)) {
		$umetniRecept = "INSERT INTO recept (naziv, tekst, vreme_pripreme, ID_korisnika, ID_slike) VALUES ('$naziv', '$tekst', '$vremePripremanja', '$idKorisnika', '$idSlike');";
	} else {
		$umetniRecept = "INSERT INTO recept (naziv, tekst, vreme_pripreme, ID_korisnika) VALUES ('$naziv', '$tekst', '$vremePripremanja', '$idKorisnika');";
	}
	
	mysqli_query($konekcija, $umetniRecept);
	$izaberiIdRecepta = "SELECT recept.ID FROM recept INNER JOIN korisnik ON recept.ID_korisnika = korisnik.ID WHERE recept.ID_korisnika = '$idKorisnika' ORDER BY recept.ID DESC LIMIT 1;";
	$rezultatBiranjaIdRecepta = mysqli_query($konekcija, $izaberiIdRecepta);
	$rezultatBiranjaIdReceptaNiz = mysqli_fetch_assoc($rezultatBiranjaIdRecepta);
	$_SESSION["idRecepta"] = $rezultatBiranjaIdReceptaNiz["ID"];
	$idRecepta = $_SESSION["idRecepta"];
	// TODO: Umetni podatak u kolonu ID_recepta.
	$azurirajIdRecepta = "UPDATE slika SET ID_recepta = '$idRecepta' WHERE slika.vrsta = 'receptna' ORDER BY slika.ID DESC LIMIT 1;";
	mysqli_query($konekcija, $azurirajIdRecepta);
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