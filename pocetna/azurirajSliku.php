<?php
	session_start();

	$moguceEkstenzije = array("jpg", "jpeg", "gif", "tiff");
	$direktorijum = "azurirane slike/" . $_FILES["azuriranaSlika"]["name"];
	$ekstenzija = strtolower(pathinfo($direktorijum, PATHINFO_EXTENSION));
	$greska = "";
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	if($ekstenzija != $moguceEkstenzije[0] && $ekstenzija != $moguceEkstenzije[1] && $ekstenzija != $moguceEkstenzije[2] && $ekstenzija != $moguceEkstenzije[3]) {
		$greska = "* Moguće je ažurirati samo slike jpg, jpeg, gif i tiff formata.";
	} else if($_FILES["azuriranaSlika"]["size"] > 1000000) {
		$greska = "* Slika ne sme biti veća od 1MB";
	}
	
	if($greska != "") {
		$_SESSION["greskaPriAzuriranju"] = $greska;
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
		exit();
	} else if(move_uploaded_file($_FILES["azuriranaSlika"]["tmp_name"], $direktorijum)) {
		if(isset($_SESSION["greskaPriAzuriranju"])) {
			unset($_SESSION["greskaPriAzuriranju"]);
		}
		$direktorijum = "pocetna/" . $direktorijum;	
		$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka) or die("Konekcija nije uspela.");
		$idKorisnika = $_SESSION["idKorisnika"];
		$umetniSliku = "INSERT INTO slika (putanja, vrsta, ID_korisnika) VALUES ('$direktorijum', 'profilna', '$idKorisnika')";
		mysqli_query($konekcija, $umetniSliku);
		//Izbriši prethodno unete slike
		$izaberiBrojSlika = "SELECT COUNT(slika.id) AS broj_slika FROM slika INNER JOIN korisnik ON korisnik.id = slika.id_korisnika WHERE $idKorisnika = slika.id_korisnika AND slika.vrsta = 'profilna';";
		$brojSlika = mysqli_query($konekcija, $izaberiBrojSlika);
		$brojSlikaNiz = mysqli_fetch_assoc($brojSlika);
		$brojSvihSlikaSemPoslednje = $brojSlikaNiz["broj_slika"] - 1; //$brojSvihSlikaSemPoslednje = 2;
		$izbrisiPrethodneSlike = "DELETE FROM slika WHERE $idKorisnika = slika.id_korisnika AND slika.vrsta = 'profilna' ORDER BY slika.id ASC LIMIT $brojSvihSlikaSemPoslednje;";
		mysqli_query($konekcija, $izbrisiPrethodneSlike);
		mysqli_close($konekcija);
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
		exit();
	}
?>