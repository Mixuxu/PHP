<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>JSON</title>
<link href='http://fonts.googleapis.com/css?family=Piedra'
	rel='stylesheet' type='text/css'>
<link href="tyyli.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light'
	rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lobster'
	rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-2.2.3.min.js"
		integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="
		crossorigin="anonymous"></script>
</head>

<body>
	<div id="container">
		<header>
			<h1>Seuranhakupalsta THINDHER ;)</h1>
		</header>
		<nav>

			<ul>
				<li><a href="index.php">etusivu</a></li>
				<li><a href="ilmoitus.php">ilmoitus</a></li>
				<li><a href="ilmoitukset.php">ilmoitukset</a></li>
				<li><a href="asetukset.php">asetukset</a></li>
				<li><a href="#" class="sivulla">JSON</a></li>
			</ul>

		</nav>

		<section id="etusivu">
			<article>
			<h2>JSON Haku</h2>
				
				<form action="json.php" method="post">
				<p>
					<label>Sukupuoli haku:</label> 
					<select name="sukupuoli" id="sukupuoli">
							<option value="0"></option>
						  	<option value="mies">Mies</option>
						  	<option value="nainen">Nainen</option>
						  	<option value="muu">Muu</option>
					</select>
					<input type="submit" name="hae" value="Hae">
				</p>
			</form>
				<?php

				if (isset ( $_POST ["hae"]) && $_POST ["sukupuoli"] != "0") {
					
					try {
						require_once "ilmoituspdo.php";
						
						$kanta = new ilmoituspdo();
						$tulos = $kanta->jsonHaeSukupuolella($_POST ["sukupuoli"]);
						print (json_encode ( $tulos )) ;
					echo '<table>';
					
					foreach ($tulos as $ilmoitus) {
						
						echo sprintf('<tr><td>%s</td>  <td>%s</td> <td>%s</td> </tr>', $ilmoitus->getId(), $ilmoitus->getNimi(), $ilmoitus->getSukupuoli());
						
					}
					echo '</table>';
					
					
					} catch ( Exception $error ) {
						header ( "location: virhe.php?virhe=" . $error->getMessage () );
						exit ();
					}
				}
				?>
				
				
			</article>
		</section>
		<footer></footer>
	</div>
</body>
</html>
