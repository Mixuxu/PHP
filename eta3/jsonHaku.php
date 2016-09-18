<?php
try {
	require_once "ilmoituspdo.php";

	$kanta = new ilmoituspdo();
	$tulos = $kanta->jsonHaeSukupuolella($_POST ["sukupuoli"]);
	print (json_encode ( $tulos )) ;
		
		
} catch ( Exception $error ) {
	$tulos["message"] = "Haku ei onnistu";
	print (json_encode ( $tulos )) ;
}
?>