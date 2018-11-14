<?php
	session_start();
	
	if(!isset($_SESSION["imeKorisnika"]) && !isset($_SESSION["prezimeKorisnika"]) && !isset($_SESSION["emailKorisnika"]) && !isset($_SESSION["sifraKorisnika"]) && !isset($_SESSION["polKorisnika"])) {
		header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<base href="../" />
		<title>Moj kuvar</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/icon-x" href="slike/chef_hat.png" /> 
		<link rel="stylesheet" type="text/css" href="pocetna/pocetna.css" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Great Vibes" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="canonical" href="http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/pocetna" />
	</head>
	<body>
		<header>
			<h1>Moj kuvar</h1>
		</header>
		<main>
<?php
	$imeServera = "localhost";
	$korisnickoIme = "root";
	$korisnickaSifra = "";
	$imeBazePodataka = "moj_kuvar";
	
	$nazivRecepta = strtolower($_POST["pretraga"]);
	
	$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka);
	$izaberiRecept = "SELECT recept.ID, recept.naziv, recept.tekst, recept.vreme_pripreme, recept.ID_korisnika, recept.ID_slike FROM recept WHERE recept.naziv = '$nazivRecepta';";
	$rezultatBiranjaRecepta = mysqli_query($konekcija, $izaberiRecept);
	if(mysqli_num_rows($rezultatBiranjaRecepta) > 0) {
		while($recept = mysqli_fetch_assoc($rezultatBiranjaRecepta)) {
			$idRecepta = $recept["ID"];
			$naziv = $recept["naziv"];
			$tekst = $recept["tekst"];
			$vremePripreme = $recept["vreme_pripreme"];
			$receptIdKorisnika = $recept["ID_korisnika"];
			$idSlike = $recept["ID_slike"];
			$idKorisnika = $_SESSION["idKorisnika"];
			static $brojRecepta = 0;
			$_SESSION["brojRecepta"] = $brojRecepta;
			
			echo "<div class=\"recept\">
				<img src=\"";
				if($idSlike != null) {
					$izaberiSlikuIKorisnikaRecepta = "SELECT slika.putanja, korisnik.ime, korisnik.prezime FROM slika INNER JOIN recept ON slika.ID_recepta = recept.ID INNER JOIN korisnik ON recept.ID_korisnika = korisnik.ID WHERE slika.ID_recepta = $idRecepta AND slika.vrsta = 'receptna' AND korisnik.ID = $receptIdKorisnika;";
					$rezultatBiranjaSlikeRecepta = mysqli_query($konekcija, $izaberiSlikuIKorisnikaRecepta);
					$rezultatBiranjaSlikeReceptaNiz = mysqli_fetch_assoc($rezultatBiranjaSlikeRecepta);
					$izaberiSlikuKorisnikaRecepta = "SELECT slika.putanja FROM slika INNER JOIN korisnik ON slika.ID_korisnika = korisnik.ID INNER JOIN recept ON korisnik.ID = recept.ID_korisnika WHERE korisnik.ID = $receptIdKorisnika AND slika.vrsta = 'profilna' LIMIT 1;";
					$rezultatBiranjaSlikeKorisnikaRecepta = mysqli_query($konekcija, $izaberiSlikuKorisnikaRecepta);
					$rezultatBiranjaSlikeKorisnikaReceptaNiz = mysqli_fetch_assoc($rezultatBiranjaSlikeKorisnikaRecepta);
					$putanjaSlikeRecepta = $rezultatBiranjaSlikeReceptaNiz["putanja"];
					$imeKorisnikaRecepta = $rezultatBiranjaSlikeReceptaNiz["ime"];
					$prezimeKorisnikaRecepta = $rezultatBiranjaSlikeReceptaNiz["prezime"];
					$putanjaSlikeKorisnikaRecepta = $rezultatBiranjaSlikeKorisnikaReceptaNiz["putanja"];
					echo "$putanjaSlikeRecepta";
				} else {
					echo "slike/food.png";
				}
				echo   "\" alt=\"Slika recepta\" />";
				echo   "<div id=\"naziv_recepta\" >$naziv</div>
						<div id=\"vreme_pripreme\" >Vreme pripremanja: $vremePripreme minuta</div>
						<div id=\"tekst\">Recept: $tekst</div>
						<div id=\"podaci_korisnika_recepta\">
							<img src=\"";
								echo $putanjaSlikeKorisnikaRecepta; 
							echo "\" alt=\"Slika korisnika recepta\" />&nbsp;&nbsp;
							<span>$imeKorisnikaRecepta</span> <span>$prezimeKorisnikaRecepta</span>
						</div>
						<div class=\"dugme_komentar\" data-value=\"$brojRecepta\">
							<img src=\"slike/comment_icon.png\" alt=\"Dodajte komentar\" />
						</div>
						<div class=\"forma_dodaj_komentar\" data-value=\"$brojRecepta\">
							<form action=\"pocetna/dodajKomentar.php\" method=\"post\" name=\"komentar\" onsubmit=\"return komValidacija()\">
								<textarea name=\"tekstKomentara\" class=\"tekst_komentara\" placeholder=\"Dodajte komentar.\"></textarea>
								<label for=\"ocena\" class=\"label_ocena\">Ocena recepta</label><br />
								<input type=\"number\" name=\"ocena\" class=\"ocena_recepta\" min=\"1\" max=\"5\" />
								<input type=\"hidden\" name=\"idRecepta\" value=\"$idRecepta\" />
								<input type=\"submit\" value=\"Dodajte komentar\" class=\"dugme_dodajte_komentar\" />
							</form><hr />";
						$izaberiKomentar = "SELECT komentar.ID, komentar.tekst, komentar.ocena, komentar.ID_korisnika FROM komentar INNER JOIN korisnik ON komentar.ID_korisnika = korisnik.ID INNER JOIN recept ON komentar.ID_recepta = recept.ID WHERE komentar.ID_recepta = '$idRecepta' ORDER BY komentar.ID ASC;";
						$rezultatBiranjaKomentara = mysqli_query($konekcija, $izaberiKomentar);
						if(mysqli_num_rows($rezultatBiranjaKomentara) > 0) {
							while($komentar = mysqli_fetch_assoc($rezultatBiranjaKomentara)) {
								$idKomentara = $komentar["ID"];
								$tekstKomentara = $komentar["tekst"];
								$ocena = $komentar["ocena"];
								$komentarIdKorisnika = $komentar["ID_korisnika"];
								static $brojKomentara = 0;
								$_SESSION["brojKomentara"] = $brojKomentara;
								
								echo "<div class=\"komentar\">
								<img src=\"";
								$izaberiSlikuKorisnika = "SELECT slika.putanja, korisnik.ime, korisnik.prezime FROM slika INNER JOIN korisnik ON slika.ID_korisnika = korisnik.ID INNER JOIN komentar ON komentar.ID_korisnika = korisnik.ID WHERE slika.ID_korisnika = $komentarIdKorisnika AND slika.vrsta = 'profilna' LIMIT 1;";
								$rezultatBiranjaSlikeKorisnika = mysqli_query($konekcija, $izaberiSlikuKorisnika);
								if(mysqli_num_rows($rezultatBiranjaSlikeKorisnika) > 0) {
									while($slikaKorisnika = mysqli_fetch_assoc($rezultatBiranjaSlikeKorisnika)) {
										$slikaTrenutnogKorisnika = $slikaKorisnika["putanja"];
										$imeTrenutnogKorisnika = $slikaKorisnika["ime"];
										$prezimeTrenutnogKorisnika = $slikaKorisnika["prezime"];
										echo $slikaTrenutnogKorisnika;
									}
								} else {
									echo $_SESSION["polKorisnika"] == "Musko" ? "slike/male_avatar.png" : "slike/female_avatar.png";
								}
								echo "\" alt=\"Profilna slika na komentaru\" />
								<div class=\"podaci_korisnika\">
									<img src=\"";
										if(isset($slikaTrenutnogKorisnika)) {
											echo $slikaTrenutnogKorisnika;
										} else {
											echo $_SESSION["polKorisnika"] == "Musko" ? "slike/male_avatar.png" : "slike/female_avatar.png";
										}
									echo "\" alt=\"Profilna slika u podacima korisnika\" /><br />
									<span id=\"podaci_ime\">$imeTrenutnogKorisnika</span><br /><span id=\"podaci_prezime\">$prezimeTrenutnogKorisnika</span>
								</div>
								<div id=\"tekst_kom\" >$tekstKomentara</div>
								<div id=\"ocena\">";
								switch($ocena) {
									case 1:
										echo "<img src=\"slike/1_star.png\" alt=\"1 zvezdica\" />";
										break;
									case 2:
										echo "<img src=\"slike/2_star.png\" alt=\"1 zvezdica\" />";
										break;
									case 3:
										echo "<img src=\"slike/3_star.png\" alt=\"1 zvezdica\" />";
										break;
									case 4:
										echo "<img src=\"slike/4_star.png\" alt=\"1 zvezdica\" />";
										break;
									case 5:
										echo "<img src=\"slike/5_star.png\" alt=\"1 zvezdica\" />";
										break;
								}
							echo "</div>
							</div>";
						$brojKomentara++;
					}
				}
				echo "</div>
				</div>";
			$brojRecepta++;
		}
	} else {
		echo "<h2 style=\"text-align: center;\">Nema rezultata</h2>";
	}
	
	mysqli_close($konekcija);
