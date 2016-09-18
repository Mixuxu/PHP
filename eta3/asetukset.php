<!DOCTYPE HTML>
<html>
<head>
<?php
require_once "ilmoitusSaannot.php";

session_start();

if(isset($_SESSION["ilmoitus"])) {
	$ilmoitus = $_SESSION["ilmoitus"];

} else {

	$ilmoitus = new Ilmoitus();
	$nimiVirhe = 0;
}

if (isset ( $_POST ["laheta"] )) {
	setcookie("nimim", $_POST["nimimerkki"], time()+60*60*24*7);
	header ( "location: index.php" );

}

?>



<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Asetukset</title>
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
				<li><a href="#" class="sivulla">asetukset</a></li>
				<li><a href="json.php">JSON</a></li>
			</ul>

		</nav>

		<section id="etusivu">
			<article>
			<h2>Sivun asetukset</h2>
				<form action="asetukset.php" method="post" id="asetukset">
				<fieldset>
				
				<p>
					<label>Anna käyttäjänimi: </label> 
					<input type="text" name="nimimerkki" value="<?php if (isset($_COOKIE["nimim"]))echo $_COOKIE["nimim"]?>">
				</p>
				
				<p>
						<input type="submit" name="laheta" value="Muuta nimeä"> 
				</p>
				
				</fieldset>
				</form>
			</article>
		</section>
		<footer></footer>
	</div>
</body>
</html>