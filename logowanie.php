<?php

	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
		
?>

<!DOCTYPE HTML5>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>logowanie</title>	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
</head>

<body>

	<div id="box">
	<?php
		
			if(isset($_SESSION['blad']))
			{
				echo $_SESSION['blad'];
			}
			
		?>
		<form action="zaloguj.php" method="post">
			<!--login:-->
			<input type="text" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" name="login">
			<!--</p>
			hasło:-->
			<input type="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" name="haslo">
			
			<input type="submit" value="Zaloguj się">
			
			<a href="rejestracja.php" class="but"><input type="button" value="Zarejestruj się"></a>
			
		</form>
			
		
	</div>
	
</body>
</html>