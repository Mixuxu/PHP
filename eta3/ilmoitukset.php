<!DOCTYPE HTML>
<html>
<head>
<?php
require_once "ilmoitusSaannot.php";
require_once "ilmoituspdo.php";
session_start();
if (isset ( $_POST ["nayta"] )) {
	
	setcookie("id", $_POST["id"], time()+60*60*24*7);
	
	header ( "location: naytaIlmoitus.php" );
	exit ();
}
if (isset ( $_POST ["poista"] )) {
	
	try {
		
		$kanta = new ilmoituspdo();
		$kanta->poistaIlmoitus($_POST ["id"]);

	} catch ( Exception $error ) {

		header ( "location: virhe.php?virhe=" . $error->getMessage () );
		exit ();
	}
	
	header ( "location: ilmoitukset.php" );
	exit ();
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ilmoitukset</title>
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
				<li><a href="#" class="sivulla">ilmoitukset</a></li>
				<li><a href="asetukset.php">asetukset</a></li>
				<li><a href="json.php">JSON</a></li>
			</ul>

		</nav>

		<section id="etusivu">
			<article>
			<h2>Uusia tuttavuuksia</h2>
				<p>Tältä sivulta löydät kaikki jätetyt hakuilmoitukset :)</p>
				
				<?php
				try {
					require_once "ilmoituspdo.php";
					$kanta = new ilmoituspdo();  
					$tulos = $kanta->haeKaikki();
					

					echo '<table>';
					
					foreach ($tulos as $ilmoitus) {
						
						echo sprintf('<tr><td>%s</td>  <td>%s</td> <td>%s</td> </tr>', $ilmoitus->getId(), $ilmoitus->getNimi(), $ilmoitus->getSukupuoli());
						
						echo '</table>';
						?>
						<form action="" method="post">
							<input type="hidden" name="id" value=<?php echo "'"; echo $ilmoitus->getId(); echo "'"; ?>>
							<input type="submit" name="nayta" value="Näytä">
							<input type="submit" name="poista" value="Poista">
						</form>
						<?php
						
					}
					

				} catch ( Exception $error ) {
					print("<p>Virhe: " . $error->getMessage ());
				}
				
				?>
				
				
			</article>
		</section>
		<footer></footer>
	</div>
</body>
</html>