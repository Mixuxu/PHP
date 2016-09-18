<?php
require_once "ilmoitusSaannot.php";

class ilmoituspdo {
	private $db;
	private $lkm;
	
	function __construct($dsn = "mysql:host=localhost;dbname=a1400157", $user = "root", $password = "salainen") {
		$this->db = new PDO ( $dsn, $user, $password );
		
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
		
		$this->lkm = 0;
	}
	
	function getLkm() {
		return $this->lkm;
	}
	
	public function haeKaikki() {
		$sql = "SELECT * FROM ilmoitus";
		
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {

			$ilmoitus = new Ilmoitus ();
			
			$ilmoitus->setId ( $row->id );
			$ilmoitus->setNimi( utf8_encode ( $row->nimi ) );
			$ilmoitus->setSukupuoli( utf8_encode ( $row->sukupuoli ) );
			$ilmoitus->setEmail( utf8_encode ( $row->email ) );
			$ilmoitus->setPuhnro( $row->puh );
			$ilmoitus->setPaikkakunta( utf8_encode ( $row->paikkakunta ) );
			$ilmoitus->setViesti( utf8_encode ( $row->viesti ) );
			
			$tulos [] = $ilmoitus;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
	public function haeIlmoitus($id) {
		$sql = "SELECT *
		        FROM ilmoitus
				WHERE id = :id";
		
		// Valmistellaan lause, prepare on PDO-luokan metodeja
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Sidotaan parametrit
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
		
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {
			// Tehdään tietokannasta haetusta rivistä leffa-luokan olio
			$ilmoitus = new Ilmoitus ();
			
			$ilmoitus->setId ( $row->id );
			$ilmoitus->setNimi( utf8_encode ( $row->nimi ) );
			$ilmoitus->setSukupuoli( utf8_encode ( $row->sukupuoli ) );
			$ilmoitus->setEmail( utf8_encode ( $row->email ) );
			$ilmoitus->setPuhnro( $row->puh );
			$ilmoitus->setPaikkakunta( utf8_encode ( $row->paikkakunta ) );
			$ilmoitus->setViesti( utf8_encode ( $row->viesti ) );
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $ilmoitus;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
	public function jsonHaeSukupuolella($sukupuoli) {
		$sql = "SELECT *
		        FROM ilmoitus
				WHERE sukupuoli = :sukupuoli";
	
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		$stmt->bindValue ( ":sukupuoli", $sukupuoli, PDO::PARAM_STR );
	
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
				
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		$tulos = array ();
	
		while ( $row = $stmt->fetchObject () ) {
			$ilmoitus = new Ilmoitus ();
				
			$ilmoitus->setId ( $row->id );
			$ilmoitus->setNimi( utf8_encode ( $row->nimi ) );
			$ilmoitus->setSukupuoli( utf8_encode ( $row->sukupuoli ) );
			$ilmoitus->setEmail( utf8_encode ( $row->email ) );
			$ilmoitus->setPuhnro( $row->puh );
			$ilmoitus->setPaikkakunta( utf8_encode ( $row->paikkakunta ) );
			$ilmoitus->setViesti( utf8_encode ( $row->viesti ) );
				
			$tulos [] = $ilmoitus;
		}
	
		$this->lkm = $stmt->rowCount ();
	
		return $tulos;
	}
	
	
	public function poistaIlmoitus($id) {
		$sql = "DELETE FROM ilmoitus
				WHERE id = :id";
	
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		$stmt->bindValue ( ":id", $id, PDO::PARAM_INT );
	
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
				
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
	
		return $tulos;
	}
	
	function lisaaIlmoitus($ilmoitus) {
		$sql = "INSERT INTO ilmoitus VALUES (null, :nimi, :sukupuoli, :email, :puhnro, :paikkakunta, :viesti)";
		
		// Valmistellaan SQL-lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		// Parametrien sidonta
		$stmt->bindValue ( ":nimi", utf8_decode ( $ilmoitus->getNimi() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":sukupuoli", utf8_decode ( $ilmoitus->getSukupuoli() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":email", utf8_decode ( $ilmoitus->getEmail() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":puhnro", utf8_decode ( $ilmoitus->getPuhnro() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":paikkakunta", utf8_decode ( $ilmoitus->getPaikkakunta() ), PDO::PARAM_STR );
		$stmt->bindValue ( ":viesti", utf8_decode ( $ilmoitus->getViesti() ), PDO::PARAM_STR );
		
		// Jotta id:n saa lisäyksestä, täytyy laittaa tapahtumankäsittely päälle
		$this->db->beginTransaction();
		
		// Suoritetaan SQL-lause (insert)
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			 
			// Perutaan tapahtuma
			$this->db->rollBack();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$this->lkm = 1;
		
		// id täytyy ottaa talteen ennen tapahtuman päättymistä
		$id = $this->db->lastInsertId ();
		
		$this->db->commit();
		
		// Palautetaan lisätyn ilmoituksen id
		return $id;
	}
}
?>