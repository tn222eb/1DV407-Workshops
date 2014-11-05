<?php

namespace model;

require_once("src/Model/Repository.php");

class BoatRepository extends \Repository {
	private $BoatId = 'BoatId';
	private $BoatLength = 'BoatLength';
	private $BoatType = 'BoatType';
	private $UniqueMemberId = "UniqueMemberId";
	private $BoatUniqueId = 'BoatUniqueId';
	private $db;


	public function __construct() {
		$this->dbTable = 'Boat';
		$this->db = $this->connection();
	}

	public function addBoat(\model\Boat $boat) {
		try {
			$sql = "INSERT INTO $this->dbTable (". $this->BoatLength .", ". $this->BoatType. ", " . $this->UniqueMemberId . ", " . $this->BoatUniqueId . " ) VALUES (?,?,?,?)";
			$params = array($boat->getBoatLength(), $boat->getBoatType() , $boat->getUniqueMemberId(), $boat->getBoatUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function removeBoat(\model\Boat $boat) {
		try {
			$sql = "DELETE FROM $this->dbTable WHERE $this->BoatUniqueId = ?";
			$params = array($boat->getBoatUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function saveEditBoat(\model\Boat $boat) {
		try {
			$sql = "UPDATE $this->dbTable SET " . $this->BoatLength . " = ? ," . $this->BoatType . " = ? WHERE $this->BoatUniqueId = ?";
			$params = array($boat->getBoatLength(), $boat->getBoatType(), $boat->getBoatUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function getBoat($uniqueBoatId) {
		try {
			$sql = "SELECT * FROM $this->dbTable WHERE (" . $this->BoatUniqueId . ") = ?";
			$params = array($uniqueBoatId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();

			if ($result) {
				return $boat = new \model\Boat($result[$this->BoatLength], $result[$this->BoatType], $result[$this->getUniqueMemberId], $result[$this->BoatUniqueId]);
			}

			return NULL;
		}
		catch (\Exception $e) {
			echo $e;
		}
	}
}