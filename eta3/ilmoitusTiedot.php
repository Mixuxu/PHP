<!DOCTYPE HTML>
<html>
<head>
<?php
require_once "ilmoitusSaannot.php";

session_start();

if (isset($_SESSION["ilmoitus"])) {
	$ilmoitus = $_SESSION["ilmoitus"];
}else {
	header("location: index.php");
	exit;
}
if (isset ( $_POST ["korjaa"] )) {
	header ( "location: ilmoitus.php" );
	exit ();
}elseif (isset ( $_POST ["peruuta"] )) {
	unset($_SESSION["ilmoitus"]);
	header ( "location: index.php" );
	exit ();
} elseif (isset ( $_POST ["tallenna"] )) {
	
	try {
		require_once "ilmoituspdo.php";
	
		$kanta = new ilmoituspdo(); 
		$id = $kanta->lisaaIlmoitus($ilmoitus);
		$ilmoitus->setId($id);
		$_SESSION["ilmoitus"]->setId($id);
	
	} catch ( Exception $error ) {
		header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage() );
		exit ;
	}
	
	
	unset($_SESSION["ilmoitus"]);
	header ( "location: tallennus.php" );
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
			<h2>Syötetyt tiedot</h2>
			<?php 
			print("<p>Nimi: " . $ilmoitus->getNimi());
			print("<br>Sukupuoli: " . $ilmoitus->getSukupuoli());
			print("<br>Sähköposti: " . $ilmoitus->getEmail());
			print("<br>Puhelin: " . $ilmoitus->getPuhnro());
			print("<br>Paikkakunta: " . $ilmoitus->getPaikkakunta());
			print("<br>Viesti: " . $ilmoitus->getViesti() . "</p>");
			?>
		</article>
		
		<form action="ilmoitusTiedot.php" method="post" id="ilmoitusTiedot">
			<p>
				<input type="submit" name="korjaa" value="Korjaa">
				<input type="submit" name="tallenna" value="Tallenna">
				<input type="submit" name="peruuta" value="Peruuta">
			</p>
		</form>
		</section>
		<footer></footer>
	</div>
</body>
</html>