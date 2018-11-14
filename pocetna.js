var datum = new Date();
document.getElementById("trenutna_godina").innerHTML = datum.getFullYear();

if(document.getElementById("g_email").innerHTML != "") {
	document.getElementsByClassName("greska")[4].style.display = "block";
}

function aktiviranoDugmeZaRegistraciju(dugme) {
	dugme.style.position = "absolute";
	dugme.style.borderBottom = "none";
	dugme.style.top = "345px";
	dugme.style.right = "0px";
	dugme.onmouseup = function() {
		this.style.position = "static";
		this.style.borderBottom = "5px solid darkgreen";
	};
}

function aktiviranoDugmeZaPrijavu(dugme) {
	dugme.style.position = "absolute";
	dugme.style.borderBottom = "none";
	dugme.style.top = "141px";
	dugme.style.right = "0px";
	dugme.onmouseup = function() {
		this.style.position = "static";
		this.style.borderBottom = "5px solid darkgreen";
	};
}

function regValidacija() {
	var ime = document.registracija.ime.value;
	var prezime = document.registracija.prezime.value;
	var email = document.registracija.email.value;
	var sifra = document.registracija.sifra.value;
	var sifra2 = document.registracija.sifra2.value;
	var pol = document.registracija.pol;
	var greska = false;
	
	if(!document.getElementById("povratna_greska") == null) {
		document.getElementById("povratna_greska").style.display = "none";
	}
	
	if(ime == "") {
		greska = true;
		document.getElementsByClassName("greska")[2].style.display = "block";
		document.getElementsByClassName("greska")[2].innerHTML = "Popunite ovo polje.";
	} else if(/[0-9]/.test(ime)) {
		greska = true;
		document.getElementsByClassName("greska")[2].style.display = "block";
		document.getElementsByClassName("greska")[2].innerHTML = "Brojevi nisu dozvoljeni.";
	} else {
		document.getElementsByClassName("greska")[2].style.display = "none";
	}
	if(prezime == "") {
		greska = true;
		document.getElementsByClassName("greska")[3].style.display = "block";
		document.getElementsByClassName("greska")[3].innerHTML = "Popunite ovo polje.";
	} else if(/[0-9]/.test(prezime)) {
		greska = true;
		document.getElementsByClassName("greska")[3].style.display = "block";
		document.getElementsByClassName("greska")[3].innerHTML = "Brojevi nisu dozvoljeni.";
	} else {
		document.getElementsByClassName("greska")[3].style.display = "none";
	}
	if(email == "") {
		greska = true;
		document.getElementsByClassName("greska")[4].style.display = "block";
		document.getElementsByClassName("greska")[4].innerHTML = "Popunite ovo polje.";
	} else if(!(/([\w\.-]+)@([\w\.-]+)(\.[\w\.]+)/.test(email))) {
		greska = true;
		document.getElementsByClassName("greska")[4].style.display = "block";
		document.getElementsByClassName("greska")[4].innerHTML = "Email adresa nije validna.";
	} else {
		document.getElementsByClassName("greska")[4].style.display = "none";
	}
	if(sifra == "") {
		greska = true;
		document.getElementsByClassName("greska")[5].style.display = "block";
		document.getElementsByClassName("greska")[5].innerHTML = "Popunite ovo polje.";
	} else if(!(/[0-9]/.test(sifra))) {
		greska = true;
		document.getElementsByClassName("greska")[5].style.display = "block";
		document.getElementsByClassName("greska")[5].innerHTML = "Šifra mora imati brojeve.";
	} else if(!(/[A-Za-z]/.test(sifra))) {
		greska = true;
		document.getElementsByClassName("greska")[5].style.display = "block";
		document.getElementsByClassName("greska")[5].innerHTML = "Šifra mora imati slova.";
	} else {
		document.getElementsByClassName("greska")[5].style.display = "none";
	}
	if(sifra != sifra2) {
		greska = true;
		document.getElementsByClassName("greska")[6].style.display = "block";
		document.getElementsByClassName("greska")[6].innerHTML = "Šifra nije jednaka.";
	} else {
		document.getElementsByClassName("greska")[6].style.display = "none";
	}
	if(pol[0].checked == false && pol[1].checked == false) {
		greska = true;
		pol[0].parentNode.style.border = "1px solid red";
		pol[1].parentNode.style.border = "1px solid red";
		pol[0].parentNode.style.color = "red";
		pol[1].parentNode.style.color = "red";
	} else {
		pol[0].parentNode.style.border = "none";
		pol[1].parentNode.style.border = "none";
		pol[0].parentNode.style.color = "black";
		pol[1].parentNode.style.color = "black";
	}
	
	if(greska == true) {
		return false;
	}
}

function priValidacija() {
	var email = document.prijava.p_email.value;
	var sifra = document.prijava.p_sifra.value;
	var greska = false;
	
	if(!document.getElementById("povratna_greska") == null) {
		document.getElementById("povratna_greska").style.display = "none";
	}
	
	if(email == "") {
		greska = true;
		document.getElementsByClassName("greska")[0].style.display = "block";
		document.getElementsByClassName("greska")[0].innerHTML = "Popunite ovo polje.";
	} else if(!(/([\w\.-]+)@([\w\.-]+)(\.[\w\.]+)/.test(email))) {
		greska = true;
		document.getElementsByClassName("greska")[0].style.display = "block";
		document.getElementsByClassName("greska")[0].innerHTML = "Email adresa nije validna.";
	} else {
		document.getElementsByClassName("greska")[0].style.display = "none";
	}
	if(sifra == "") {
		greska = true;
		document.getElementsByClassName("greska")[1].style.display = "block";
		document.getElementsByClassName("greska")[1].innerHTML = "Popunite ovo polje.";
	} else if(!(/[0-9]/.test(sifra))) {
		greska = true;
		document.getElementsByClassName("greska")[1].style.display = "block";
		document.getElementsByClassName("greska")[1].innerHTML = "Šifra mora imati brojeve.";
	} else if(!(/[A-Za-z]/.test(sifra))) {
		greska = true;
		document.getElementsByClassName("greska")[1].style.display = "block";
		document.getElementsByClassName("greska")[1].innerHTML = "Šifra mora imati slova.";
	} else {
		document.getElementsByClassName("greska")[1].style.display = "none";
	}
	
	if(greska == true) {
		return false;
	}
}