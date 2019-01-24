<?php

	session_start();
	/*
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: zaloguj.php');
		exit();
	}
*/
	require_once "polaczenie.php";
	
	$polacz = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polacz->connect_errno!=0)
	{
		echo "Error: ".$polacz->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
			
		if($rezultat = @$polacz->query(sprintf("SELECT * FROM uzytkownicy WHERE login='%s' AND haslo='%s'",
		mysqli_real_escape_string($polacz,$login),
		mysqli_real_escape_string($polacz,$haslo))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['zalogowany'] = true;
			
				$wiersz=$rezultat->fetch_assoc();
				$_SESSION['id']=$wiersz['id'];
				$_SESSION['imie']=$wiersz['imie'];
				
				unset($_SESSION['blad']);
				$rezultat->free_result();
				header('Location: index.php');
			}
			else
			{
				$_SESSION['blad']='<span style="color: red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
			}
		}
		
		
		$polacz->close();
	}
	
?>