?>
		</main>
		<footer>
			<span>&copy; Copyright 2018-<span id="trenutna_godina"></span>. Sva prava zadržana</span>
			<address>
				Email: &#9993; milospetrovic008@gmail.com<br />
				Kontakt: &#9743; 063/XXX XX XX
			</address>
		</footer>
		<script src="pocetna/pocetna.js"></script>
		<script>
			for(var i = 0; <?php echo isset($_SESSION["brojRecepta"]) ? $_SESSION["brojRecepta"] + 1 : 0; ?> > i; i++) {
				document.getElementsByClassName("dugme_komentar")[i].addEventListener("click", function() {
					var x = parseInt(this.getAttribute("data-value"));
					if(document.getElementsByClassName("forma_dodaj_komentar")[x].style.height == "0%") {
						document.getElementsByClassName("forma_dodaj_komentar")[x].style.height = "55%";
						document.getElementsByTagName("main")[0].style.paddingBottom = "15%";
						var donjiRazmakRecepta = 150;
						document.getElementsByClassName("recept")[x].style.marginBottom = donjiRazmakRecepta + "px";
						document.getElementsByTagName("main")[0].style.paddingBottom = "2%";
						
						var recept = document.getElementsByClassName("recept")[x];
						var brojKomentara = recept.getElementsByClassName("komentar").length;
						
						for(var j = 0; brojKomentara > j; j++) {
							donjiRazmakRecepta += 105;
							document.getElementsByClassName("recept")[x].style.marginBottom = donjiRazmakRecepta + "px";
							if(x < <?php echo $_SESSION["brojRecepta"]; ?>) {
								document.getElementsByTagName("main")[0].style.paddingBottom = "2%";
							}
						}
					} else {
						document.getElementsByClassName("forma_dodaj_komentar")[x].style.height = "0%";
						document.getElementsByTagName("main")[0].style.paddingBottom = "2%";
						document.getElementsByClassName("tekst_komentara")[x].style.display = "none";
						document.getElementsByClassName("ocena_recepta")[x].style.display = "none";
						document.getElementsByClassName("label_ocena")[x].style.display = "none";
						document.getElementsByClassName("dugme_dodajte_komentar")[x].style.display = "none";
						document.getElementsByClassName("forma_dodaj_komentar")[x].childNodes[2].style.display = "none";
						
						var brojProslihKomentara = 0;
						for(var k = 0; x > k;) {
							x--;
							var recept = document.getElementsByClassName("recept")[x];
							var brojKomentara = recept.getElementsByClassName("komentar").length;
							brojProslihKomentara += brojKomentara;
						}
						x = parseInt(this.getAttribute("data-value"));
						var recept = document.getElementsByClassName("recept")[x];
						var brojKomentara = recept.getElementsByClassName("komentar").length;
						
						for(var j = 0; brojKomentara > j; j++) {
							document.getElementsByClassName("komentar")[j + brojProslihKomentara].style.display = "none";
							document.getElementsByTagName("main")[0].style.paddingBottom = "2%";
						}
					}
				});
			
				document.getElementsByClassName("forma_dodaj_komentar")[i].addEventListener("transitionend", function() {
					var x = parseInt(this.getAttribute("data-value"));
					
					if(this.style.height == "55%") {
						document.getElementsByClassName("tekst_komentara")[x].style.display = "block";
						document.getElementsByClassName("ocena_recepta")[x].style.display = "block";
						document.getElementsByClassName("label_ocena")[x].style.display = "inline";
						document.getElementsByClassName("dugme_dodajte_komentar")[x].style.display = "inline-block";
						var donjiRazmak = 25;
						var donjiRazmakForme = 100;
						var brojProslihKomentara = 0;
						for(var k = 0; x > k;) {
							x--;
							var recept = document.getElementsByClassName("recept")[x];
							var brojKomentara = recept.getElementsByClassName("komentar").length;
							brojProslihKomentara += brojKomentara;
						}
						x = parseInt(this.getAttribute("data-value"));
						var recept = document.getElementsByClassName("recept")[x];
						var brojKomentara = recept.getElementsByClassName("komentar").length;
						
						for(var j = 0; brojKomentara > j; j++) {
							this.childNodes[2].style.display = "block";
							document.getElementsByClassName("komentar")[j + brojProslihKomentara].style.display = "block";
							this.style.height = donjiRazmakForme + "%";
							donjiRazmak += 9;
							donjiRazmakForme += 40;
						}
					} else if(this.style.height == "0%") {
						document.getElementsByClassName("recept")[x].style.marginBottom = "0px";
					}
				});
			}
			
			for(var j = 0; <?php echo isset($_SESSION["brojKomentara"]) ? $_SESSION["brojKomentara"] + 1 : 0; ?> > j; j++) {
				document.getElementsByClassName("komentar")[j].childNodes[1].addEventListener("mouseover", function() {
					this.nextElementSibling.style.display = "block";
				});
				
				document.getElementsByClassName("komentar")[j].childNodes[1].addEventListener("mouseout", function() {
					this.nextElementSibling.style.display = "none";
				});
			}
		</script>
	</body>
</html>