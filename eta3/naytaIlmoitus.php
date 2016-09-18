<!DOCTYPE HTML>
<html>
<head>
<?php
if (isset ( $_POST ["takaisin"] )) {
	header ( "location: ilmoitukset.php" );
	exit ();
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ilmoituksen tiedot</title>
<link href='http://fonts.googleapis.com/css?family=Piedra'
	rel='stylesheet' type='text/css'>
<link href="tyyli.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light'
	rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lobster'
	rel='stylesheet' type='text/css'>
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
				<li><a href="json.php">JSON</a></li>
			</ul>

		</nav>

		<section id="etusivu">
			<article>
			<h2>Ilmoituksen tiedot</h2>
			
			<?php
				try {
					require_once "ilmoituspdo.php";
			
					$kanta = new ilmoitusPDO();
					$tulos = $kanta->haeIlmoitus($_COOKIE["id"]);
					
					foreach ($tulos as $ilmoitus) {
						print("<p>Nimi: " . $ilmoitus->getNimi());
						print("<br>Sukupuoli: " . $ilmoitus->getSukupuoli());
						print("<br>Sähköposti: " . $ilmoitus->getEmail());
						print("<br>Puhelin: " . $ilmoitus->getPuhnro());
						print("<br>Paikkakunta: " . $ilmoitus->getPaikkakunta());
						print("<br>Viesti: " . $ilmoitus->getViesti() . "</p>");
					}
				
				} catch ( Exception $error ) {
					//print("Virhe: " . $error->getMessage());
					header ( "location: virhe.php?virhe=" . $error->getMessage () );
					exit ();
				}
			?>
		</article>
		
		<form action="naytaIlmoitus.php" method="post" id="naytaIlmoitus">
			<p>
				<input type="submit" name="takaisin" value="Takaisin">
			</p>
		</form>
		</section>
		<footer></footer>
	</div>
</body>
</html>