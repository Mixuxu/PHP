<?php
require_once "ilmoitusSaannot.php";

session_start();

if (isset ( $_POST ["laheta"] )) {

	$ilmoitus = new Ilmoitus($_POST["nimi"], $_POST["sukupuoli"], $_POST["email"], $_POST["puhnro"], $_POST["paikkakunta"], $_POST["viesti"]);

	$_SESSION["ilmoitus"] = $ilmoitus;
	session_write_close();

	$nimiVirhe = $ilmoitus->checkNimi();
	$sukupuoliVirhe = $ilmoitus->checkSukupuoli();
	$emailVirhe = $ilmoitus->checkEmail ();
	$puhnroVirhe = $ilmoitus->checkPuhnro ( false );
	$paikkakuntaVirhe = $ilmoitus->checkPaikkakunta();
	$viestiVirhe = $ilmoitus->checkViesti ();
	
	if ($nimiVirhe == 0 && $sukupuoliVirhe == 0 && $emailVirhe == 0 && $puhnroVirhe == 0 && $paikkakuntaVirhe == 0 && $viestiVirhe == 0) {
		header("location: ilmoitusTiedot.php");
		exit;
	}
	
} 
elseif (isset ( $_POST ["peruuta"] )) {
	unset($_SESSION["ilmoitus"]);
	header ( "location: index.php" );
	exit ();
} 
else {
	
	if(isset($_SESSION["ilmoitus"])) {
		$ilmoitus = $_SESSION["ilmoitus"];
		$nimiVirhe = $ilmoitus->checkNimi();
		$sukupuoliVirhe = $ilmoitus->checkSukupuoli();
		$emailVirhe = $ilmoitus->checkEmail ();
		$puhnroVirhe = $ilmoitus->checkPuhnro ( false );
		$paikkakuntaVirhe = $ilmoitus->checkPaikkakunta();
		$viestiVirhe = $ilmoitus->checkViesti ();
	} else {
	
	$ilmoitus = new Ilmoitus();
	$nimiVirhe = 0;
	$sukupuoliVirhe = 0;
	$emailVirhe = 0;
	$puhnroVirhe = 0;
	$paikkakuntaVirhe = 0;
	$viestiVirhe = 0;
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ilmoitus</title>
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
				<li><a href="#" class="sivulla">ilmoitus</a></li>
				<li><a href="ilmoitukset.php">ilmoitukset</a></li>
				<li><a href="asetukset.php">asetukset</a></li>
			</ul>

		</nav>

		<section id="etusivu">
			<article>
				<h2>Jätä seuranhakuilmoitus</h2>
				
				<form action="ilmoitus.php" method="post" id="ilmoitus">
				
				<fieldset>

					<legend>Ilmoittajan tiedot (tähdellä merkityt kentät ovat pakollisia)</legend>
					<p>
						<label>Nimi</label> 
						<input type="text" name="nimi" value="<?php print(htmlentities($ilmoitus->getNimi(), ENT_QUOTES, "UTF-8"));?>">
						<span style="color: #B94A48"> *</span>
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $nimiVirhe ));'</span>'
						?>	
					</p>
					
					<p>
						<label>Sukupuoli</label> 
						<select name="sukupuoli" id="sukupuoli">
							<option value="empty" <?php if(!isset($_POST['sukupuoli'])) echo 'selected' ?>></option>
						  	<option value="mies" <?php if($ilmoitus->getSukupuoli()=='mies') echo 'selected' ?>>Mies</option>
						  	<option value="nainen" <?php if($ilmoitus->getSukupuoli()=='nainen') echo 'selected' ?>>Nainen</option>
						  	<option value="muu" <?php if($ilmoitus->getSukupuoli()=='muu') echo 'selected' ?>>Muu</option>
						</select>
						<span style="color: #B94A48"> *</span>
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $sukupuoliVirhe ));'</span>'
						?>
					</p>
					
					<p>
						<label>Sähköposti</label> 
						<input type="email" name="email" value="<?php print(htmlentities($ilmoitus->getEmail(), ENT_QUOTES, "UTF-8"));?>">
						<span style="color: #B94A48"> *</span>
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $emailVirhe ));'</span>'
						?>
					</p>

					<p>
						<label>Puhelinnumero</label> 
						<input type="text" name="puhnro" value="<?php print(htmlentities($ilmoitus->getPuhnro(), ENT_QUOTES, "UTF-8"));?>">
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $puhnroVirhe ));'</span>'
						?>
					</p>


					<p>
						<label>Paikkakunta</label> 
						<input type="text" name="paikkakunta" value="<?php print(htmlentities($ilmoitus->getPaikkakunta(), ENT_QUOTES, "UTF-8"));?>">
						<span style="color: #B94A48"> *</span>
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $paikkakuntaVirhe ));'</span>'
						?>
					</p>
					
					<p>
						<label>Viesti: <span style="color: #B94A48">*</span></label>
						<?php
						print ('<span style="color:red">'. $ilmoitus->getError ( $viestiVirhe ));'</span>'
						?>
						
					</p>
						<textarea name="viesti" form="ilmoitus" rows="5" cols="65"><?php print(htmlentities($ilmoitus->getViesti(), ENT_QUOTES, "UTF-8"));?></textarea>
					
					
					<p>
						<input type="submit" name="laheta" value="Lähetä"> 
						<input type="submit" name="peruuta" value="Peruuta">
					</p>

				</fieldset>
				</form>
				<p></p>
			</article>
		</section>
		<footer></footer>
	</div>
</body>
</html>


