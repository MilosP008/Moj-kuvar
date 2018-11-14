<?php
	session_start();
	session_destroy();
	header("Location: http://localhost/Projekat%20iz%20primenjenih%20baza%20podataka/index.php");
?>