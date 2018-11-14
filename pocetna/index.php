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
			<nav>
				<ul>
					<li><a href="#" id="aktiviran">Početna</a></li>
					<li><a href="#">Link2</a></li>
					<li><a href="#">Link3</a></li>
					<li><a href="#">Link4</a></li>
					<li><a href="#">Link5</a></li>
				</ul>
			</nav>
			<section>
				<div id="okvir_korisnika">
					<img src="<?php
						$imeServera = "localhost";
						$korisnickoIme = "root";
						$korisnickaSifra = "";
						$imeBazePodataka = "moj_kuvar";
						$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka) or die("Konekcija nije uspela.");
						$emailKorisnika = $_SESSION["emailKorisnika"];
						//Izaberi sliku
						$izaberiSliku = "SELECT putanja FROM slika INNER JOIN korisnik ON korisnik.id = slika.id_korisnika WHERE email = '$emailKorisnika' AND slika.vrsta = 'profilna';";
						$rezultat = mysqli_query($konekcija, $izaberiSliku);
						if(mysqli_num_rows($rezultat) > 0) {
							$putanjaSlike = array();
							while($podaciSlike = mysqli_fetch_assoc($rezultat)) {
								array_push($putanjaSlike, $podaciSlike["putanja"]);
							}
							$_SESSION["direktorijumSlike"] = $putanjaSlike[count($putanjaSlike) - 1];
						}
						mysqli_close($konekcija);
						if(isset($_SESSION["direktorijumSlike"])) {
							echo $_SESSION["direktorijumSlike"];
						} else {
							echo $_SESSION["polKorisnika"] == "Musko" ? "slike/male_avatar.png" : "slike/female_avatar.png";
						}
					?>" alt="Profilna slika" onmouseover="prikaziDivAzuriraj()" onmouseout="sakrijDivAzuriraj()" />
					<div id="azuriraj_profilnu" onmouseover="prikaziDivAzuriraj()" onmouseout="sakrijDivAzuriraj()" onclick="prikaziFormuAzuriraj()">Ažuriraj sliku</div>
					<div id="informacije_korisnika">
						<span><?php echo $_SESSION["imeKorisnika"]; ?> <?php echo $_SESSION["prezimeKorisnika"]; ?> <img src="slike/note_icon.png" alt="Promeni ime" onclick="prikaziFormuPromeniIme()" /></span>
						<form action="pocetna/pretraziRecepte.php" method="post" id="forma_pretrazi_recepte">
							<input type="search" name="pretraga" placeholder="Pronađite recept..." />
							<button type="submit"><i class="fa fa-search"></i></button>
						</form>
						<form action="pocetna/odjava.php" method="post">
							<input type="submit" value="Odjavite se" id="odjava" />
						</form>
					</div>
					<div id="forma_azuriraj">
						<form action="pocetna/azurirajSliku.php" method="post" enctype="multipart/form-data">
							<input type="file" name="azuriranaSlika" id="azurirana_slika" />
							<label for ="azurirana_slika" id="dugme_odaberi">Odaberite sliku</label>
							<input type="button" value="Otkažite" id="dugme_otkazi" />
							<input type="submit" value="Pošaljite" id="dugme_posalji" onmousedown="aktiviranoDugmePosaljite(this)" />
						</form>
						<span><?php
							if(isset($_SESSION["greskaPriAzuriranju"])) {
								echo $_SESSION["greskaPriAzuriranju"];
							}
						?></span>
						<div id="odabrana" >Slika je odabrana</div>
					</div>
					<div id="forma_promeni_ime">
						<form action="pocetna/promeniIme.php" method="post" name="promeniIme" onsubmit="return validacija()">
							<label for="novo_ime">Novo ime: </label>
							<div class="greska" id="g_ime"></div>
							<input type="text" name="novoIme" id="novo_ime" placeholder="Ime" onkeyup="unesiSlova()" /><br />
							<label for="novo_prezime">Novo prezime: </label>
							<div class="greska" id="g_prezime"></div>
							<input type="text" name="novoPrezime" id="novo_prezime" placeholder="Prezime" onkeyup="unesiSlova()" /><br />
							<input type="button" value="Otkažite" id="dugme_otkazi2" />
							<input type="submit" value="Promenite" id="dugme_promeni" onmousedown="aktiviranoDugmePromeni(this)" />
						</form>
						<div>Vaše novo ime i prezime je: <span id="ime_prezime" ></span></div>
					</div>
				</div>
			</section>
			<section>
				<div id="forma_dodaj_recept">
					<form action="pocetna/dodajRecept.php" method="post" enctype="multipart/form-data" name="recept" onsubmit="return recValidacija()">
						<input type="text" name="nazivRecepta" placeholder="Naziv recepta" />
						<input type="number" name="vremePripremanja" min="0" max="500" placeholder="Vreme pripremanja" />
						<textarea name="tekstRecepta" placeholder="Dodajte tekst recepta." rows="4" ></textarea>
						<input type="file" name="receptnaSlika" id="receptna_slika" />
						<label for="receptna_slika" id="dugme_odaberi2">Odaberite sliku</label>
						<input type="submit" value="Dodajte recept" id="dugme_dodajte_recept" />
					</form>
					<div id="odabrana2" >Slika je odabrana</div>
				</div>
				<?php
					$imeServera = "localhost";
					$korisnickoIme = "root";
					$korisnickaSifra = "";
					$imeBazePodataka = "moj_kuvar";
					$idKorisnika = $_SESSION["idKorisnika"];
					
					$konekcija = mysqli_connect($imeServera, $korisnickoIme, $korisnickaSifra, $imeBazePodataka) or die("Konekcija nije uspela.");
					$izaberiRecept = "SELECT recept.ID, recept.naziv, recept.tekst, recept.vreme_pripreme, recept.ID_korisnika, recept.ID_slike FROM recept INNER JOIN korisnik ON recept.ID_korisnika = korisnik.ID WHERE recept.ID_korisnika = '$idKorisnika' ORDER BY recept.ID ASC;";
					$rezultatBiranjaRecepata = mysqli_query($konekcija, $izaberiRecept);
					
					if(mysqli_num_rows($rezultatBiranjaRecepata) > 0) {
						while($recept = mysqli_fetch_assoc($rezultatBiranjaRecepata)) {
							$idRecepta = $recept["ID"];
							$naziv = $recept["naziv"];
							$tekst = $recept["tekst"];
							$vremePripreme = $recept["vreme_pripreme"];
							$receptIdKorisnika = $recept["ID_korisnika"];
							$idSlike = $recept["ID_slike"];
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
							echo   "<div id=\"naziv_recepta\" >$naziv <span class=\"dugme_izbrisi_recept\" onclick=\"izbrisiRecept($idRecepta, $brojRecepta)\">x</span></div>
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
												<div class=\"dugme_izbrisi_komentar\" onclick=\"izbrisiKomentar($idKomentara, $brojKomentara)\">x</div>
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
					}
					mysqli_close($konekcija);
				?>
			</section>
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