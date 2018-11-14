<?php
	session_start();

	$ime = $prezime = $email = $sifra = $pol = "";
	$p_email = $p_sifra = "";
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["ime"]) && isset($_POST["prezime"]) && isset($_POST["email"]) && isset($_POST["sifra"]) && isset($_POST["pol"])) {
			$ime = provera($_POST["ime"]);
			$prezime = provera($_POST["prezime"]);
			$email = provera($_POST["email"]);
			$sifra = provera($_POST["sifra"]);
			$pol = provera($_POST["pol"]);
		}			
		if(isset($_POST["p_email"]) && isset($_POST["p_sifra"])) {
			$p_email = provera($_POST["p_email"]);
			$p_sifra = provera($_POST["p_sifra"]);
		}
	}
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka) or die("Konekcija sa bazom podataka nije uspela.");
	
	if($ime != "" && $prezime != "" && $email != "" && $sifra != "" && $pol != "") {
		$umetniKorisnika = "INSERT INTO korisnik (ime, prezime, email, sifra, pol) VALUES ('$ime', '$prezime', '$email', '$sifra', '$pol');";
		if(mysqli_query($konekcija, $umetniKorisnika)) {
			$uspesnaRegistracija = "Uspešno ste se registrovali.";
			$izaberiTrenutnoNapravljenogKorisnika = "SELECT korisnik.ID FROM korisnik ORDER BY korisnik.ID DESC LIMIT 1;";
			$rezultatBiranjaTrenutnoNapravljenogKorisnika = mysqli_query($konekcija, $izaberiTrenutnoNapravljenogKorisnika);
			if(mysqli_num_rows($rezultatBiranjaTrenutnoNapravljenogKorisnika) > 0) {
				while($trenutnoNapravljeniKorisnik = mysqli_fetch_assoc($rezultatBiranjaTrenutnoNapravljenogKorisnika)) {
					$idTrenutnogKorisnika = $trenutnoNapravljeniKorisnik["ID"];
				}
			}
			if($pol == "Musko") {
				$umetniPodrazumevanuSlikuMusko = "INSERT INTO slika (putanja, vrsta, ID_korisnika) VALUES ('slike/male_avatar.png', 'profilna', '$idTrenutnogKorisnika');";
				mysqli_query($konekcija, $umetniPodrazumevanuSlikuMusko);
			} else if($pol == "Zensko") {
				$umetniPodrazumevanuSlikuZensko = "INSERT INTO slika (putanja, vrsta, ID_korisnika) VALUES ('slike/female_avatar.png', 'profilna', '$idTrenutnogKorisnika');";
				mysqli_query($konekcija, $umetniPodrazumevanuSlikuZensko);
			}
			header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
		} else {
			$_SESSION["ispisGreske2"] = "Email već postoji.";
			header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/index.php");
		}
		mysqli_close($konekcija);
	} else if($p_email != "" && $p_sifra != "") {
		$izaberiKorisnika = "SELECT id, ime, prezime, email, sifra, pol FROM korisnik WHERE email = '$p_email' AND sifra = '$p_sifra';";
		$rezultat = mysqli_query($konekcija, $izaberiKorisnika);
		if(mysqli_num_rows($rezultat) > 0) {
			$korisnickiPodaci = mysqli_fetch_assoc($rezultat);
			$_SESSION["idKorisnika"] = $korisnickiPodaci["id"];
			$_SESSION["imeKorisnika"] = $korisnickiPodaci["ime"];
			$_SESSION["prezimeKorisnika"] = $korisnickiPodaci["prezime"];
			$_SESSION["emailKorisnika"] = $korisnickiPodaci["email"];
			$_SESSION["sifraKorisnika"] = $korisnickiPodaci["sifra"];
			$_SESSION["polKorisnika"] = $korisnickiPodaci["pol"];
			mysqli_close($konekcija);
			header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna/index.php");
		} else {
			header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/index.php");
			$_SESSION["ispisGreske"] = "<div id=\"povratna_greska\">Email ili šifra nisu važeći.</div>";
		}
	} else {
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/index.php");
	}
	
	function provera($podatak) {
		$podatak = trim($podatak);
		$podatak = stripslashes($podatak);
		$podatak = htmlspecialchars($podatak);
		return $podatak;
	}
?>