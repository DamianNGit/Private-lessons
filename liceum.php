<?php

	session_start();

		if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
?>

<!DOCTYPE HTML5>
<html lang="pl">

<head>

	<meta charset="utf-8"/>
	<title>szkoła ponadgimnazjalna</title>
	<meta name="description" content="Na tej stronie znajdziesz osoby, które chcą Ci pomóc w nauce i jak najlepiej przygotować Cię do opanowania materiału."/>
	<meta name="keywords" content="nauka, korepetycje, korki, testy, sprawdziany, egzaminy, matematyka, fizyka, chemia, polski, angielski, niemiecki, biologia, historia, wos, matura, szkoła, podstawówka, gimnazjum, liceum, nauczanie"/>

	
	<link rel="stylesheet" href="style.css" type="text/css" />
	
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>

</head>

<body>

	<div id="container">
	
		<div id="logo"><img src="img/logo.png" style="float: left;" alt="logo korepetycji"/>Korepetycje</div>
		<div style="clear: both;"></div>
		
		<div class="school"><i class="icon-edit"></i>Szkoła ponadgimnazjalna</div>
		
		<div class="menu">
			<ol>
				<li><a href="index.php">Strona główna</a></li>
				<li><a href="podstawowka.php">Szkoła podstawowa</a></li>				
				<li><a href="gimnazjum.php">Szkoła gimnazjalna</a></li>		
				<li><a href="inne.php">Szkolnictwo wyższe</a></li>
				<li><a href="wyloguj.php">Wyloguj</a></li>
			</ol>
			<div style="clear: both;"></div>
		</div>
		
		
		<div id="page">
		<div id="sidebar">
		<div class="Subjects"><a href=liceum.php class="but">Wszystkie</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=biologia class="but">Biologia</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=chemia class="but">Chemia</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=fizyka class="but">Fizyka</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=geografia class="but">Geografia</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=historia class="but">Historia</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=angielski class="but">J. angielski</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=polski class="but">J. polski</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=matematyka class="but">Matematyka</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=przedsiebiorczosc class="but">Przedsiębiorczość</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=po class="but">Przysposobienie obronne</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=infa class="but">Technologia informacyjna</a></div>
		<div class="Subjects"><a href=liceum.php?przedmiot=wos class="but">WOS</a></div>
		</form>
		</div>
		
		<div id="content">
			<span class="bigtitle">
			<?php
				echo "Witaj ".$_SESSION['imie']."!";
			?>
			</span>
			<div class="dottedline"></div>
			
			<?php
			
				require_once "polaczenie.php";
				
				$przedmiotget='';
					if (isset($_GET['przedmiot']))
					{
						$przedmiotget=$_GET['przedmiot'];
						$przedmiot=htmlspecialchars($przedmiotget);
					}
				
				$polacz = @new mysqli($host, $db_user, $db_password, $db_name);
				
				if($polacz->connect_errno!=0)
				{
					echo "Error: ".$polacz->connect_errno;
				}
				else
				{
					//obliczanie danych na potrzeby stronicowania
					$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
					$results_per_page = 3; //Liczba wyników na stronę
					$skip = (($cur_page - 1) * $results_per_page); //liczba pomijanych wierszy na potrzeby stronicowania

					$query = "SELECT * FROM ogloszenia WHERE szkola='liceum'";
					if ($przedmiotget != '') $query=$query."and przedmiot='".$przedmiotget."'";
				
					$data = mysqli_query($polacz, $query); //pobieramy wszystkie wiersze		
				
					$total = mysqli_num_rows($data); //liczba wierszy zapisana na potrzeby stronicowania
					$num_pages = ceil($total / $results_per_page); //określenie liczby stron
					$query .=  " LIMIT $skip, $results_per_page"; //dopisujemy do wcześniejszego zapytania, klauzule LIMIT
				 
					//wykonanie kwerendy
					$result = mysqli_query($polacz, $query);
			
					 echo "<p>";
					 echo "<table boder=\"1\"><tr>";
					 echo '<td style="border: solid 1px #ED0326; padding:10; width: 120px;"><strong>Zdjęcie</strong></td>';
						 echo '<td style="border: solid 1px #ED0326; padding:10; width: 400px;"><strong>Tresc</strong></td>';
						 echo '<td style="border: solid 1px #ED0326; padding:10; width: 100px;"><strong>Przedmiot</strong></td>';
						 echo '<td style="border: solid 1px #ED0326; padding:10; width: 170px;"><strong>Kontakt</strong></td>';
						 echo '<td style="border: solid 1px #ED0326; padding:10; width: 50px;"><strong>Stawka</strong></td>';
					 echo '</tr>';
			 
					while ( $row = mysqli_fetch_array($result) ) 
					{
						echo "</tr>";
						echo '<td style="border: solid 1px #ED0326; padding:20;">' . $row[6] . "</td>";
						echo '<td style="border: solid 1px #ED0326; padding:20;">' . $row[1] . "</td>";
						echo '<td style="border: solid 1px #ED0326; padding:20;">' . $row[3] . "</td>";
						echo '<td style="border: solid 1px #ED0326; padding:20;">' . $row[4] ."</td>";
						echo '<td style="border: solid 1px #ED0326; padding:20;">' . $row[5] . "</td>";
						echo "</tr>";
					}					
					echo "</table>";

					function generate_page_links($cur_page, $num_pages) 
					{
						 $page_links = '';
					 
						 // odnośnik do poprzedniej strony (-1)
						 if ($cur_page > 1) {
							  $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page - 1) . '">«</a> ';
						 }
					 
						 $i = $cur_page - 4;
						 $page = $i + 8;
					 
						 for ($i; $i <= $page; $i++) 
						 {
					 
							  if ($i > 0 && $i <= $num_pages) 
							  {
								   
								   //jeżeli jesteśmy na danej stronie to nie wyświetlamy jej jako link    
								   if ($cur_page == $i  && $i != 0) 
								   {
										$page_links .= '' . $i;
								   }
								   else 
								   {
					 
										//wyświetlamy odnośnik do 1 strony
										if ($i == ($cur_page - 4) && ($cur_page - 5) != 0) 
										{ 
											 $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=1">1</a> '; 
										}
								   
										//wyświetlamy "kropki", jako odnośnik do poprzedniego bloku stron
										if ($i == ($cur_page - 4) && (($cur_page - 6)) > 0) 
										{ 
											 $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page - 5) . '">...</a> '; 
										} 
								   
										//wyświetlamy liki do bieżących stron
										$page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . '"> ' . $i . '</a> ';
							  
										//wyświetlamy "kropki", jako odnośnik do następnego bloku stron
										if ($i == $page && (($cur_page + 4) - ($num_pages)) < -1) 
										{ 
											 $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page + 5) . '">...</a>'; 
										} 
								   
										//wyświetlamy odnośnik do ostatniej strony
										if ($i == $page && ($cur_page + 4) != $num_pages) 
										{ 
											 $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?page=' . $num_pages . '">' . $num_pages . '</a> '; 
										}
								   }
							  }
						 }
				 
						 //odnośnik do następnej strony (+1)
						 if ($cur_page < $num_pages) 
						 {
							  $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?page=' . ($cur_page + 1) . '">»</a>';
						 }
					 
						 return $page_links;
					}
					
					echo "<p>";
					//wyświetlanie nawigację przy stronnicowaniu
					if ($num_pages > 1) 
					{
						 echo generate_page_links($cur_page, $num_pages);
					}
				
				
					mysqli_close($polacz);
				
				}

			?>
			
		</div>
		<div style="clear: both;"></div>
		</div>
		
		
		
		<div id="footer">Korepetycje dla każdego. Wykonał: Damian Niemyjski. Wszystkie prawa zastrzeżone &copy;</div>
	
	</div>

</body>

</html>