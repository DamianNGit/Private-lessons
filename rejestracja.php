<?php

	session_start();
	
	if((isset($_POST['imie'])) && 
	(isset($_POST['nazwisko'])) && 
	(isset($_POST['email'])) && 
	(isset($_POST['tel'])) && 
	(isset($_POST['login'])) &&
	(isset($_POST['haslo1'])) &&
	(isset($_POST['haslo2'])))
	{
		// udana walidacja
		$wszystko_ok=true;
		
		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$email = $_POST['email'];
		$login = $_POST['login'];
		$tel = $_POST['tel'];
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if((strlen($imie)<3) || (strlen($imie)>20))
		{
			$wszystko_ok=false;
			$_SESSION['e_imie']="Imię nie może być krótsze niż 3 znaki i dłuższe niż 20 znaków";
		}
		
		if (preg_match('/^[\p{Latin}]+$/u',$imie)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_imie']="Imię może składać się tylko z liter";
		}
		
		if((strlen($nazwisko)<3) || (strlen($nazwisko)>30))
		{
			$wszystko_ok=false;
			$_SESSION['e_nazwisko']="Nazwisko nie może być krótsze niż 3 znaki i dłuższe niż 30 znaków";
		}
		
		if (preg_match('/^[\p{Latin}]+$/u',$nazwisko)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_nazwisko']="Nazwisko może składać się tylko z liter";
		}
		
		if((strlen($email)<6) || (strlen($email)>50))
		{
			$wszystko_ok=false;
			$_SESSION['e_email']="Podaj adres e-mail!";
		}
		
		if((strlen($login)<3) || (strlen($login)>20))
		{
			$wszystko_ok=false;
			$_SESSION['e_login']="Login nie może być krótszy niż 3 znaki i dłuższy niż 20 znaków";
		}
		
		if (ctype_alnum($login)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_login']="Login może składać się tylko z cyfr i liter(bez polskich znaków)";
		}
		
		if((strlen($tel)<9) || (strlen($tel)>9))
		{
			$wszystko_ok=false;
			$_SESSION['e_tel']="Telefon musi mieć 9 cyfr";
		}
		
		if (ctype_digit($tel)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_tel']="Telefon może składać się tylko z cyfr";
		}
		
		if((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_ok=false;
			$_SESSION['e_haslo']="Hasło nie może być krótsze niż 8 znaków i dłuższe niż 20 znaków";
		}
		
		if (ctype_alnum($haslo1)==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_haslo']="Hasło może składać się tylko z cyfr i liter(bez polskich znaków)";
		}
		
		if($haslo1!=$haslo2)
		{
			$wszystko_ok=false;
			$_SESSION['e_haslo1']="Podane hasła nie są identyczne!";
		}
		
		if(!isset($_POST['regulamin']))
		{
			$wszystko_ok=false;
			$_SESSION['e_regulamin']="Zaakceptuj regulamin!";
		}
		
		$boty = "6LfjgA4UAAAAANjvFGOxiR7AjntHRW4aBbTph0KM";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$boty.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($check);
		
		if($odpowiedz->success==false)
		{
			$wszystko_ok=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}
		
		//zapamiętanie danych w formularzu
		$_SESSION['fr_imie']=$imie;
		$_SESSION['fr_nazwisko']=$nazwisko;
		$_SESSION['fr_email']=$email;
		$_SESSION['fr_tel']=$tel;
		$_SESSION['fr_login']=$login;
		$_SESSION['fr_haslo1']=$haslo1;
		$_SESSION['fr_haslo2']=$haslo2;
		if(isset($_POST['regulamin'])) $_SESSION['fr_regulamin']=true;
		
		//sprawdzenie loginu i hasła
		
		//łączenie z baza
		require_once "polaczenie.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try
		{
			$polacz = new mysqli($host, $db_user, $db_password, $db_name);
			if($polacz->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//czy e-mail już istnieje
				$rezultat = $polacz->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polacz->error);
				
				$ile_maile=$rezultat->num_rows;
				if($ile_maile>0)
				{
					$wszystko_ok=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail";
				}
				
				//czy login już istnieje
				$rezultat = $polacz->query("SELECT id FROM uzytkownicy WHERE login='$login'");
				
				if (!$rezultat) throw new Exception($polacz->error);
				
				$ile_loginow=$rezultat->num_rows;
				if($ile_loginow>0)
				{
					$wszystko_ok=false;
					$_SESSION['e_login']="Podany login już istnieje!";
				}
				
				if($wszystko_ok==true)
				{
					if($polacz->query("INSERT INTO uzytkownicy VALUES (NULL,'$imie','$nazwisko', '$email', '$tel', '$login', '$haslo2')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: zalogowany.php');
					}
					else
					{
						throw new Exception($polacz->error);
					}
					
					
					exit();
				}
				
				$polacz->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color: red;">Błąd serwera! Przeprszamy. Spróbuj ponownie później</span>';
			//echo '<br/>Informacja developerska o błędzie: '.$e;
		}
		
	}

?>

<!DOCTYPE HTML5>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>rejestracja</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
</head>

<body>

	<div id="box1">
		<!--<form action="#" method="post">-->
		<form method="post">
			<!--login:-->
			<input type="text" placeholder="Imię" onfocus="this.placeholder=''" onblur="this.placeholder='Imię'" name="imie" value="<?php 
			if(isset($_SESSION['fr_imie']))
			{
				echo $_SESSION['fr_imie'];
				unset($_SESSION['fr_imie']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_imie']))
				{
					echo '<span style="color: red">'.$_SESSION['e_imie'].'</span>';
					unset($_SESSION['e_imie']);
				}
			?>
			<!--</p>
			hasło:-->
			<input type="text" placeholder="Nazwisko" onfocus="this.placeholder=''" onblur="this.placeholder='Nazwisko'" name="nazwisko" value="<?php 
			if(isset($_SESSION['fr_nazwisko']))
			{
				echo $_SESSION['fr_nazwisko'];
				unset($_SESSION['fr_nazwisko']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_nazwisko']))
				{
					echo '<span style="color: red">'.$_SESSION['e_nazwisko'].'</span>';
					unset($_SESSION['e_nazwisko']);
				}
			?>
			
			<input type="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'" name="email" value="<?php 
			if(isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_email']))
				{
					echo '<span style="color: red">'.$_SESSION['e_email'].'</span>';
					unset($_SESSION['e_email']);
				}
			?>
			
			<input type="text" placeholder="Nr telefonu" onfocus="this.placeholder=''" onblur="this.placeholder='Nr telefonu'" name="tel" value="<?php 
			if(isset($_SESSION['fr_tel']))
			{
				echo $_SESSION['fr_tel'];
				unset($_SESSION['fr_tel']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_tel']))
				{
					echo '<span style="color: red">'.$_SESSION['e_tel'].'</span>';
					unset($_SESSION['e_tel']);
				}
			?>
			
			<input type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" name="login" value="<?php 
			if(isset($_SESSION['fr_login']))
			{
				echo $_SESSION['fr_login'];
				unset($_SESSION['fr_login']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_login']))
				{
					echo '<span style="color: red">'.$_SESSION['e_login'].'</span>';
					unset($_SESSION['e_login']);
				}
			?>

			<input type="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" name="haslo1" value="<?php 
			if(isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_haslo']))
				{
					echo '<span style="color: red">'.$_SESSION['e_haslo'].'</span>';
					unset($_SESSION['e_haslo']);
				}
			?>
			
			<input type="password" placeholder="Potwierdź hasło" onfocus="this.placeholder=''" onblur="this.placeholder='Potwierdź hasło'" name="haslo2" value="<?php 
			if(isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
			?>">
			
			<?php
				if(isset($_SESSION['e_haslo1']))
				{
					echo '<span style="color: red">'.$_SESSION['e_haslo1'].'</span>';
					unset($_SESSION['e_haslo1']);
				}
			?>
			
			<label><p><input type="checkbox" name="regulamin" <?php 
			if(isset($_SESSION['fr_regulamin']))
			{
				echo "checked";
				unset($_SESSION['fr_regulamin']);
			}
			?>> Akceptuję </label><a href="regulamin.html">regulamin</a></input>
			
			<?php
				if(isset($_SESSION['e_regulamin']))
				{
					echo '<span style="color: red">'.$_SESSION['e_regulamin'].'</span>';
					unset($_SESSION['e_regulamin']);
				}
			?>
			
			<div class="g-recaptcha" data-sitekey="6LfjgA4UAAAAAP0JMUjFyIIrDq3JthH6RLs0Rm1j"></div>
			
			<?php
				if(isset($_SESSION['e_bot']))
				{
					echo '<span style="color: red">'.$_SESSION['e_bot'].'</span>';
					unset($_SESSION['e_bot']);
				}
			?>

			<input type="submit" value="Zarejestruj się">
			</a>
					
		</form>
	</div>
	
</body>
</html>