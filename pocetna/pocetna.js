function prikaziDivAzuriraj() {
	document.getElementById("azuriraj_profilnu").style.display = "block";
}

function sakrijDivAzuriraj() {
	document.getElementById("azuriraj_profilnu").style.display = "none";
}

function prikaziFormuAzuriraj() {
	document.getElementById("forma_azuriraj").style.display = "block";
}

function prikaziFormuPromeniIme() {
	document.getElementById("forma_promeni_ime").style.display = "block";
}

document.getElementById("dugme_otkazi").addEventListener("mousedown", function() {
	this.style.borderBottom = "none";
	this.style.top = "115px";
});

document.getElementById("dugme_otkazi").addEventListener("mouseup" ,function() {
	this.style.borderBottom = "5px solid darkred";
	this.style.top = "110px";
	document.getElementById("forma_azuriraj").style.display = "none";
});

document.getElementById("dugme_otkazi2").addEventListener("mousedown", function() {
	this.style.borderBottom = "none";
	this.style.top = "160px";
});

document.getElementById("dugme_otkazi2").addEventListener("mouseup" ,function() {
	this.style.borderBottom = "5px solid darkred";
	this.style.top = "155px";
	document.getElementById("forma_promeni_ime").style.display = "none";
});

function aktiviranoDugmePosaljite(dugme) {
	dugme.style.borderBottom = "none";
	dugme.style.top = "115px";
	dugme.onmouseup = function() {
		this.style.borderBottom = "5px solid darkgreen";
		this.style.top = "110px";
	};
}

function aktiviranoDugmePromeni(dugme) {
	dugme.style.borderBottom = "none";
	dugme.style.top = "160px";
	dugme.style.backgroundColor = "#00cc00";
	dugme.onmouseup = function() {
		this.style.borderBottom = "5px solid darkgreen";
		this.style.top = "155px";
	};
}

if(document.getElementById("forma_azuriraj").childNodes[3].innerHTML == "") {
	document.getElementById("forma_azuriraj").childNodes[3].style.display = "none";
} else {
	document.getElementById("forma_azuriraj").childNodes[3].style.display = "block";
}

document.getElementById("azurirana_slika").addEventListener("change", function() {
	document.getElementById("odabrana").style.display = "block";
});

function unesiSlova() {
	var vrednostImena = document.promeniIme.novoIme.value;
	var vrednostPrezimena = document.promeniIme.novoPrezime.value;
	document.getElementById("ime_prezime").innerHTML = vrednostImena + " " + vrednostPrezimena;
}

function validacija() {
	var ime = promeniIme.novoIme.value;
	var prezime = promeniIme.novoPrezime.value;
	greska = false;
	
	if(ime == "") {
		greska = true;
		document.getElementById("g_ime").style.display = "block";
		document.getElementById("g_ime").innerHTML = "Popunite ovo polje.";
	} else if(/[0-9]/.test(ime)) {
		greska = true;
		document.getElementById("g_ime").style.display = "block";
		document.getElementById("g_ime").innerHTML = "Brojevi nisu dozvoljeni.";
	} else {
		document.getElementById("g_ime").style.display = "none";
	}
	if(prezime == "") {
		greska = true;
		document.getElementById("g_prezime").style.display = "block";
		document.getElementById("g_prezime").innerHTML = "Popunite ovo polje.";
	} else if(/[0-9]/.test(prezime)) {
		greska = true;
		document.getElementById("g_prezime").style.display = "block";
		document.getElementById("g_prezime").innerHTML = "Brojevi nisu dozvoljeni.";
	} else {
		document.getElementById("g_prezime").style.display = "none";
	}
	
	if(greska == true) {
		return false;
	}
}

function recValidacija() {
	var naziv = recept.nazivRecepta;
	var vreme = recept.vremePripremanja;
	var tekst = recept.tekstRecepta;
	var greska = false;
	
	if(naziv.value == "") {
		greska = true;
		naziv.style.borderColor = "red";
		naziv.placeholder = "Popunite ovo polje";
	} else {
		naziv.style.borderColor = "#cccccc";
		naziv.placeholder = "Naziv recepta";
	}
	if(vreme.value == "") {
		greska = true;
		vreme.style.borderColor = "red";
		vreme.placeholder = "Popunite ovo polje";
	} else {
		vreme.style.borderColor = "#cccccc";
		vreme.placeholder = "Vreme pripremanja";
	}
	if(tekst.value == "") {
		greska = true;
		tekst.style.border = "2px solid red";
		tekst.placeholder = "Popunite ovo polje.";
	} else {
		tekst.style.border = "none"
		tekst.placeholder = "Dodajte tekst recepta.";
	}
	
	if(greska == true) {
		return false;
	}
}

function komValidacija() {
	var tekst = komentar.tekstKomentara;
	var ocena = komentar.ocena;
	var greska = false;
	
	if(tekst.value == "") {
		greska = true;
		tekst.style.borderColor = "red";
		tekst.placeholder = "Popunite ovo polje.";
	} else {
		tekst.style.borderColor = "#cccccc";
		tekst.placeholder = "Dodajte komentar.";
	}
	if(ocena.value == "") {
		greska = true;
		ocena.style.borderColor = "red";
	} else {
		ocena.style.borderColor = "#cccccc";
	}
	
	if(greska == true) {
		return false;
	}
}

document.getElementById("receptna_slika").addEventListener("change", function() {
	document.getElementById("odabrana2").style.display = "block";
});

function izbrisiRecept(idRecepta, brojRecepta) {
	document.getElementsByClassName("recept")[brojRecepta].style.display = "none";
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "pocetna/izbrisiRecept.php?idRecepta=" + idRecepta, true);
	xmlHttp.send();
}

function izbrisiKomentar(idKomentara, brojKomentara) {
	document.getElementsByClassName("komentar")[brojKomentara].style.display = "none";
	var xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET", "pocetna/izbrisiKomentar.php?idKomentara=" + idKomentara, true);
	xmlHttp.send();
}