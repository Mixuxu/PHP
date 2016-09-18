<?php
class Ilmoitus {
	private static $virhelista = array (
			- 1 => "Tarkista ja yritä uudelleen",
			0 => "",
			1 => "Nimi on pakollinen",
			2 => "Nimen tulee sisältää vain kirjaimia",
			3 => "Nimi on liian lyhyt",
			4 => "Nimi on liian pitkä",
			5 => "Valitse sukupuoli",
			6 => "Tarkista sähköpostiosoite",
			7 => "Paikkakunta on pakollinen",
			8 => "Paikkakunnassa ei voi olla numeroita tai erikoismerkkejä",
			9 => "Viesti on pakollinen",
			10 => "Viestin tulee sisältää yli 4 merkkiä",
			11 => "Viesti ei voi sisältää erikoismerkkejä",
			12 => "Viesti on liian pitkä",
			13 => "Numero on liian lyhyt",
			14 => "Numero on liian pitkä",
			15 => "Syötä vain numeroita"

	);

	public static function getError($virhe) {
		if (isset ( self::$virhelista [$virhe] ))
			return self::$virhelista [$virhe];

		return self::$virhelista [- 1];
	}
	
	private $nimi;
	private $sukupuoli;
	private $email;
	private $puhnro;
	private $paikkakunta;
	private $viesti;
	private $id;

	function __construct($nimi = "", $sukupuoli = "", $email = "", $puhnro = "", $paikkakunta = "", $viesti = "", $otsikko = "", $kuvaus = "", $id = 0) {
		$this->nimi = trim ( mb_convert_case ( $nimi, MB_CASE_TITLE, "UTF-8" ) );
		$this->sukupuoli = $sukupuoli;
		$this->email = trim ( $email );
		$this->puhnro = trim ( $puhnro );
		$this->paikkakunta = trim ( mb_convert_case ( $paikkakunta, MB_CASE_TITLE, "UTF-8" ) );
		$this->viesti = trim ( $viesti );
		$this->id = $id;
	}

	public function setNimi($nimi) {
		$this->nimi = trim ( $nimi );
	}

	public function getNimi() {
		return $this->nimi;
	}

	public function checkNimi($required = true, $min = 3, $max = 40) {

		if ($required == true && strlen ( $this->nimi ) == 0) {
			return 1;
		}

		if (preg_match ( "/[^a-zåäöA-ZÅÄÖ\- ]/", $this->nimi )) {
			return 2;
		}

		if (strlen ( $this->nimi) < $min) {
			return 3;
		}

		if (strlen ( $this->nimi ) > $max) {
			return 4;
		}

		return 0;
	}
	
	public function setSukupuoli($sukupuoli) {
		$this->sukupuoli = trim ( $sukupuoli );
	}
	
	public function getSukupuoli() {
		return $this->sukupuoli;
	}
	
	public function checkSukupuoli($required = true) {
	
		if (strpos ( $this->sukupuoli, "empty" ) !== false) {
			return 5;
		}
	
		return 0;
	}

	public function setEmail($email) {
		$this->email = trim ( $email );
	}

	public function getEmail() {
		return $this->email;
	}

	public function checkEmail($required = true) {
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			return 6;
		}
		
		return 0;
		
	}

	public function setPuhnro($puhnro) {
		$this->puhnro = trim ( $puhnro );
	}

	public function getPuhnro() {
		return $this->puhnro;
	}

	public function checkPuhnro($required = false) {
		if ($required == false && strlen ( $this->puhnro ) == 0) {
			return 0;
		}
		
		if (!preg_match ( "/^\+?\d+$/", $this->puhnro )) {
			return 15;
		}
		
		if (strlen ( $this->puhnro ) < 8) {
			return 13;
		}
			
		if (strlen ( $this->puhnro ) > 15) {
			return 14;
		}
			
		return 0;
		
		
	}

	public function setPaikkakunta($paikkakunta) {
		$this->paikkakunta = trim ( $paikkakunta );
	}

	public function getPaikkakunta() {
		return $this->paikkakunta;
	}

	public function checkPaikkakunta($required = true) {
		if ($required == false && strlen ( $this->paikkakunta ) == 0) {
			return 0;
		}

		if ($required == true && strlen ( $this->paikkakunta ) == 0) {
			return 7;
		}

		if (preg_match ( "/[^a-zåäöA-ZÅÄÖ\- ]/", $this->paikkakunta )) {
			return 8;
		}

		return 0;
	}


	public function setViesti($viesti) {
		$this->viesti = trim ( $viesti );
	}

	public function getViesti() {
		return $this->viesti;
	}

	public function checkViesti($required = true) {

		if ($required == true && strlen ( $this->viesti ) == 0) {
			return 9;
		}

		if (strlen ( $this->viesti ) < 4) {
			return 10;
		}

		if (strlen ( $this->viesti ) > 255) {
			return 12;
		}

		return 0;
	}

	public function setId($id) {
		$this->id = trim ( $id );
	}

	public function getId() {
		return $this->id;
	}
}
?>