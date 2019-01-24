<?php

	session_start();
	
	if(!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}

	//usuwanie zmiennych pamietajacych wpisane przez uzytkownika dane w formularzu logowania
	if(isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
	if(isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
	if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if(isset($_SESSION['fr_tel'])) unset($_SESSION['fr_tel']);
	if(isset($_SESSION['fr_login'])) unset($_SESSION['fr_login']);
	if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
		
	//usuwanie błędów rejestracji
	if(isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
	if(isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
	if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if(isset($_SESSION['e_tel'])) unset($_SESSION['e_tel']);
	if(isset($_SESSION['e_login'])) unset($_SESSION['e_login']);
	if(isset($_SESSION['e_haslo1'])) unset($_SESSION['e_haslo1']);
	if(isset($_SESSION['e_haslo2'])) unset($_SESSION['e_haslo2']);
	if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
	
?>

<!DOCTYPE HTML5>
<html lang="pl">

<head>

	<meta charset="utf-8"/>
	<title>Udana rejestracja</title>
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>

</head>

<body>

	<div id="container">
	
		<div id="logo"><img src="img/logo.png" style="float: left;" alt="logo korepetycji"/>Korepetycje</div>
		<div style="clear: both;"></div>
		
		<div id="box1">
		<span class="title" style="font-size: 25px;font-weight: bold;" >Dziękujemy za rejestrację</span>
		<p></p>
		<!--<span class="bigtitle">Dziękujemy za rejestrację	</span>
		<div class="dottedline"></div>-->
		
		<a href="logowanie.php" class="but"><input type="submit" value="Zaloguj się"></a>
		
		
		</div>
		<p>
		<p>
		<p>
		<p>
		
		<div id="footer">Korepetycje dla każdego. Wykonał: Damian Niemyjski. Wszystkie prawa zastrzeżone &copy;</div>
	
	</div>

</body>

</html>